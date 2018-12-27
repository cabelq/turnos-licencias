<?php
$cryptinstall="../../lib/crypt/cryptographp.fct.php";
include $cryptinstall;
include "../../lib/funciones.php";
$dbh = crear_pdo();
$msj = '';

$msg_error_1 = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>Validaci&oacute;n de Usuario: Incorrecta</title>
				<LINK rel="stylesheet" href="../../css/estilo_login.css" type="text/css" media="screen">
				<script type="text/javascript">
					function continuar1(){
						document.location.href="./index.php";
					}
				</script>
			</head>
			<body>
			<br>
				<center>
					<div id="cons" >
					<div id="contenedor2" style="height:180px;">
						<br>
						<IMG style="float:left;width:180px;height:75px;margin-top:00px" SRC="../../img/logo_muni.png">
						<br><br><br><br><br><br>						
					<div style="float:right;margin-top:5px;"><input type="button" id="button2" value="Continuar" style="text-transform:none;height: inherit;width:110px; background:#4fa338" onClick="continuar1()" name="consultar"/></div>
					<table><tr><td><img src="../../img/alert.png"></td><td>Ya existe un turno asignado para ese Documento.<br>
								Por favor, p&oacute;ngase en contacto con el administrador al sig. Tel.: 02323-435271.</td></tr></table>
					<div style="padding-top:5px;float:left;width:400px;border-bottom:2px solid #F46666;"></div>
					<div style="float:left;width:350px;border-bottom:2px solid #F46666;"></div>
					<div style="float:left;width:300px;border-bottom:2px solid #F46666;"></div>
					<div style="float:left;width:250px;border-bottom:2px solid #F46666;"></div>
					</div>
					</div>
				</center>
			</body>
		</html>
INI;

$msg_error_2 = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>Validaci&oacute;n de Usuario: Incorrecta</title>
				<LINK rel="stylesheet" href="../../css/estilo_login.css" type="text/css" media="screen">
				<script type="text/javascript">
					function continuar2(){
						document.location.href="./alta_persona.php";
					}
				</script>
			</head>
			<body>
			<br>
				<center>
					<div id="cons" >
					<div id="contenedor2" style="height:180px;">
						<br>
						<IMG style="float:left;width:180px;height:75px;margin-top:00px" SRC="../../img/logo_muni.png">
						<br><br><br><br><br><br>						
					<div style="float:right;margin-top:5px;"><input type="button" id="button2" value="Continuar" style="text-transform:none;height: inherit;width:110px; background:#4fa338" onClick="continuar2()" name="consultar"/></div>
					<table><tr><td><img src="../../img/alert.png"></td><td>Ud. no existe en nuestra base de datos.
								Haga click en Continuar para seguir con la solicitud del turno On-Line...</td></tr></table>
					<div style="padding-top:5px;float:left;width:400px;border-bottom:2px solid #F46666;"></div>
					<div style="float:left;width:350px;border-bottom:2px solid #F46666;"></div>
					<div style="float:left;width:300px;border-bottom:2px solid #F46666;"></div>
					<div style="float:left;width:250px;border-bottom:2px solid #F46666;"></div>
					</div>
					</div>
				</center>
			</body>
		</html>
INI;

$msg_error_3 = <<<INI

		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>Validaci&oacute;n de Usuario: Incorrecta</title>
				<LINK rel="stylesheet" href="../../css/estilo_login.css" type="text/css" media="screen">
				<script type="text/javascript">
					function continuar3(){
						document.location.href="./alta_persona.php";
					}
				</script>
			</head>
			<body>
			<br>
				<center>
					<div id="cons" >
					<div id="contenedor2" style="height:200px;">
						<br>
						<IMG style="float:left;width:180px;height:75px;margin-top:00px" SRC="../../img/logo_muni.png">
						<br><br><br><br><br><br>						
					<div style="float:right;margin-top:30px;"><input type="button" id="button2" value="Continuar" style="text-transform:none;height: inherit;width:110px; background:#4fa338" onClick="continuar3()" name="consultar"/></div>
					<table><tr><td><img src="../../img/alert.png"></td><td>Ud. no rinde las condiciones para solicitar
								un turno On-Line por no encontrarse el vencimiento de su licencia dentro del per&iacute;odo correspondiente.
								Si Ud. de todas maneras necesita obtener un turno, le sugerimos haga click en Continuar...</td></tr></table>
					<div style="padding-top:5px;float:left;width:400px;border-bottom:2px solid #F46666;"></div>
					<div style="float:left;width:350px;border-bottom:2px solid #F46666;"></div>
					<div style="float:left;width:300px;border-bottom:2px solid #F46666;"></div>
					<div style="float:left;width:250px;border-bottom:2px solid #F46666;"></div>
					</div>
					</div>
				</center>
			</body>
		</html>
INI;

