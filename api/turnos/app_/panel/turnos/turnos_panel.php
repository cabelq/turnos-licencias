<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	include "../../../lib/funciones.php";
	$_SESSION['hoy'] = 0;
	if (isset($_SESSION['k_username'])) {		
	} else {
		$mensaje_error = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>Validaci&oacute;n de Usuario: Incorrecta</title>
				<LINK rel="stylesheet" href="../../../css/principal.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../css/estilo_boton.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../css/table.css" type="text/css" media="screen">
			</head>
			<body style="background-color:#bbb">
				<div id="recuadro">
					<center>
					<br><br>
						<table class="tabla_2" cellpadding="0" cellspacing="0">
						<!--DWLayoutTable-->
							<tr bgcolor="#FFBBBB">
								<td height="100px" width="600" align="center"><strong>¡Nombre de Usuario o Contrase&ntilde;a incorrectos! <br><br>
									<a href="../login/login.php"> - Volver - </a></strong></td>
							</tr>
						</table>
					<br><br>
				</div>
			</body>
		</html>
INI;
		die($mensaje_error);
	}
?>
	<head>
		<title>TURNOS LIC. CONDUCIR - Municipalidad de Luj&aacute;n</title>
		<LINK rel="stylesheet" href="../../../css/principal.css" type="text/css" media="screen">
		<LINK rel="stylesheet" href="../../../css/estilo_boton.css" type="text/css" media="screen">
		<LINK rel="stylesheet" href="../../../css/table.css" type="text/css" media="screen">
		<script src="../js/lib.js" type="text/javascript"></script>
		<script src="../js/jquery.js" type="text/javascript"></script>
		<script language="JavaScript" type="text/javascript">
			// creando objeto XMLHttpRequest de Ajax
			
			$(document).ready(function(){
				if( $(':hidden#hoy').val() == 0 ) {
					cargar(0);
				}
			});
			
			var obXHR;
			try {
				obXHR=new XMLHttpRequest();
			} catch(err) {
				try {
					obXHR=new ActiveXObject("Msxml2.XMLHTTP");
				} catch(err) {
					try {
						obXHR=new ActiveXObject("Microsoft.XMLHTTP");
					} catch(err) {
						obXHR=false;
					}
				}
			}

			function a() {
				if( $("#dni").attr("value") == '' && $("#fecha").attr("value") == '' ) {
					$(':hidden#hoy').val(0);
					cargar(0);
				}
			}

			function cargar(s) {
				var B = document.getElementById('loading');
				var obDiv = document.getElementById("idDiv");
				obXHR.open("GET", "tabla.php?dni="+$("#dni").attr("value")+"&fecha="+$("#fecha").attr("value")+"&hoy="+s);
				obXHR.onreadystatechange = function() {
					if ( obXHR.readyState == 1 ) {
						B.innerHTML = "<img src='../../../img/loading.gif'>";
						obDiv.innerHTML = "Cargando...";
					} else if ( obXHR.readyState == 4 && obXHR.status == 200 ) {
						obDiv.innerHTML = obXHR.responseText;
					} else {
						obDiv.innerHTML = obXHR.responseText;
						B.innerHTML = "";
					}
				}
				obXHR.send(null);
			}
		</script>
	</head>

<body bgcolor="gray">
	<div id="recuadro">
		<div style="margin-left:10px;">
			<center>
				<br>
				<span style="color:black;font-size:12px;"><strong>ADMINISTRADOR DE TURNOS</strong></span>
				<br><br>
				<div>
					<table><tr><td><strong>OPCIONES DE B&Uacute;SQUEDA: </strong>
					DNI: <input style="text-align:center;width:120px;" id="dni" name="dni" value="" type="text" onkeyup="cargar(1);a()">
					Fecha: <input style="text-align:center;width:120px;" id="fecha" name="fecha" value="<?php echo date('Y-m-d') ?>" type="text" onkeyup="cargar(1);a()"></td>
					<input type="hidden" id="hoy" name="hoy" value="<?php $_SESSION['hoy']; ?>">
					<td width="20px"><span id="loading"><img src='../../../img/loading.gif'></span></td>
					<td>
						<div style="float:right;margin-right:10px;padding-top:1px;margin-top:-4px;width:300px;background:#D5D5D5;border:1px solid black;height:30px;">
							<input style="margin-left:20px;text-align:center;width:120px;" id="fechaAsig" name="fechaAsig" value="<?php echo date('d-m-Y'); ?>" type="text">
							<Button style="height:26px;width:auto;background:#EEE;" class="boton" onClick="popupSizablePosition2('./lista_asignados.php',fechaAsig.value,1100,700,10,10);" name="nuevo">Imprimir Asignados</button>
						</div>
					</td>
				</div>
				</tr></table>
				<div id="idDiv"></div>
				<br>
			</center>
		</div>
	</div>
</body>
</html>