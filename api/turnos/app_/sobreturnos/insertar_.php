<?php
	session_start();
	require ('../../lib/fpdf/fpdf.php');
	include "../../lib/funciones.php";
	$dbh = crear_pdo();
	
	$msg_error_2 = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>ERROR DE RESERVA DE TURNO</title>
				<LINK rel="stylesheet" href="../../css/table.css" type="text/css" media="screen">
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
								<td height="100px" width="600" align="center"><strong>No es posible reservar un SOBRETURNO sin la identificaci&oacute;n del Empleado.<br>
								<br><a href="./index.php"> - Volver - </a></strong></td>
							</tr>
						</table>
					<br><br>
				</div>
			</body>
		</html>
INI;
	
	if (isset($_SESSION['Id'])) {
		$id_usuario = $_SESSION['Id'];
	} else {
		die($msg_error_2);
		$id_usuario = null;
	}
	
	$msg_error_1 = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>ERROR DE RESERVA DE TURNO</title>
				<LINK rel="stylesheet" href="../../css/table.css" type="text/css" media="screen">
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
	
	$fecha = explode(',',$_POST['select1']);
	$hora = explode(',',$_POST['select2']);
	$f = explode ("/", $fecha[1]);
	$d1 = $f[0];
	$m1 = $f[1];
	$y1 = $f[2];
	$fecha_guion = $y1."-".$m1."-".$d1;
	
	$query = "SELECT id_turno FROM turnos WHERE fecha_turno = ? AND orden_turno = ? AND fecha_anulado IS NULL";
	$sth = $dbh->prepare( $query );
	$sth->execute( array($fecha_guion, $hora[2]));
	
	$faltas = "Ud. no posee faltas al d&iacute;a de la fecha.";
	if ( VerificaCausas( $_POST['tipo'], $_POST['dni'] ) != '' ) $faltas = "<a style='color:white' href='../../../faltas/app/faltas_panel2.php?dni2=$_POST[dni]' target='_blank'>Ver faltas</a>";
	
	//Bloqueo si o si para cuando ya tiene un turno asignado.
	if ( verificarCantidadDeTurnos2 ($_POST['dni']) ) {
		echo $msg_error_1;
		die();
	}
	
	if ( verificar72Turnos( $fecha_guion ) == true ) {
		if ($sth->rowCount() == 0) { //Pregunto si el turno se encuentra ocupado.
			
			if ( !verificarCantidadDeTurnos ( $_POST['dni'] ) ) {
				$query = "INSERT INTO turnos (dni_vencimiento, fecha_turno, hora_puesto, orden_turno, fecha_solicitado,observaciones,id_usuario_insert) VALUES (?,?,?,?,?,?,?)";
				$query2 = "UPDATE vencimientos SET id_turno = ?, tel = ?, email = ? WHERE dni = ?";
				
				$sth = $dbh->prepare( $query );
				$sth2 = $dbh->prepare( $query2 );
				$hoy = date("Y-m-d H:i:s");
				$sth->execute( array($_POST['dni'], $fecha_guion, $hora[1], $hora[2], $hoy,'Renovación. Solicita en período correspondiente.',$id_usuario));
				$ultimo_ID = $dbh->lastInsertID();
				if ( $sth && $sth2 ) {
					$sth2->execute( array($ultimo_ID, strtoupper($_POST['tel']), strtoupper($_POST['email']), $_POST['dni']));
					//generoComprobante ( $fecha[1], $hora[1], $_POST['ApeNom'], $_POST['dni'],1,$_POST['tipo'] );
					//generoComprobante2($_POST['tipo'],$_POST['dni'],$fecha_guion,$hora[1],$hora[2],$_POST['ApeNom'],$_POST['tel'],1,"../../img/decjur5.jpg","../../img/msj_deuda.jpg","../../img/instructivos/decjur4.jpg","Sobretur");
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
						<script src="../../js/lib.js" type="text/javascript"></script>
						<script type="text/javascript" src="../../js/lib_selects.js"></script>
					</head>
						<title>SOLICITUD DE TURNOS para la renovación de Licencias de Conducir - Municipalidad de Luján (2012)</title>
						<LINK rel="stylesheet" href="../../css/estilo_login.css" type="text/css" media="screen">
					<body>
						<center><div id="TitGrande2"><b>Solicitud de Turno</b></div></center><br>
						<form name="formulario" action="./#.php" method="post">
							<center>
							<div id="contenedor" style="height:270px;width:530px;">
								<div id="cons">
									<div id="combo3">
										<table>
											<tr>
												<td><strong>Apellido y Nombre:</strong></td><td>$_POST[ApeNom]</td>
											</tr>
											<tr>
												<td><strong>Fecha y hora del Turno:</strong></td><td>$fecha[1] - $hora[1]</td>
											</tr>
											<tr>
												<td><strong>Tipo de Tr&aacute;mite:</strong></td><td> Renueva en per&iacute;odo correspondiente.</td>
											</tr>
											<tr>
												<td><strong>Faltas:</strong></td><td>$faltas</td>
											</tr>
										</table><br>
										<div style="padding-top:5px;width:480px;height:31px;border:1px solid black;background:#3CB371;">
											<table>
												<tr>
													<td align="right">Vista previa de Impresi&oacute;n:</td><td><a href="./descargar.php?tipo_dni=$_POST[tipo]&dni=$_POST[dni]&fecha=$fecha_guion&hora=$hora[1]&turno=$hora[2]&apeNom=$_POST[ApeNom]&tel=$_POST[tel]&tipoTram=1&rutaFondo=../../img/decjur5.jpg&msjRutaFalta=../../img/msj_deuda.jpg&rutaFormMenor=../../img/instructivos/decjur4.jpg&procedencia=Sobretur&descargar=0" title="Imprimir"><img src="../../img/imprimir.png"></a></td>
													<td width="20px"align="center">-</td><td align="right">Guardar en mi PC (Recomendado):</td><td><a href="./descargar.php?tipo_dni=$_POST[tipo]&dni=$_POST[dni]&fecha=$fecha_guion&hora=$hora[1]&turno=$hora[2]&apeNom=$_POST[ApeNom]&tel=$_POST[tel]&tipoTram=1&rutaFondo=../../img/decjur5.jpg&msjRutaFalta=../../img/msj_deuda.jpg&rutaFormMenor=../../img/instructivos/decjur4.jpg&procedencia=Sobretur&descargar=1" title="Descargar"><img src="../../img/descargar.png"></a></td>
												</tr>
											</table>
										</div><br>
										<div style="font-size:85%;color:red;padding-top:5px;width:400px;height:70px;border:1px solid orange;background:#FFDEAD;">
										<center><strong>RECUERDE QUE:</strong><br>
										1)- Al d&iacute;a del turno Ud. deber&aacute; tener la documentaci&oacute;n del tr&aacute;te cumplimentada.<br>
										2)- 48 Hs. antes del turno deber&aacute; encontrarse saldada la deuda de infracciones (en caso que el sistema as&iacute; se lo haya informado).
										</center></div>
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
