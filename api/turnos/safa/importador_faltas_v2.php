<?php
	date_default_timezone_set('America/Buenos_Aires');
	include "../lib/funciones.php";
	$dbh = crear_pdo();

	$archivo = "V_Causas_SLIC.csv";
	$res = '';
	
	$fecha_creac_csv = strtotime ( '+1 day' , strtotime (date('Y-m-d h:i:s',filectime($archivo) ) ) ) ; 
	//echo "Fecha +1: ".date ( 'Y-m-d h:i:s' , $fecha_creac_csv )."<br>";
	//echo "Fecha   : ".date('Y-m-d h:i:s',filectime($archivo));
	//die();
	
	function guardarLogImportacion( $fop,$regta,$regcsv,$fecsv,$res ) {
		$dbh = crear_pdo();
		$query = "INSERT INTO logs_importacion ( fecha_operacion, reg_en_tabla, reg_en_csv, fecha_creacion_csv, resumen ) VALUES ( ?, ?, ?, ?, ? )";
		$sth = $dbh->prepare( $query );
		if ( $sth ) {
			$sth->execute( array( $fop,$regta,$regcsv,$fecsv,$res ));
		}
	}
	//echo "Modificado: ".date('Y-m-d h:i:s',filemtime($archivo)).' - Creado: '.date('Y-m-d h:i:s',filectime($archivo));die();
	
	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();
		
		//-----------------------------------//-----------------------------------//-----------------------------------//-----------------------------------
			$msg_comprobacion = Null;
			//Cuento la cantidad de registros que contiene la tabla "causas"...
			$sth = $dbh->prepare("SELECT count(*) AS cuenta FROM causas");
			$sth->execute();
			if( $row = $sth->fetch() ) $registros_en_tabla = $row[0];
			$msg_comprobacion = $registros_en_tabla." en tabla. ";
			
			//Cuento la cantidad de registros del archivo a importar...
			$registros_en_archivo = count(file($archivo));
			$msg_comprobacion .= " - ".$registros_en_archivo." en archivo. - ";
			
			$dif_tabla_archivo = $registros_en_tabla - $registros_en_archivo;
			//echo $registros_en_archivo;die();
			
			//Si $registros_en_tabla - $registros_en_archivo >= 2000 entonces no ejecutar nada ya que existe una discrepancia
			//muy grande respecto a la importacion anterior.
			$registros_ok = False;
			$die = False;
			$msg_comprobacion .= $dif_tabla_archivo." de diferencia. ";
			if ( $dif_tabla_archivo <= 500000 ) {
				$registros_ok = True;
				$msg_comprobacion .= "OK, hacer TRUNCATE E INSERT.-----------";
			} else {
				$msg_comprobacion .= "Cancelar ejecusion.-----------";
				$die = True;
			}
			$fecha_importacion = date('Y-m-d h:i:s');
			$fd = fopen("./log/estado_importacion_log.txt", "a+");
			fwrite( $fd, $fecha_importacion."\\Resultado de la comprobación: \\".$msg_comprobacion."\n");
			if ( $die ) die();
		//-----------------------------------//-----------------------------------//-----------------------------------//-----------------------------------
		
		$estado_truncate = false;
		if ( $registros_ok && $registros_en_archivo > 1 ) {
			$estado_truncate = $dbh->query("TRUNCATE TABLE causas");
		} else {
			$res .= 'Se impidi&oacute; TRUNCATE. La importaci&oacute;n fue abortada.';
				if ($registros_en_archivo == 1) $res .= ' Archivo vac&iacute;o.';
			guardarLogImportacion( date('Y-m-d h:i:s'),$registros_en_tabla,$registros_en_archivo,date( 'Y-m-d h:i:s' , $fecha_creac_csv ),$res );
		}
		if ( $estado_truncate && $registros_ok ) { //Si pudo borrar los datos de la tabla...
			$estado = false;
			$cnt_insertados = 0;
			$row = 0;
			$handle = fopen("V_Causas_SLIC.csv", "r");
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { //Lee toda una linea completa, e ingresa los datos en el array 'data'
				$num = count($data); //Cuenta cuantos campos contiene la linea (el array 'data')
				$cadena = "INSERT INTO `causas`(`ID_Tipo_Acta`,`Nro_Acta`,`Total_UND_Fijas`,`Total_Concepto`,`Q_Infracciones`,`Causa_Anio`,`Causa_Nro`,`Causa_Fecha`,`Tipo_Doc`,`Nro_Doc`,`Valor_UF`,`Fecha_Acta`,`Patente`,`Localidad_Acta`,`Accion`,`Descripcion_Estado`,`Codigo_Estado`) VALUES (";
				for ($c=0; $c < $num; $c++) { //Aquí va colocando los campos en la cadena, si aun no es el último campo, le agrega la coma (,) para separar los datos
					if ($c <= $num) {
						if ($c==($num-1)) {
							if ( $c == 7 || $c == 8 || $c == 11 || $c == 12 || $c == 13 || $c == 14 || $c == 15 )  {
								if ( $data[$c] == null ) {
									$data[$c] = 0.00;
									
								}
								$cadena = $cadena."'".$data[$c]."'";
							} else {
								if ( $data[$c] == null ) {
									$data[$c] = 0.00;
									
								}
								$cadena = $cadena.$data[$c];
							}
						} else {
							if ( $c == 7 || $c == 8 || $c == 11 || $c == 12 || $c == 13 || $c == 14 || $c == 15 )  {
								if ( $data[$c] == null ) {
									$data[$c] = 0.00;
									
								}
								$cadena = $cadena."'".$data[$c]."',";
							} else {
								if ( $data[$c] == null ) {
									$data[$c] = 0.00;
									
								}
								$cadena = $cadena.$data[$c].",";
							}
						}
					}
				}
				
				$cadena = $cadena.");"; //Termina de armar la cadena para poder ser ejecutada
				
				$estado = $dbh->query($cadena);
				if ($estado) $cnt_insertados++;
				$row++;
				//echo "<br>".$cadena;
				//die();
			}
		} else {
			die();
		}
		
		if ( $dbh->commit() ) { //Si salio todo bien, de todas formas que guarde un registro de la actividad y los resultados.
			$msg = $row. " Registros leidos. - ".$cnt_insertados." Registros insertados.";
			$fecha_importacion = date('Y-m-d h:i:s');
			$fd = fopen("./log/estado_importacion_log.txt", "a+");
			fwrite( $fd, "  ".$fecha_importacion."\\Importador de faltas: \\".$msg."\n");
			echo $msg;
		}
	} catch( PDOException $e){
		$dbh->rollback();
		$error = $e->getMessage();
		$fecha_error = date('Y-m-d h:i:s');
		
		$fd = fopen("./log/errorlog.txt", "a");
		fwrite( $fd, "  ".$fecha_error."\\Importador de faltas: \\".$cadena.'  -  '.$error."\n");
		$res .= 'Error en la importaci&oacute;n. ';
		echo '<script>alert("Error al importar los datos.");</script>';
	}
	
	//Armo string de comentario resumen en la tabla logs de importacion...
	if ($registros_en_tabla == null || $registros_en_tabla == 0) {
		$registros_en_tabla = 0;
		$res .= 'Tabla vac&iacute;a. ';
	}
	if ($registros_en_archivo == null || $registros_en_archivo == 0 || $registros_en_archivo == 1) {
		$registros_en_archivo = 0;
		$res .= 'Archivo vac&iacute;o. ';
	}
	guardarLogImportacion( date('Y-m-d h:i:s'),$registros_en_tabla,$registros_en_archivo,date ( 'Y-m-d h:i:s' , $fecha_creac_csv ),$res );
	
	$dbh = null;
	fclose($fd);
	fclose($handle);

?>
<!--<h2>Se insertaron <?php //echo $row.' - '.$cnt_insertados ?> Registros en la tabla "causas"</h2>-->
