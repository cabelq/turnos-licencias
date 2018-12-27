<?php
	session_start();
	require ('../lib/fpdf/fpdf.php');
	include "../lib/funciones.php";
	$dbh = crear_pdo();
	
	if (isset($_SESSION['Id'])) {
		$id_usuario = $_SESSION['Id'];
	} else {
		$id_usuario = null;
	}
	//echo  verificaDNI( $_POST['dni']);die();
	$msg_error_1 = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>ERROR DE RESERVA DE TURNO</title>
				<LINK rel="stylesheet" href="../css/table.css" type="text/css" media="screen">
				<style type="text/css">
					body {
						background:#D8D8D8;
						font-family: Arial, Helvetica, Sans-Serif;
						font-size: 12px;
					}
				</style>
			</head>
			<body>
				<div id="recuadro">
					<center>
					<br><br><br><br><br><br>
						<table class="tabla_2" cellpadding="0" cellspacing="0">
						<!--DWLayoutTable-->
							<tr bgcolor="#FFBBBB">
								<td height="100px" width="600" align="center"><strong>Se ha intentado reservar m&aacute;s de un turno para el mismo DNI.<br>
								Ante cualquier inconveniente, le sugerimos se comunique con nosotros al Tel.: 02323-435271.<br><br><a href="./index.php"> - Volver - </a></strong></td>
							</tr>
						</table>
					<br><br>
				</div>
			</body>
		</html>
INI;

$msg_error_registroDuplicado = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>ERROR DE RESERVA DE TURNO</title>
				<LINK rel="stylesheet" href="../css/table.css" type="text/css" media="screen">
				<style type="text/css">
					body {
						background:#D8D8D8;
						font-family: Arial, Helvetica, Sans-Serif;
						font-size: 12px;
					}
				</style>
			</head>
			<body>
				<div id="recuadro">
					<center>
					<br><br><br><br><br><br>
						<table class="tabla_2" cellpadding="0" cellspacing="0">
						<!--DWLayoutTable-->
							<tr bgcolor="#FFBBBB">
								<td height="100px" width="600" align="center"><strong>Se ha intentado grabar un registro con igual DNI. Eso no es posible.<br>
								Si los datos expuestos son incorrectos, le sugerimos se comunique con nosotros al Tel.: 02323-435271, caso contrario
								solicite un turno con los datos que ve en pantalla.<br><br><a href="./index.php"> - Volver - </a></strong></td>
							</tr>
						</table>
					<br><br>
				</div>
			</body>
		</html>
