<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	include "../../../../lib/funciones.php";
	if (isset($_SESSION['k_username'])) {		
	} else {
		$mensaje_error = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>Validaci&oacute;n de Usuario: Incorrecta</title>
				<LINK rel="stylesheet" href="../../../../css/principal.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../../css/estilo_boton.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../../css/table.css" type="text/css" media="screen">
			</head>
			<body style="background-color:#bbb">
				<div id="recuadro">
					<center>
					<br><br>
						<table class="tabla_2" cellpadding="0" cellspacing="0">
						<!--DWLayoutTable-->
							<tr bgcolor="#FFBBBB">
								<td height="100px" width="600" align="center"><strong>¡Nombre de Usuario o Contrase&ntilde;a incorrectos! <br><br>
									<a href="../../login/login.php"> - Volver - </a></strong></td>
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
		<LINK rel="stylesheet" href="../../../../css/principal.css" type="text/css" media="screen">
		<LINK rel="stylesheet" href="../../../../css/estilo_boton.css" type="text/css" media="screen">
		<LINK rel="stylesheet" href="../../../../css/table.css" type="text/css" media="screen">
		<script src="../../js/lib.js" type="text/javascript"></script>
		<script src="../../js/jquery.js" type="text/javascript"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script language="JavaScript" type="text/javascript">
		// creando objeto XMLHttpRequest de Ajax
		$(document).ready(function(){
			cargar();
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
		
		function accion(div,accion,id_usuario) {
				var id = div.id.split('-');
				var B = document.getElementById('loading');
				var obDiv = document.getElementById("idImg-"+id[1]);
				obXHR.open("GET", "tabla_modificar_permiso.php?accion="+accion+"&usuario="+id_usuario);
				obXHR.onreadystatechange = function() {
					if ( obXHR.readyState == 1 ) {
						B.innerHTML = "<img src='../../../img/loading.gif'>";
					} else if ( obXHR.readyState == 4 && obXHR.status == 200 ) {
						obDiv.innerHTML = obXHR.responseText;
					} else {
						obDiv.innerHTML = obXHR.responseText;
						B.innerHTML = "";
					}
				}
				if ( $("#idImg-"+id[1]).attr('src') == '../../images/menu/no.png' ) {
					$("#idImg-"+id[1]).attr('src','../../images/menu/ok.png');
				} else {
					$("#idImg-"+id[1]).attr('src','../../images/menu/no.png');
				}
				obXHR.send(null);
			}
		
		function cargar() {
			var B = document.getElementById('loading');
			var obDiv = document.getElementById("idDiv");
			obXHR.open("GET", "tabla.php");
			obXHR.onreadystatechange = function() {
				if ( obXHR.readyState == 1 ) {
					B.innerHTML = "<img src='../../../../img/loading.gif'>";
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
				<table><tr><td><span style="color:black;font-size:12px;"><strong>HABILITAR Y DESHABILITAR EL ACCESO DE USUARIOS</strong></span></td><td width="20px" height="20px"><span id="loading"></span></td></tr></table>
				<div id="idDiv"></div>
			</center>
		</div>
		<br>
	</div>
</body>
</html>