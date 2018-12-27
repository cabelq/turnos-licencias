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
			
			function accion(div,valor) {
				var id = div.id.split('-');
				var B = document.getElementById('loading');
				var nomDiv = id[0];				
				var obDiv = document.getElementById(nomDiv+"-"+id[1]);
				
				obXHR.open("GET", "tabla_modificar_turno.php?id="+id[1]+"&valor="+valor);
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
				
				if (valor == 0) {
					$("#idImgG-"+id[1]).attr('src','../../images/turn_off.png');
					$("#idImgY-"+id[1]).attr('src','../../images/yellow.png');
					$("#idImgR-"+id[1]).attr('src','../../images/turn_off.png');
					document.getElementById("idMsg-"+id[1]).innerHTML = "Sobreturno";
					document.getElementById("idMsg-"+id[1]).style = "color:yellow;font-weight:bold;";
					document.getElementById("recuadro-"+id[1]).style = "background:rgb(190,220,250)";
				} else if (valor == 1) {
					$("#idImgG-"+id[1]).attr('src','../../images/green.png');
					$("#idImgY-"+id[1]).attr('src','../../images/turn_off.png');
					$("#idImgR-"+id[1]).attr('src','../../images/turn_off.png');
					document.getElementById("idMsg-"+id[1]).innerHTML = "Publico";
					document.getElementById("idMsg-"+id[1]).style = "color:black;font-weight:normal;";
					document.getElementById("recuadro-"+id[1]).style = "background:white";
				} else if (valor == 3) {
					$("#idImgG-"+id[1]).attr('src','../../images/turn_off.png');
					$("#idImgY-"+id[1]).attr('src','../../images/turn_off.png');
					$("#idImgR-"+id[1]).attr('src','../../images/red.png');
					document.getElementById("idMsg-"+id[1]).innerHTML = "Cancelado";
					document.getElementById("idMsg-"+id[1]).style = "color:red;font-weight:bold;";
					document.getElementById("recuadro-"+id[1]).style = "background:pink";
				} else {
					alert ("Ocurrio un error.");
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
	<div id="recuadro" style="height:1340px">
		<div style="margin-left:10px;">
			<center>
				<br>
				<span style="color:black;font-size:12px;">
					<table>
						<tr>
							<td><strong>ADMINISTRACI&Oacute;N Y CONFIGURACI&Oacute;N DE LOS TURNOS</strong></td>
							<td width="30px" height="30px"><span id="loading"><img src='../../../../img/loading.gif'></span></td>
						</tr>
					</table>
					<table>
						<tr>
							<td colspan="3"></td>
							<td><div id="idDiv"></div></td>
						</tr>
					</table>
				</span>
			</center>
		</div>
				
		<center>
			<table>
				<tr>
					<td align="center">
						Publico
					</td>
					<td align="center">
						Sobreturno
					</td>
					<td align="center">
						Cancelado
					</td>
				</tr>
				<tr>
					<td align="center">
						<img src='../../images/green.png'>
					</td>
					<td align="center">
						<img src='../../images/yellow.png'>
					</td>
					<td align="center">
						<img src='../../images/red.png'>
					</td>
				</tr>
			</table>
		</center>
	</div>
	
</body>
</html>