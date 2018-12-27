<?php
	//Activar errores
	header('Content-Type: text/html; charset=UTF-8'); 
	ini_set('display_errors', 'On');
	ini_set('display_errors', 1);
	date_default_timezone_set('America/Buenos_Aires');
	//ini_set("session.cookie_lifetime","1");
	//ini_set("session.gc_maxlifetime","1");
	//session_start();
	
	function crear_pdo() {
			$hostname = 'localhost';
			$password = '';
			$username = 'root';
			$password = '';
			$password = '99LeVTrt';
			$db = 'turnos_05082016';
			try {
				return new PDO("mysql:host=$hostname;dbname=$db", $username, $password);
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
	}
	
	function cntTurnos( $esPublico ) {
		$dbh = crear_pdo();
		if ( $esPublico == 1 ) {
			$query = "SELECT * FROM horarios WHERE publico = 1";
		} else {
			$query = "SELECT * FROM horarios WHERE publico = 0";
		}
		$cnt = $dbh->prepare( $query );
		$cnt->execute();
		return $cnt->rowCount();
	}
	
	function ipCliente() {
		if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
			return $ip=$_SERVER['HTTP_CLIENT_IP'];
		} elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			return $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			return $ip=$_SERVER['REMOTE_ADDR'];
		}
	}
	
	function guardarLog( $sql ) {
		$dbh = crear_pdo();
		$fecha = date('Y-m-d h:i:s');
		$ip = ipCliente();
		$query = "INSERT INTO logs_aplicacion ( fecha_hora, ip, aplicacion, query ) VALUES ( ?, ?, ?, ? )";
		$sth = $dbh->prepare( $query );		
		if ( $sth ) {
			$sth->execute( array( $fecha, $ip, 1, $sql ));
		}
	}
	
	function nomDia($fecha_ingles){
		$f = explode("-", $fecha_ingles);
		$d1 = $f[0];
		$m1 = $f[1];
		$y1 = $f[2];
		setlocale(LC_TIME, 'spanish');  
		$nombre=strftime("%A",mktime(0, 0, 0, $m1, $y1, $d1)); 
		return $nombre;
	}
	
	function nomMes($mes) {
		if ( $mes == 1 ) {
			$nombre = "Enero";
		} else if ( $mes == 2 ) {
			$nombre = "Febrero";
		} else if ( $mes == 3 ) {
			$nombre = "Marzo";
		} else if ( $mes == 4 ) {
			$nombre = "Abril";
		} else if ( $mes == 5 ) {
			$nombre = "Mayo";
		} else if ( $mes == 6 ) {
			$nombre = "Junio";
		} else if ( $mes == 7 ) {
			$nombre = "Julio";
		} else if ( $mes == 8 ) {
			$nombre = "Agosto";
		} else if ( $mes == 9 ) {
			$nombre = "Septiembre";
		} else if ( $mes == 10 ) {
			$nombre = "Octubre";
		} else if ( $mes == 11 ) {
			$nombre = "Novimebre";
		} else if ( $mes == 12 ) {
			$nombre = "Diciembre";
		} else {
			$nombre = "No contemplado.";
		}	
		return $nombre;
	}
	
	function grabarLogNoPermitido($usuario,$password) {
		$dbh = crear_pdo();
		$sth2 = $dbh->prepare("INSERT INTO logs_intentos (usuario, password, fechaHora) VALUES (?,?,?)");
		$sth2->execute(array($usuario, $password, date("Y-m-d H:i:s")));
	}
	
	function verificaDNI($dni) {
		$dbh = crear_pdo();
		$query = "SELECT * FROM vencimientos WHERE dni = ? AND venc_estado = 0";
		$faltas = $dbh->prepare( $query );
		$faltas->execute( array($dni) );
		$total = $faltas->rowCount();
		return $total;
	}
	
	function verificaCausa($dni) {
		$dbh = crear_pdo();
		$query = "SELECT * FROM causas WHERE Nro_doc = ?";
		$faltas = $dbh->prepare( $query );
		$faltas->execute( array($dni) );
		$total = $faltas->rowCount();
		$causas = "";
		if ($total > 0) {
			$causas = "Causa pendiente.";
		} else {
			$causas = "";
		}
		return $causas;
	}
	
	function verificaCausa2($dni) {
		$dbh = crear_pdo();
		$query = "SELECT SUM(Valor) AS Valor FROM v_causas WHERE DNI = ?";
		$faltas = $dbh->prepare( $query );
		$faltas->execute( array($dni) );
		$total = $faltas->rowCount();
		$causas = null;
		if ($total > 0) {
			while ( $row = $faltas->fetch() ) {
				$causas = $row["Valor"];
			}
		} else {
			$causas = "";
		}
		return $causas;
	}
	
	function VerificaCausas ( $tipo, $dni ) {
		$dbh = crear_pdo();
		$query1 = "SELECT * FROM causas WHERE Tipo_Doc = ? AND Nro_doc = ?";
		$faltas = $dbh->prepare( $query1 );
		$faltas->execute( array($tipo, $dni) );
		$total = $faltas->rowCount();
		$causas = "";
		if ($total > 0) {
			$causas = "Le informamos que al día de la fecha Usted posee Infracciones de Tránsito pendientes. Para concluir con el trámite de la Licencia de Conducir";
			$causas .= " deberá regularizar dicha situación acercándose a los siguientes lugares: Palacio Municipal, Juzgado de Faltas, Oficina de Licencias de Conducir.";
		}
		////Descomentar estas lineas para mostrar detalle de la deuda si se requiere./////
		/*$causas[] = null;
		if ($total > 0) {
			//echo $total.'<br><br>';
			$cnt=0;
			while ( $row = $faltas->fetch() ) {
				$causas[$cnt] = $row["Tipo"].'&nbsp'.$row["DNI"].'&nbsp'.$row["Apellido_Nombre"].'&nbsp'.$row["Num_Acta"].'&nbsp'.$row["Nro_Causa"].'&nbsp'.$row["Fecha_Acta"].'&nbsp'.$row["Valor"].'&nbsp'.$row["Dominio"].'<br>';
				$cnt++;
			}
		}*/
		return $causas;
	}
	
	function compararFechas2( $fecha, $hoy ) {
		$valoresPrimera = explode ("-", $fecha);
		$valoresSegunda = explode ("-", $hoy);
		$diaPrimera = $valoresPrimera[2];
		$mesPrimera = $valoresPrimera[1];
		$anyoPrimera = $valoresPrimera[0];
		$diaSegunda = $valoresSegunda[0];
		$mesSegunda = $valoresSegunda[1];
		$anyoSegunda = $valoresSegunda[2];
		$diasPrimeraJuliano = gregoriantojd( $mesPrimera, $diaPrimera, $anyoPrimera );
		$diasSegundaJuliano = gregoriantojd( $mesSegunda, $diaSegunda, $anyoSegunda );
		if( !checkdate( $mesPrimera, $diaPrimera, $anyoPrimera ) ) {
			// "La fecha ".$fecha." no es valida";
			return 0;
		} elseif ( !checkdate( $mesSegunda, $diaSegunda, $anyoSegunda ) ) {
			// "La fecha ".$hoy." no es valida";
			return 0;
		} else {
			return $diasPrimeraJuliano - $diasSegundaJuliano;
		}
	}
	
	function generaFechaTurno ( $vencimiento ) {
		setlocale ( LC_TIME, 'spanish' ); //Cambio la configuración de tiempo en PHP a nuestra región
		//$vencimiento = date('Y/m/d'); //Linea agregada 09/08/2016. Funcion pincha cuando quiere calcular los arrays con las fechas posibles
									    // en base al vencimiento real de la licencia.
		//$vencimiento = '2017/01/15';
		function compararFechas( $fecha, $hoy ) {
			$valoresPrimera = explode ("/", $fecha);
			$valoresSegunda = explode ("/", $hoy);
			$diaPrimera = $valoresPrimera[0];
			$mesPrimera = $valoresPrimera[1];
			$anyoPrimera = $valoresPrimera[2];
			$diaSegunda = $valoresSegunda[0];
			$mesSegunda = $valoresSegunda[1];
			$anyoSegunda = $valoresSegunda[2];
			$diasPrimeraJuliano = gregoriantojd( $mesPrimera, $diaPrimera, $anyoPrimera );
			$diasSegundaJuliano = gregoriantojd( $mesSegunda, $diaSegunda, $anyoSegunda );
			if( !checkdate( $mesPrimera, $diaPrimera, $anyoPrimera ) ) {
				// "La fecha ".$fecha." no es valida";
				return 0;
			} elseif ( !checkdate( $mesSegunda, $diaSegunda, $anyoSegunda ) ) {
				// "La fecha ".$hoy." no es valida";
				return 0;
			} else {
				return $diasPrimeraJuliano - $diasSegundaJuliano;
			}
		}

		function calcularFinSem ( $f ) {
			$dia_sem = date("N", strtotime($f));
			if($dia_sem == 6 or $dia_sem == 7) {
				return false;
			} else {
				return true;
			}
			return true;
		}

		function esFeriado ( $dia ) {
			$dbh = crear_pdo();
			$feriado_query = "SELECT fecha FROM feriados WHERE fecha = ?";
			$fer = $dbh->prepare( $feriado_query );
			$fer->execute( array($dia) );
			$datos_feriado = $fer->fetch();
			if ( $fer->rowCount() == 0 ) {
				return false;
			} else {
				return true;
			}
		}

		//Calculo dias de vencimiento antes y despues de la fecha
		//que figura en la licencia.
		$cnt = 0; //Inicializo en 0 para que me cuente el día del vencimiento inclusive.
		$indice = 0;
		$fecha_propuesta1 = Array();
		while ( $cnt <= 30 ) { //Linea modificada el 21/11/2016 pedido por PASSINI "while ( $cnt <= 45 ) {"
			$fecha = date("d/m/Y", strtotime("$vencimiento - $cnt day"));
			$f = explode("/", $fecha);
			$d1 = $f[0];
			$m1 = $f[1];
			$y1 = $f[2];
			$f1 = $y1."/".$m1."/".$d1;
			if ( compararFechas($fecha, date('d/m/Y')) >= 0 ) { //Pregunto si prox. fecha a proponer es pasado el dia de hoy, caso contrario no la propongo
				if ( !esFeriado($f1) ) { //Pregunto por si el dia es feriado. Tomo datos de MySQL.
					if ( calcularFinSem ( $f1 ) ) { //Pregunto si es fin de semana.
						$fecha_propuesta1[$indice] = $fecha;
						$indice++;
					}
				}
			}
			$cnt++;
		}
		krsort($fecha_propuesta1); //Ordeno de menor a mayor las fechas guardadas en el array.

		$cnt = 1; //Inicializo en 1 para que no me cuente el día del vencimiento (Ya lo inlui en calculo anterior).
		$fecha_propuesta2 = Array();
		while ( $cnt <= 365 ) {  //Linea modificada el 13/09/2016 pedido por PASSINI "while ( $cnt <= 90 ) {"
			$fecha = date("d/m/Y", strtotime("$vencimiento + $cnt day"));
			$f = explode("/", $fecha);
			$d1 = $f[0];
			$m1 = $f[1];
			$y1 = $f[2];
			$f1 = $y1."/".$m1."/".$d1;
			if ( compararFechas($fecha, date('d/m/Y')) >= 0 ) {
				if ( calcularFinSem ( $f1 ) ) {
					if ( !esFeriado($f1) ) {
						$fecha_propuesta2[$indice] = $fecha;
						$indice++;
					}
				}
			}
			$cnt++;
		}
		//Vuelvo a generar el array e incremento en 1 su índice para que el value del HTML sea 1 en vez de cero...
		/*print_r($fecha_propuesta1)."<br><br>";
		print_r($fecha_propuesta2)."<br><br>";*/
		//$ret = "dd";
		$fecha_propuesta3 = array_merge($fecha_propuesta1, $fecha_propuesta2);
		for($i = 0; $i < count($fecha_propuesta3); $i++) {
			$ret[($i + 1).",$fecha_propuesta3[$i]"] = $fecha_propuesta3[$i];
		}
		return $ret;
	}

	//Funcion que me sirve para filtrar a los que estan autorizados a solicitar el turno.
	function autorizaSolicitud ( $vencimiento ) {
		$desdeHasta = Array();
		$desdeHasta[0] = date("Y-m-d", strtotime("$vencimiento - 90 day"));
		$desdeHasta[1] = date("Y-m-d", strtotime("$vencimiento + 45 day"));
		return $desdeHasta;
	}

	//Funcion reemplazada por verificarSolicitud_2 (25/02/2013)
	/*function verificarSolicitud ( $vencimiento ) {
		$hoy = date("Y-m-d");
		$desdeHasta[0] = date("Y-m-d", strtotime("$hoy - 90 day"));
		$desdeHasta[1] = date("Y-m-d", strtotime("$hoy + 30 day"));
		if ( $desdeHasta[0] <= date("Y-m-d", strtotime($vencimiento )) )
			if ( $desdeHasta[1] >= date("Y-m-d", strtotime($vencimiento )) ) {
				return true;
		} else {
			return false;
		}
	}*/
	
	function verificarSolicitud_2 ( $vencimiento ) {
		$fecha = $vencimiento;
		$segundos = strtotime($fecha) - strtotime('now');
		$diferencia_dias = intval($segundos/60/60/24);
		
		if ( $diferencia_dias >= 0 && $diferencia_dias <= 45 ) {
			return 1; //echo 'Renueva normalmente'; //Devuelve true
		} else if ( $diferencia_dias < 0 && $diferencia_dias >= -90 ) {
			return 2; //echo 'Renueva pero no puede conducir. (Vencido dentro de los 90 dias)'; // Devuelve true
		} else if ( $diferencia_dias < -90 ) {
			return 3; //echo 'Carnet vencido por mas de 90 dias. No puede conducir.'; //Devuelve false
		} else {
			return 0; //echo 'Vence mucho mas adelante que el periodo contemplado. Ej.:2014,2015,2016,etc..';
		}
	}
	
	function verificarCantidadDeTurnos ( $dni ) {
		$dbh = crear_pdo();
		$sth = $dbh->prepare("SELECT * FROM turnos WHERE dni_vencimiento = ? AND fecha_anulado IS NULL");
		$sth->execute( array($dni) );
		if( $row = $sth->fetch() ) {
			$total = $sth->rowCount();
			if ( $total >= 1 && $row ['id_turno'] <> 0 && compararFechas2( $row['fecha_turno'] , date('d-m-Y') ) > 0  ) {
				return True; //echo 'Ud. ya tiene un turno asignado...';
			} else return False; //echo 'Continua';
		}
		return False;
	}
	
	//Mejora version anterior...
	function verificarCantidadDeTurnos2 ( $dni ) {
		$dbh = crear_pdo();
		$sth = $dbh->prepare("SELECT * FROM turnos WHERE dni_vencimiento = ? AND fecha_anulado IS NULL AND fecha_turno >= ? ");
		$sth->execute( array($dni,date('Y-m-d')) );
		$return = Null;
		if( $row = $sth->fetch() ) {
			$total = $sth->rowCount();
			if ( $total >= 1 ) {
				$return = True; //echo 'Ud. ya tiene un turno asignado...';
			} else $return = False; //echo 'Continua';
		}
		return $return;
	}
	
	function verificar72Turnos2 ( $fecha ) { //Funcion que me indica si ya fueron asignados 72 turnos.
		$dbh = crear_pdo();
		$sth = $dbh->prepare("SELECT * FROM turnos WHERE fecha_turno = ? AND fecha_anulado IS NULL ");
		$sth->execute( array($fecha) );		
		$total = $sth->rowCount();
		if ( $total <= 96 ) {	
			return True; //Aun pueden otorgarse turnos;
		} else {				
			return False; //Todos los turnos fueron asignados.;
		}
	}
	
	function verificar72Turnos ( $fecha ) { //Funcion que me indica si ya fueron asignados 72 turnos.
		$dbh = crear_pdo();
		$sth = $dbh->prepare("SELECT * FROM turnos WHERE fecha_turno = ? AND fecha_anulado IS NULL ");
		$sth->execute( array($fecha) );		
		$total = $sth->rowCount();		
		if ($total==0){
			return True;
		}		
		if( $row = $sth->fetch() ) {
			$total = $sth->rowCount();
			if ( $total < 96 ) {			
				return True; //Aun pueden otorgarse turnos;				
			} else if ( $total >= 96 ) {				
				return False; //Todos los turnos fueron asignados.;
			}
		}		
		return True;
	}
	
	function generoComprobante ( $fecha_turno, $turno_asignado, $persona, $dni, $sobreturno, $tipo_dni ) {
		//Creo objeto FPDF.
		$pdf = new FPDF();

		$hoy = date("d-m-Y");
		$anio = date("Y");
		$piePag = "Municipalidad de Luján $anio - Intendencia: DR. OSCAR LUCIANI";

		$pdf->AddPage();
		$pdf->SetFont('Arial','',12);
		if ( $sobreturno ) { //Si es cierto es un sobreturno
			$pdf->Image('../../img/logo_mun.jpg',11,12,50,0);
		} else $pdf->Image('../img/logo_mun.jpg',11,12,50,0); //Sino es un turno comun.
		$pdf->Cell(190,120,'',1,1,'C');

		$pdf->SetFont('Arial','',8);
		$string = "Fecha de Impresión: $hoy";
		$pdf->Text(157,15,$string);
		$pdf->SetFont('Arial','',14);
		$pdf->Text(70,28,'COMPROBANTE DE GESTIÓN ON-LINE');
		$pdf->Text(70,33,'PARA LA RENOVACIÓN DE LICENCIAS DE CONDUCIR');

		//Ubico y muestro la fecha del turno.
		$pdf->SetFont('Arial','',12);
		$pdf->Text(90,55,'Fecha del Turno:');
		$pdf->SetFont('Arial','',24);
		$pdf->Text(82,63,"$fecha_turno");

		//Ubico y muestro el turno asignado (orden y puesto).
		$pdf->SetFont('Arial','',12);
		$pdf->Text(92,75,'Turno Asignado:');
		$pdf->SetFont('Arial','',24);
		$pdf->Text(76,83,"$turno_asignado");

		//Ubico y muestro datos del solicitante.
		$pdf->SetFont('Arial','',12);
		$pdf->Text(11,93,"Nombre: $persona");
		$pdf->SetFont('Arial','',12);
		$pdf->Text(11,98,"DNI: $dni");

		//Imprimo mensaje de si tiene deudas por faltas.
		$msj_deuda = '';
		$pdf->SetFont('Arial','I',9);
		if ( VerificaCausas( $tipo_dni, $dni ) != '' ) {
			$msj_deuda = 'Le informamos que al día de la fecha Usted posee Infracciones de Tránsito pendientes de pago/resoluci&oacute;n.';
			$pdf->Text(22,108,"$msj_deuda");
			$msj_deuda = 'Para concluir con el trámite de la Licencia de Conducir deberá regularizar dicha situación acercándose a los siguientes';
			$pdf->Text(22,112,"$msj_deuda");
			$msj_deuda = 'lugares: Palacio Municipal, Juzgado de Faltas, Oficina de Licencias de Conducir.';
			$pdf->Text(22,116,"$msj_deuda");
		} else {
			$msj_deuda = 'No existen faltas pendientes de pago o resolución.';
			$pdf->Text(22,108,"$msj_deuda");
		}
		$pdf->ln(-26);
		$pdf->Cell(10);
		$pdf->Cell(170,14,'',1,1,'C');
		//Fin mensaje de deudas.
		
		$pdf->SetFont('Arial','',10);
		$msg = "Recuerde que el día del Turno solicitado, Ud. deberá presentarse con toda la documentación ";
		$pdf->Text(11,124,"$msg");
		$msg2 = "correspondiente debidamente cumplimentada tal como figura en nuestro sitio web www.lujan.gov.ar";
		$pdf->Text(11,128,"$msg2");
		
		$pdf->Ln(12);
		$pdf->SetFont('Arial','',8);
		$pdf-> Cell(0,10,"$piePag" ,0,0,'C');

		//Genero documento PDF.
		$pdf->Output('comprobante.pdf','I');
	}
	
	function generoComprobante2( $tipo_dni,$dni,$fecha_turno,$hora,$turno,$apeNom,$tel,$tipo_tramite,$ruta_fondo,$ruta_msj_falta,$ruta_form_menor,$procedencia ) {
				
		//$a = $tipo_dni.' = '.$dni.' = '.$fecha_turno.' = '.$hora.' = '.$turno.' = '.$apeNom.' = '.$tel.' = '.$tipo_tramite.' = '.$ruta_fondo.' = '.$ruta_msj_falta.' = '.$ruta_form_menor.' = '.$procedencia;
		
		//Creo objeto FPDF.
		$pdf = new FPDF();
		$pdf->SetFont('Arial','',12);
		$pdf->Image($ruta_fondo,null,null,210,297,'jpg');
		
		$pdf->Text(119,26," - Emisión: ".date('d/m/Y'));
		
		$ruta_img_instructivo = null;
		$form_menor = false;
//-------PAGINA 1-------//
		//-----MENSAJE TIPO DE TRAMITE
		$pdf->SetFont('Arial','',9);
		$src = "";
		if( $procedencia == "Sobretur" ) $src = "../";
		else $src = "";
		if( $tipo_tramite == 1 ) {
			$pdf->Text(140,56,'Trámite: Renueva en período correspondiente.');
			$ruta_img_instructivo = "../".$src."img/instructivos/1.jpg";
		} elseif( $tipo_tramite == 2 ) {
			$pdf->Text(140,56,'Trámite: Otorgamiento (1° vez).');
			$ruta_img_instructivo = "../".$src."img/instructivos/2.jpg";
		} elseif( $tipo_tramite == 3 ) {
			$pdf->Text(140,56,'Trámite: Renov., Lic. vencida dentro 90 días.');
			$ruta_img_instructivo = "../".$src."img/instructivos/1.jpg";
		} elseif( $tipo_tramite == 4 ) {
			$pdf->Text(140,56,'Trámite: Renov., Lic. vencida mas 90 días.');
			$ruta_img_instructivo = "../".$src."img/instructivos/2.jpg";
		} elseif( $tipo_tramite == 5 ) {
			$pdf->Text(140,56,'Trámite: Duplicado por robo/extravío.');
			$ruta_img_instructivo = "../".$src."img/instructivos/5.jpg";
		} elseif( $tipo_tramite == 6 ) {
			$pdf->Text(140,56,'Trámite: Ampliación de categorías.');
			$ruta_img_instructivo = "../".$src."img/instructivos/6.jpg";
		} elseif( $tipo_tramite == 7 ) {
			$pdf->Text(140,56,'Trámite: Otorgamiento (1° vez - Menor).'); 
			$ruta_img_instructivo = "../".$src."img/instructivos/7.jpg";
			$form_menor = true;
		} else {
			$pdf->Text(140,56,'ERROR: Revise la solicitud.');
		}
		
		$pdf->SetFont('Arial','',12);
		
		//-----FECHA
		$f = explode ("-", $fecha_turno);
		$d1 = $f[0];
		$m1 = $f[1];
		$y1 = $f[2];
		$pdf->Text(50,56,$d1);//Año
		$pdf->Text(37,56,$m1);//Mes
		$pdf->Text(22,56,$y1);//Día
		//-----HORA
		$h = explode("-", $hora);
		$ho = $h[0];
		$pdf->Text(85,56,$ho);//Hora
		//-----TURNO
		$pdf->Text(130,56,$turno);
		//-----APELLIDO Y NOMBRE
		$pdf->Text(42,80,$apeNom);
		//-----DNI
		$pdf->Text(145,87,$dni);
		//-----TIPO DNI
		$pdf->SetFont('Arial','B',16);
		if( $tipo_dni == 'DNI' ) {
			$pdf->Text(41,89,"*");
		} else if ( $tipo_dni == 'LC' ) {
			$pdf->Text(55,89,"*");
		} else if ( $tipo_dni == 'LE' ) {
			$pdf->Text(69,89,"*");
		} else $pdf->Text(97,89,"*");
		$pdf->SetFont('Arial','',12);
		//-----TELEFONO
		$pdf->Text(26,109,$tel);
		
		//-------------VERIFICO DEUDA DE FALTAS
		if ( VerificaCausas( $tipo_dni, $dni ) != '' ) {
			$pdf->Image($ruta_msj_falta,4,57,200,8,'jpg');
		} else {
			$msj_deuda = 'NO EXISTEN FALTAS PENDIENTES DE RESOLUCIÓN.';
			$pdf->Text(4,63,"$msj_deuda");
		}
//-------FIN PAGINA 1-------//

//-------PAGINA 2-------//
		//-------MENSAJE PRINCIPAL.
		$pdf->addPage();
		$pdf->Cell(190,40,'',1,1,'L');
		$pdf->SetFont('Arial','U',12);
		$pdf->Text(15,20,"IMPORTANTE:");
		$pdf->SetFont('Arial','',11);
		$pdf->Text(20,27,"Todo lo que debe hacer es previo al día del Turno (48 Hs. antes). El mismo es para finalizar y generar");
		$pdf->Text(20,32,"el Trámite de la Licencia. En caso de no tener cumplimentada la documentación requerida deberá");
		$pdf->Text(20,37,"comunicarse con la oficina de Licencias y anular el turno para luego solicitar uno nuevo, caso contrario,");
		$pdf->Text(20,42,"el sistema no le permitirá volver a sacar un turno.");
		
		//--------IMAGEN DE INSTRUCTIVO.
		if( $ruta_img_instructivo != null) {
			$pdf->Image($ruta_img_instructivo,10,52,190,0,'jpg');
			if( $form_menor ) { //Si es un tramite de menor de edad imprimo el otro formulario.
				$pdf->Image($ruta_form_menor,null,null,190,280,'jpg');
			}
		}
//-------FIN PAGINA 2-------//
				
		//Genero documento PDF.
		$pdf->Output();
	}
	
	//Se agrego ultimo parametro para indicar si genero vista previa o fuerzo la descarga.
	function generoComprobante3( $tipo_dni,$dni,$fecha_turno,$hora,$turno,$apeNom,$tel,$tipo_tramite,$ruta_fondo,$ruta_msj_falta,$ruta_form_menor,$procedencia,$descargar ) {
				
		function obtenerEMAIL($dni,$tipo_dni) {
		$dbh = crear_pdo();
		$query = "SELECT email AS Email FROM vencimientos WHERE dni = ? AND tipo_dni = ?";
		$dirmail = $dbh->prepare( $query );
		$dirmail->execute( array($dni,$tipo_dni) );
		$total = $dirmail->rowCount();
		$mail = null;
		if ($total > 0) {
			while ( $row = $dirmail->fetch() ) {
				$mail = $row["Email"];
			}
		} else {
			$mail = "";
		}
		return $mail;
	}
		
		//$a = $tipo_dni.' = '.$dni.' = '.$fecha_turno.' = '.$hora.' = '.$turno.' = '.$apeNom.' = '.$tel.' = '.$tipo_tramite.' = '.$ruta_fondo.' = '.$ruta_msj_falta.' = '.$ruta_form_menor.' = '.$procedencia;
		
		//Creo objeto FPDF.
		$pdf = new FPDF();
		$pdf->SetFont('Arial','',12);
		$pdf->Image($ruta_fondo,null,null,210,297,'jpg');
		
		$pdf->Text(119,26," - Emisión: ".date('d/m/Y'));
		
		//$ruta_img_instructivo = null;
		//$form_menor = false;
//-------PAGINA 1-------//
		//-----MENSAJE TIPO DE TRAMITE
		$pdf->SetFont('Arial','',9);
		$src = "";
		if( $procedencia == "Sobretur" ) $src = "../";
		else $src = "";
		/*DESCOMENTAR TODO ESTO PARA QUE VUELVA A APARECER LA 2° PAGINA (07/06/2016)
		if( $tipo_tramite == 1 ) {
			$pdf->Text(140,56,'Trámite: Renueva en período correspondiente.');
			$ruta_img_instructivo = "../".$src."img/instructivos/1.jpg";
		} elseif( $tipo_tramite == 2 ) {
			$pdf->Text(140,56,'Trámite: Otorgamiento (1° vez).');
			$ruta_img_instructivo = "../".$src."img/instructivos/2.jpg";
		} elseif( $tipo_tramite == 3 ) {
			$pdf->Text(140,56,'Trámite: Renov., Lic. vencida dentro 90 días.');
			$ruta_img_instructivo = "../".$src."img/instructivos/1.jpg";
		} elseif( $tipo_tramite == 4 ) {
			$pdf->Text(140,56,'Trámite: Renov., Lic. vencida mas 90 días.');
			$ruta_img_instructivo = "../".$src."img/instructivos/2.jpg";
		} elseif( $tipo_tramite == 5 ) {
			$pdf->Text(140,56,'Trámite: Duplicado por robo/extravío.');
			$ruta_img_instructivo = "../".$src."img/instructivos/5.jpg";
		} elseif( $tipo_tramite == 6 ) {
			$pdf->Text(140,56,'Trámite: Ampliación de categorías.');
			$ruta_img_instructivo = "../".$src."img/instructivos/6.jpg";
		} elseif( $tipo_tramite == 7 ) {
			$pdf->Text(140,56,'Trámite: Otorgamiento (1° vez - Menor).'); 
			$ruta_img_instructivo = "../".$src."img/instructivos/7.jpg";
			$form_menor = true;
		} else {
			$pdf->Text(140,56,'ERROR: Revise la solicitud.');
		}*/
		
		$pdf->SetFont('Arial','',12);
		
		//-----FECHA
		$f = explode ("-", $fecha_turno);
		$d1 = $f[0];
		$m1 = $f[1];
		$y1 = $f[2];
		$pdf->Text(50,56,$d1);//Año
		$pdf->Text(37,56,$m1);//Mes
		$pdf->Text(22,56,$y1);//Día
		//-----HORA
		$h = explode("-", $hora);
		$ho = $h[0];
		$pdf->Text(85,56,$ho);//Hora
		//-----TURNO
		$pdf->Text(130,56,$turno);
		//-----APELLIDO Y NOMBRE
		$pdf->Text(42,80,$apeNom);
		//-----DNI
		$pdf->Text(145,87,$dni);
		//-----TIPO DNI
		$pdf->SetFont('Arial','B',16);
		if( $tipo_dni == 'DNI' ) {
			$pdf->Text(41,89,"*");
		} else if ( $tipo_dni == 'LC' ) {
			$pdf->Text(55,89,"*");
		} else if ( $tipo_dni == 'LE' ) {
			$pdf->Text(69,89,"*");
		} else $pdf->Text(97,89,"*");
		$pdf->SetFont('Arial','',12);
		//-----TELEFONO
		$pdf->Text(26,109,$tel);
		
		//-----MAIL
		$pdf->SetFont('Arial','',11);
		$pdf->Text(23,116,obtenerEMAIL($dni,$tipo_dni));
		
		//-------------VERIFICO DEUDA DE FALTAS
		if ( VerificaCausas( $tipo_dni, $dni ) != '' ) {
			$pdf->Image($ruta_msj_falta,4,57,200,8,'jpg');
		} else {
			$msj_deuda = 'NO EXISTEN FALTAS PENDIENTES DE RESOLUCIÓN.';
			$pdf->Text(4,63,"$msj_deuda");
		}
//-------FIN PAGINA 1-------//

//-------PAGINA 2-------//
		//-------MENSAJE PRINCIPAL.
		/*DESCOMENTAR TODO ESTO PARA QUE VUELVA A APARECER LA 2° PAGINA (07/06/2016)
		$pdf->addPage();
		$pdf->Cell(190,40,'',1,1,'L');
		$pdf->SetFont('Arial','U',12);
		$pdf->Text(15,20,"IMPORTANTE:");
		$pdf->SetFont('Arial','',11);
		$pdf->Text(20,27,"Todo lo que debe hacer es previo al día del Turno (48 Hs. antes). El mismo es para finalizar y generar");
		$pdf->Text(20,32,"el Trámite de la Licencia. En caso de no tener cumplimentada la documentación requerida deberá");
		$pdf->Text(20,37,"comunicarse con la oficina de Licencias y anular el turno para luego solicitar uno nuevo, caso contrario,");
		$pdf->Text(20,42,"el sistema no le permitirá volver a sacar un turno.");
		
		//--------IMAGEN DE INSTRUCTIVO.
		if( $ruta_img_instructivo != null) {
			$pdf->Image($ruta_img_instructivo,10,52,190,0,'jpg');
			if( $form_menor ) { //Si es un tramite de menor de edad imprimo el otro formulario.
				$pdf->Image($ruta_form_menor,null,null,190,280,'jpg');
			}
		}*/
//-------FIN PAGINA 2-------//
				
		//Genero documento PDF.
		if ($descargar == 0) {
			$pdf->Output();
		} else if ($descargar == 1) {
			$pdf->Output("comprobante_turno_online.pdf","D");
		} else {
			$pdf->Output();
		}
	}
?>