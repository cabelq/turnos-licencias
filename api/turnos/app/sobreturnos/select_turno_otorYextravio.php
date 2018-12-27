<?php
$cryptinstall="../../lib/crypt/cryptographp.fct.php";
include $cryptinstall;
include "../../lib/funciones.php";
$dbh = crear_pdo();

function generaSelect( $fech ) {
	// Imprimo el primer select compuesto por las fechas.
	echo "<select style='width:290px;' name='select1' id='select1' onChange='cargaContenido(this.id)'>";
	echo "<option value='0'>Seleccione d&iacute;a...</option>";
	foreach( generaFechaTurno ( $fech ) as $c=>$v ) {
		echo "<option value='".$c."'>".$v."</option>";
	}
	echo "</select>";
}

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
if ( VerificaCausas( $_POST['tipo'], $_POST['dni'] ) != '' ) $msj = $msg_faltas;
else $msj = '';
//////Fin//////

$dbh = NULL;
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
		<script src="../../js/lib.js" type="text/javascript"></script>
		<script type="text/javascript" src="../../js/lib_selects.js"></script>
		<script type="text/javascript" src="../../js/jquery.js"></script>
	</head>
		<title>SOLICITUD DE TURNOS para la renovaci&oacute;n de Licencias de Conducir - Municipalidad de Luj&aacute;n (2012)</title>
		<LINK rel="stylesheet" href="../../css/estilo_login.css" type="text/css" media="screen">
	<body>
		<center><div id="TitGrande2"><b>Solicitud de Turno</b></div></center><br>
		<form name="insertar_turno_otorYextravio" action="./insertar_turno_otorYextravio.php" method="post">
			<center>
			<div id="contenedor" style="width:530px;height: auto;">
				<table style="border: 2px solid gray;width:530px;">
					<tr>
						<td align="center" colspan="2">
							<strong>TR&Aacute;MITE EN CURSO</strong><br>
						</td>
					</tr>
					<tr>			
						<td align="left">
<?php
	//echo $_SESSION['fech_hab']."    jjj";
	if ($_SESSION['fech_hab'] != "") {
		$f = explode("-", $_SESSION['fech_hab']);
		$d = $f[0];
		$m = $f[1];
		$y = $f[2];
		$fecha = $d."-".$m."-".$y;
		//echo $fecha;
	} else {
		$fecha = date('Y/m/d');
	}
	
?>
						</td>
					</tr>
				</table>
				<BR>
				<div id="cons">
					<div id="combo3">
						<table>
							<tr>
								<td><strong>Apellido y Nombre:</strong><span style="color:orange;font-size:12px;">&nbsp;*&nbsp;Obligatorio</span></td></td>
								<td><input style="width:267px;" name="apeNom" type="text" value="<?php echo strtoupper($_POST['apeNom']); ?>" readonly ></td>
							</tr>
							<tr>
								<td><strong>Tipo:</strong></td>
								<td>
									<SELECT NAME="tipo" readonly >
										<?php if ($_POST['tipo'] == 'DNI' ) echo '<option value="DNI">DNI</option>';?>
										<?php if ($_POST['tipo'] == 'LC' ) echo '<option value="LC">LC</option>';?>
										<?php if ($_POST['tipo'] == 'LE' ) echo '<option value="LE">LE</option>';?>
										<?php if ($_POST['tipo'] == 'SD' ) echo '<option value="SD">SD</option>';?>
										<?php if ($_POST['tipo'] == 'CIP' ) echo '<option value="CIP">CIP</option>';?>
										<?php if ($_POST['tipo'] == 'CI' ) echo '<option value="CI">CI</option>';?>
										<?php if ($_POST['tipo'] == 'CIF' ) echo '<option value="CIF">CIF</option>';?>
									</SELECT>
								</td>
							</tr>
							<tr>	
								<td><strong>DNI:</strong><span style="color:orange;font-size:12px;">&nbsp;*&nbsp;Obligatorio</span></td>
								<td><input style="width:267px;" name="dni" type="text" value="<?php echo $_POST['dni']; ?>" readonly ></td>
							</tr>
							<tr>
								<td><strong>Tel&eacute;fono:</strong><span style="color:orange;font-size:12px;">&nbsp;*&nbsp;Obligatorio</span></td>
								<td><input style="width:267px;" name="tel" type="text" value="<?php echo strtoupper($_POST['tel']); ?>" readonly ></td>
							</tr>
							<tr>
								<td><strong>E-MAIL:</strong></td>
								<td><input style="width:267px;" name="email" type="text" value="<?php echo strtoupper($_POST['email']); ?>" readonly ></td>
							</tr>
						</table>
						<br>
						<table>
							<tr>
								<td><div id="demoIzq"><?php generaSelect( $fecha ); ?></div></td>
							</tr>
							<tr>
								<td><select style="width:290px;" disabled="disabled" name="select2" id="select2"><option value="0">Seleccione hora...</option></select></td>
								<td width="20px"><span id="loading"></span></td>
							</tr>
						</table>
			<table><tr><td><img src="../../img/alert.png"></td><td>La falsedad de los datos consignados impedir&aacute; la obtenci&oacute;n del beneficio.</td></tr></table>
			<table style="color:black;font-weight:bold;"><tr><td colspan="2" align="center"><font color="#f02f2f">IMPORTANTE:</font> Usted puede reservar su turno hasta con 12 meses de anticipaci&oacute;n al vencimiento. Solo debe tener en cuenta que la fecha del mismo no puede ser anterior a los 30 d&iacute;as del vencimiento de su licencia de conducir.
					<td><tr></table>
						<br>
						</div>
					</div>
				</div>
			</center>
			<input type="hidden" name="accion" value="<?php echo $_POST['accion']; ?>">
		</form>
		<center>
			<Button class="boton" onClick="confirmarTurnoOtorExtrav()" name="Insertar">&#161;CONFIRMAR TURNO!</button>
		</center>
		<?php echo $msj; ?>
	</body>
</html>