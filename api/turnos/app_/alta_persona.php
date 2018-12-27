<?php
$cryptinstall="../lib/crypt/cryptographp.fct.php";
include $cryptinstall;
include "../lib/funciones.php";
$dbh = crear_pdo();
$msj = '';

$msg_faltas = <<<INI
				<div id="recuadro">
					<center>
					<br>
						<table class="tabla_2" cellpadding="0" cellspacing="0" border=1 bordercolor="black">
						<!--DWLayoutTable-->
							<tr bgcolor="#f02f2f">
								<td height="100px" width="600" align="center"><strong><font color="white">Le informamos que al d&iacute;a de la fecha Usted posee Infracciones de Tr&aacute;nsito pendientes de pago/resoluci&oacute;n. Para concluir con el tr&aacute;mite de la Licencia de Conducir deber&aacute; regularizar dicha situaci&oacute;n 48Hs antes del d&iacute;a del turno acerc&aacute;ndose a los siguientes lugares: Palacio Municipal, 
								Juzgado de Faltas.<br>NO OBSTANTE, DE TODAS MANERAS PODR&Aacute; RESERVAR EL TURNO.</font>
							</tr>
						</table>
					<br><br>
				</div>
INI;
//////Verifico si tiene faltas. Si tiene, muestro un cartel y que siga.///////
if ( VerificaCausas( $_SESSION['tipo'], $_SESSION['dni'] ) != '' ) $msj = $msg_faltas;
else $msj = '';
//////Fin//////

?>

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
		<title>SOLICITUD DE TURNOS para la renovación de Licencias de Conducir - Municipalidad de Luján (2012)</title>
		<LINK rel="stylesheet" href="../css/estilo_login.css" type="text/css" media="screen">
	</head>
	<body>
		<center><div id="TitGrande2"><b>Solicitud de Turno</b></div></center><br>
		<form name="otorgamiento_extravio" action="./select_turno_otorYextravio.php" method="post">
			<center>
			<div id="contenedor" style="height: auto;width:530px;">
				<BR>
				<div id="cons">
					<div id="combo3">
						<table>
							<tr>
								<td><strong>Apellido y Nombre:</strong><span style="color:orange;font-size:12px;">&nbsp;*&nbsp;Obligatorio</span></td></td>
								<td><input style="width:267px;" name="apeNom" type="text" value="<?php echo $_SESSION['ApeNom']; ?>"></td>
							</tr>
							<tr>
								<td><strong>Tipo:</strong></td>
								<td>
								<?php //echo $_SESSION['accion']; echo $_SESSION['tipo'];?>
									<SELECT NAME="tipo">
										<?php
											if ($_SESSION['accion'] == 'UPDATE') {
												if (empty($_SESSION['tipo'])) {
													echo '<option value="DNI">DNI</option>';
													echo '<option value="LC">LC</option>';
													echo '<option value="LE">LE</option>';
													echo '<option value="SD">SD</option>';
													echo '<option value="CI">CI</option>';
													echo '<option value="CIF">CIF</option>';
												} else {
													if ($_SESSION['tipo'] == 'DNI' ) echo '<option value="DNI">DNI</option>';
													if ($_SESSION['tipo'] == 'LC' ) echo '<option value="LC">LC</option>';
													if ($_SESSION['tipo'] == 'LE' ) echo '<option value="LE">LE</option>';
													if ($_SESSION['tipo'] == 'SD' ) echo '<option value="SD">SD</option>';
													if ($_SESSION['tipo'] == 'CIP' ) echo '<option value="CIP">CIP</option>';
													if ($_SESSION['tipo'] == 'CI' ) echo '<option value="CI">CI</option>';
													if ($_SESSION['tipo'] == 'CIF' ) echo '<option value="CIF">CIF</option>';
												}
											} else {
												echo '<option value="DNI">DNI</option>';
												echo '<option value="LC">LC</option>';
												echo '<option value="LE">LE</option>';
												echo '<option value="SD">SD</option>';
												echo '<option value="CI">CI</option>';
												echo '<option value="CIF">CIF</option>';
											}
										?>
									</SELECT>
								</td>
							</tr>
							<tr>	
								<td><strong>DNI:</strong><span style="color:orange;font-size:12px;">&nbsp;*&nbsp;Obligatorio</span></td>
								<td><input maxlength="8" style="width:267px;" name="dni" type="text" onkeypress="return permite(event, 'num_esp')" value="<?php echo $_SESSION['dni']; ?>"></td>
							</tr>
							<tr>
								<td><strong>Tel&eacute;fono:</strong><span style="color:orange;font-size:12px;">&nbsp;*&nbsp;Obligatorio</span></td>
								<td><input style="width:267px;" name="tel" type="text" ></td>
							</tr>
							<tr>
								<td><strong>E-MAIL:</strong></td>
								<td><input style="width:267px;" name="email" type="text" value="<?php echo $_SESSION['email']; ?>"></td>
							</tr>
							<input type="hidden" name="accion" value="<?php echo $_SESSION['accion']; ?>">
						</table>
			<table><tr><td><img src="../img/alert.png"></td><td>La falsedad de los datos consignados impedir&aacute; la obtenci&oacute;n del beneficio.</td></tr></table>
			<table style="color:black;font-weight:bold;"><tr><td colspan="2" align="center"><font color="#f02f2f">IMPORTANTE:</font> Usted puede reservar su turno hasta con 12 meses de anticipaci&oacute;n al vencimiento. Solo debe tener en cuenta que la fecha del mismo no puede ser anterior a los 30 d&iacute;as del vencimiento de su licencia de conducir.
					<td><tr></table>
						</div>
					</div>
			</div>
			</center>
		</form>
		<center>
			<Button class="boton" onClick="GuardarNuevaPersona()" name="Insertar">CONTINUAR...</button>
		</center>
		<?php echo $msj; $dbh=NULL;?>
	</body>
</html>