$msg_error_4 = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>Validaci&oacute;n de Usuario: Incorrecta</title>
				<LINK rel="stylesheet" href="../../css/estilo_login.css" type="text/css" media="screen">
				<script type="text/javascript">
					function continuar4(){
						document.location.href="alta_persona.php";
					}
				</script>
			</head>
			<body>
			<br>
				<center>
					<div id="cons" >
					<div id="contenedor2" style="height:180px;">
						<br>
						<IMG style="float:left;width:180px;height:75px;margin-top:00px" SRC="../../img/logo_muni.png">
						<br><br><br><br><br><br>						
					<div style="float:right;margin-top:5px;"><input type="button" id="button2" value="Continuar" style="text-transform:none;height: inherit;width:110px; background:#4fa338" onClick="continuar4()" name="consultar"/></div>
					<table><tr><td><img src="../../img/alert.png"></td><td>Solicitud de turnos On-Line para licencias
								tramitadas por primera vez, le sugerimos haga click en Continuar para seguir
								con la solicitud.</td></tr></table>
					<div style="padding-top:5px;float:left;width:400px;border-bottom:2px solid #F46666;"></div>
					<div style="float:left;width:350px;border-bottom:2px solid #F46666;"></div>
					<div style="float:left;width:300px;border-bottom:2px solid #F46666;"></div>
					<div style="float:left;width:250px;border-bottom:2px solid #F46666;"></div>
					</div>
					</div>
				</center>
			</body>
		</html>
INI;

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

