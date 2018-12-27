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
			
			/*function cargarTodo() {
				//alert("lanzo proceso");
				var cnt = 0;
				while ( cnt <= 2 ) {
					var n = $('.contador').next();
					//alert(n.onClick());
					cnt++;
				}
			}*/
			
			function cargarContador(div,fecha) {
				var id = div.id.split('-');
				var B = document.getElementById('loading');
				var obDiv = document.getElementById("idDiv-"+id[1]);
				obXHR.open("GET", "tabla_extendidos_totales.php?fecha="+fecha);
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
				obXHR.send(null);
			}

			function cargar() {
				var B = document.getElementById('loading');
				var obDiv = document.getElementById("idDiv");
				obXHR.open("GET", "tabla_extendidos.php");
				obXHR.onreadystatechange = function() {
					if ( obXHR.readyState == 1 ) {
						B.innerHTML = "<img src='../../../img/loading.gif'>";
					} else if ( obXHR.readyState == 4 && obXHR.status == 200 ) {
						obDiv.innerHTML = obXHR.responseText;
						//cargarTodo();
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
	<div id="recuadro" style="height:450px;">
		<div style="margin-left:10px;">
			<center>
			<br>
			<table><tr><td><span style="color:black;font-size:12px;"><strong>VISTA R&Aacute;PIDA DE TURNOS ASIGNADOS (90 D&Iacute;AS A PARTIR DE LA FECHA)</strong></span></td>
			<td width="20px" height="20px"><span id="loading"><img src='../../../img/loading.gif'></span></td></tr></table>
			<br>
			<div id="idDiv"></div>
			</center>
		</div>
	</div>
</body>
</html>