INI;
	
	//Bloqueo si o si para cuando ya tiene un turno asignado.
	if ( verificarCantidadDeTurnos2 ($_POST['dni']) ) {
		echo $msg_error_1;
		die();
	}
	
	$fecha = explode(',',$_POST['select1']);
	$hora = explode(',',$_POST['select2']);
	$hoy = date("Y-m-d H:i:s");
		
	$f = explode ("/", $fecha[1]);
	$d1 = $f[0];
	$m1 = $f[1];
	$y1 = $f[2];
	$fecha_guion = $y1."-".$m1."-".$d1;
	#echo $hora[1];
	#echo $fecha_guion;
	#die();
	#$query = "SELECT hora_puesto FROM turnos WHERE fecha_turno = ? AND fecha_anulado IS NULL";
	#$query = "SELECT id_turno    FROM turnos WHERE fecha_turno = ? AND orden_turno = ? AND fecha_anulado IS NULL";
	$query = "SELECT id_turno FROM turnos WHERE fecha_turno = ? AND hora_puesto = ? AND fecha_anulado IS NULL";
	
	$faltas = "Ud. no posee faltas al d&iacute;a de la fecha.";
	if ( VerificaCausas( $_POST['tipo'], $_POST['dni'] ) != '' ) $faltas = "<a style='color:white' href='../../faltas/app/faltas_panel2.php?dni2=$_POST[dni]' target='_blank'>Ver faltas</a>";
	
	$sth = $dbh->prepare( $query );
	$sth->execute( array($fecha_guion, $hora[1]));
	#echo $sth->rowCount();
	$lbaux = verificar72Turnos( $fecha_guion );
	#echo $fecha_guion;
	#die();
	if ( verificar72Turnos2( $fecha_guion ) == true ) {
		//die();
		if ($sth->rowCount() == 0) { //Pregunto si el turno esta libre...
			if ( !verificarCantidadDeTurnos ( $_POST['dni'] ) ) {

				if ($_POST['accion'] == 'UPDATE') {
					$query2 = "INSERT INTO turnos (dni_vencimiento, fecha_turno, hora_puesto, orden_turno, fecha_solicitado, observaciones, id_usuario_insert) VALUES (?,?,?,?,?,?,?)";
					$query3 = "UPDATE vencimientos SET id_turno = ?, tel = ?, email = ?, fech_hab = ? WHERE dni = ? AND tipo_dni = ?";
				} elseif ($_POST['accion'] == 'INSERT') {
					if( verificaDNI( $_POST['dni']) == 0 ) {
						$query1 = "INSERT INTO vencimientos (tipo_dni, dni, ApeNom, fech_hab, tel, email) VALUES (?,?,?,?,?,?)";
						$query2 = "INSERT INTO turnos (dni_vencimiento, fecha_turno, hora_puesto, orden_turno, fecha_solicitado, observaciones, id_usuario_insert) VALUES (?,?,?,?,?,?,?)";
						$query3 = "UPDATE vencimientos SET id_turno = ?, tel = ?, email = ?, fech_hab = ? WHERE dni = ? AND tipo_dni = ?";
						$sth1 = $dbh->prepare( $query1 );
						$sth1->execute( array($_POST['tipo'], $_POST['dni'], $_POST['apeNom'], date('Y/m/d'), $_POST['tel'], $_POST['email']));
					} else {
						//die(); ///////////////////////////////////////
						echo $msg_error_registroDuplicado;
						die();
					}
					
				}
				
				$sth2 = $dbh->prepare( $query2 );
				$sth3 = $dbh->prepare( $query3 );
				$sth2->execute( array($_POST['dni'], $fecha_guion, $hora[1], $hora[2], $hoy,'',$id_usuario));
				$ultimo_ID = $dbh->lastInsertID();
				if ( $sth2 && $sth3 ) {
					$sth3->execute( array($ultimo_ID, strtoupper($_POST['tel']), strtoupper($_POST['email']), $fecha_guion, $_POST['dni'], $_POST['tipo']));
					//die(); ///////////////////////////////////////
					$msg_ok = <<<INI
						<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es">
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
								<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
								<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
								<meta name="robots" content="index, follow">
								<meta name="keywords" content="Municipalidad de Luján Intendente Oscar Luciani sitio oficial de lujan.">
								<meta name="description" content="Portal Oficial del Municipio de LUJÁN.">
								<script src="../js/lib.js" type="text/javascript"></script>
								<script type="text/javascript" src="../js/lib_selects.js"></script>
							</head>
								<title>SOLICITUD DE TURNOS para la renovación de Licencias de Conducir - Municipalidad de Luján (2012)</title>
								<LINK rel="stylesheet" href="../css/estilo_login.css" type="text/css" media="screen">
							<body>
								<center><div id="TitGrande2"><b>Solicitud de Turno</b></div></center><br>
								<form name="formulario" action="./#.php" method="post">
									<center>
									<div id="contenedor" style="height:350px;width:530px;">
										<div id="cons">
											<div id="combo3">
												<table>
													<tr>
														<td><strong>Apellido y Nombre:</strong></td><td>$_POST[apeNom]</td>
													</tr>
													<tr>
														<td><strong>Fecha y hora del Turno:</strong></td><td>$fecha[1] - $hora[1]</td>
													</tr>
													<tr>
														<td><strong>Faltas:</strong></td><td>$faltas</td>
													</tr>
												</table><br>
												<div style="padding-top:5px;width:480px;height:31px;border:1px solid black;background:#3CB371;">
													<table>
														<tr>
															<td align="right">Vista previa de Impresi&oacute;n:</td><td><a href="./descargar.php?tipo_dni=$_POST[tipo]&dni=$_POST[dni]&fecha=$fecha_guion&hora=$hora[1]&turno=$hora[2]&apeNom=$_POST[apeNom]&tel=$_POST[tel]&rutaFondo=../img/decjur5.jpg&msjRutaFalta=../img/msj_deuda.jpg&procedencia=noSobretur&descargar=0" title="Imprimir"><img src="../img/imprimir.png"></a></td>
															<td width="20px"align="center">-</td><td align="right">Guardar en mi PC (Recomendado):</td><td><a href="./descargar.php?tipo_dni=$_POST[tipo]&dni=$_POST[dni]&fecha=$fecha_guion&hora=$hora[1]&turno=$hora[2]&apeNom=$_POST[apeNom]&tel=$_POST[tel]&rutaFondo=../img/decjur5.jpg&msjRutaFalta=../img/msj_deuda.jpg&procedencia=noSobretur&descargar=1" title="Descargar"><img src="../img/descargar.png"></a></td>
														</tr>
													</table>
												</div>
												<br>
												<div style="font-size:85%;color:red;padding-top:5px;width:480px;height:90px;border:1px solid orange;background:#FFDEAD;">
													<center><strong>DOCUMENTACI&Oacute;N REQUERIDA PARA PRESENTAR AL D&Iacute;A DEL TURNO</strong></center>
													1)- 1(Una) Fotocopia de DNI.<br>
													2)- 1(Una) Fotocopia del Registro.<br>
													3)- Certificado de legalidad (Si su registro es de otra Localidad).<br>
													4)- Antecedentes penales si su registro es profesional (C-D1-D2-D3-E1-E2-E3).
													5)- Denuncia en Registro Civil de las personas (en caso de robo o extrav&iacute;o).
												</div>
												<br>
												<div style="font-size:85%;color:red;padding-top:5px;width:480px;height:55px;border:1px solid orange;background:#FFDEAD;">
													<center><strong>IMPORTANTE</strong></center>
													Debido a que el personal m&eacute;dico presta servicios hasta las 12:00 Hs., sugerimos por favor
													se presenten en nuestras oficinas antes de ese horario para que el ex&aacute;men corresondiente
													pueda ser realizado sin inconvenientes.<br>
												</div>
												<br>
												<center>
													<Button style="width:400px;" class="boton" onClick="window.close()" name="Insertar">FINALIZAR Y CERRAR</button>
												</center>
											</div>
										</div>
									</div>
								</center>
								</form>
							</body>
						</html>
INI;
						echo($msg_ok);
				}
			} else {
				echo $msg_error_1;
			}
		} else {
			echo "<script>alert('Turno ha sido ocupado. ¡Intentelo nuevamente!');</script>"; 
			echo "<script>history.go(-2);</script>";
		}
	} else {
		echo "<script>alert('ERROR. ¡Ocurrió un error inesperado! Intentelo nuevamente.');</script>";
		echo "<script>history.go(-2);</script>";
	}
		
	$dbh = null;
?>