if (chk_crypt($_POST['code']) == FALSE ) {
		echo '<script>alert("El codigo introducido es incorrecto.");</script>';
		echo '<Script>
			location.href = "./index.php";
		</script>';
} else {
	$dni_pers = $_POST["dni"];
	$tipo_dni_pers = $_POST["tipo"];
	$dni_query = "SELECT * FROM vencimientos WHERE dni = ? AND tipo_dni = ?";
	$dni = $dbh->prepare( $dni_query );
	if ( $dni ) {
		$dni->execute( array($dni_pers, $tipo_dni_pers) );
		$total = $dni->rowCount();
		if ( $total > 0 && $_POST["operacion"] == 1) { //Si existe la persona.
			$row = $dni->fetch();
			
			//////Verifico si tiene faltas. Si tiene, muestro un cartel y que siga.///////
			if ( VerificaCausas( $tipo_dni_pers, $dni_pers ) != '' ) $msj = $msg_faltas;
			else $msj = '';
			//////Fin//////
			
			//Bloqueo si o si para cuando ya tiene un turno asignado.
			if ( verificarCantidadDeTurnos2 ($dni_pers) ) {
				echo $msg_error_1;
				die();
			}
			//echo $row['fech_hab'];
			$f = explode("/", $_POST['vencimiento']);
			$d = $f[0];
			$m = $f[1];
			$y = $f[2];
			$fVencimiento2 = $y."/".$m."/".$d; //Linea agregada 21/11/2016
			$fVencimiento = $y."-".$m."-".$d;
			
			//echo verificarSolicitud_2($row['fech_hab']);
			//echo ($_POST['vencimiento']);
			if ( verificarSolicitud_2($fVencimiento) == 1 && !verificarCantidadDeTurnos($dni_pers) ) { //Esta en periodo 30 dias y no tiene un turno asignado.
				//NO hago nada y cargo el formulario HTML de mas abajo (no hay die())
				$_SESSION['fech_hab'] = $fVencimiento;
			} else if ( verificarSolicitud_2($fVencimiento) == 2 && !verificarCantidadDeTurnos($dni_pers) ) { //Esta en periodo 90 dias y no tiene turno asignado.
				$_SESSION['dni'] = $row['dni'];
				$_SESSION['tipo'] = $row['tipo_dni'];
				$_SESSION['ApeNom'] = $row['ApeNom'];
				$_SESSION['tel'] = $row['tel'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['fech_hab'] = $fVencimiento;
				$_SESSION['accion'] = 'UPDATE';
				//echo verificarSolicitud_2($row['fech_hab']);
				echo $msg_error_3;
				die();
			} else if ( verificarSolicitud_2($fVencimiento) == 3 && !verificarCantidadDeTurnos($dni_pers)) { //Esta fuera del periodo 90 dias.
				$_SESSION['dni'] = $row['dni'];
				$_SESSION['tipo'] = $row['tipo_dni'];
				$_SESSION['ApeNom'] = $row['ApeNom'];
				$_SESSION['tel'] = $row['tel'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['fech_hab'] = $fVencimiento;
				$_SESSION['accion'] = 'UPDATE';
				//echo verificarSolicitud_2($row['fech_hab']);
				echo $msg_error_3;
				die();
			} else if ( verificarSolicitud_2($fVencimiento) == 0 && !verificarCantidadDeTurnos($dni_pers)) { //Vence mucho mas adelante del periodo contemplado Ej. 2014,2015
				$_SESSION['dni'] = $row['dni'];
				$_SESSION['tipo'] = $row['tipo_dni'];
				$_SESSION['ApeNom'] = $row['ApeNom'];
				$_SESSION['tel'] = $row['tel'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['fech_hab'] = $fVencimiento;
				$_SESSION['accion'] = 'UPDATE';
				//echo verificarSolicitud_2($row['fech_hab']);
				echo $msg_error_3;
				die();
			} else {
				echo $msg_error_1;
				die();
			}
		} else if ($total == 0 && $_POST["operacion"] == 2) { //Es un nuevo registro...
			//No debo cargar el prox formulario con ningun dato...
			$_SESSION['dni'] = "";
			$_SESSION['tipo'] = "";
			$_SESSION['ApeNom'] = "";
			$_SESSION['tel'] = "";
			$_SESSION['email'] = "";
			$_SESSION['fech_hab'] = "";
			$_SESSION['accion'] = 'INSERT';
			echo $msg_error_2;
			die();
		} else {  //No existe la persona.
			//Cargar el prox formulario con ningun dato...
			/*$_SESSION['dni'] = "";
			$_SESSION['tipo'] = "";
			$_SESSION['ApeNom'] = "";
			$_SESSION['tel'] = "";
			$_SESSION['email'] = "";
			$_SESSION['fech_hab'] = "";
			$_SESSION['accion'] = 'INSERT';*/
			$row = $dni->fetch();
			$_SESSION['dni'] = $row['dni'];
			$_SESSION['tipo'] = $row['tipo_dni'];
			$_SESSION['ApeNom'] = $row['ApeNom'];
			$_SESSION['tel'] = $row['tel'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['fech_hab'] = date("Y-m-d");
			$_SESSION['accion'] = 'UPDATE';
			echo $msg_error_4;
			die();
		}
	} else echo 'Falló la operación';

	function generaSelect( $fech ) {
		// Imprimo el primer select compuesto por las fechas.
		echo "<select style='width:220px;' name='select1' id='select1' onChange='cargaContenido(this.id)'>";
		echo "<option value='0' >Seleccione d&iacute;a...</option>";
		foreach( generaFechaTurno ( $fech ) as $c=>$v ) {
			echo "<option value='".$c."'>".$v."</option>";
		}
		echo "</select>";
	}
}

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
	</head>
		<title>SOLICITUD DE TURNOS para la renovación de Licencias de Conducir - Municipalidad de Luján (2012)</title>
		<LINK rel="stylesheet" href="../../css/estilo_login.css" type="text/css" media="screen">
	<body>
		<center><div id="TitGrande2"><b>Solicitud de Turno</b></div></center><br>
		<form name="insertar" action="./insertar.php" method="post">
			<center>
				<div id="cons">
					<div id="combo">
						<table>
							<tr>
								<!--<td><div id="demoIzq"><?php //generaSelect( $fVencimiento ); ?></div></td>--><!-- Linea modificada 21/11/2016 -->
								<td><div id="demoIzq"><?php generaSelect( $fVencimiento2 ); ?></div></td>
								<td><select style="width:290px;" disabled="disabled" name="select2" id="select2"><option value="0">Seleccione hora...</option></select></td>
								<td width="20px"><span id="loading"></span></td>
							</tr>
							<tr>
								<td><strong>Tel&eacute;fono:</strong><span style="color:red;font-size:12px;">&nbsp;*&nbsp;Obligatorio</span></td>
								<td><input style="width:267px;" name="tel" type="text"></td>
							</tr>
							<tr>
								<td><strong>Escriba su E-MAIL:</strong></td>
								<td><input style="width:267px;" name="email" type="text"></td>
							</tr>
							<input type="hidden" name="dni" value="<?php echo $row['dni'] ?>" />
							<input type="hidden" name="tipo" value="<?php echo $tipo_dni_pers ?>" />
							<input type="hidden" name="ApeNom" value="<?php echo strtoupper($row['ApeNom']) ?>" />
						</table>
						<br>
						<table>
							<tr style="font-size: 20px;">
								<td><strong><?php echo 'DNI:&nbsp;'.$row['dni'].'<br>'; ?></strong></td>
								<td><strong><?php echo '&nbsp;-&nbsp;Nombre:&nbsp;'.strtoupper($row['ApeNom']); ?></strong></td>
							</tr>
						</table>
						<table><tr><td><img src="../../img/alert.png"></td><td>La falsedad de los datos consignados impedir&aacute; la obtenci&oacute;n del beneficio.</td></tr></table>
						<table style="color:black;font-weight:bold;"><tr><td colspan="2" align="center"><font color="#f02f2f">IMPORTANTE:</font> Usted puede reservar su turno hasta con 12 meses de anticipaci&oacute;n al vencimiento. Solo debe tener en cuenta que la fecha del mismo no puede ser anterior a los 30 d&iacute;as del vencimiento de su licencia de conducir.
					<td><tr></table>
					</div>
				</div>
			</center>
		</form><br>
		<center>
			<Button class="boton" onClick="confirmarTurno()" name="Insertar">&#161;CONFIRMAR TURNO!</button>
		</center>
		<?php echo $msj; ?>
	</body>
</html>
<?php $dbh = null; ?>