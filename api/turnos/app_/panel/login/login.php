<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Acceso de Administradores</title>
		<LINK rel="stylesheet" href="../../../css/estilo_login.css" type="text/css" media="screen">
		<LINK rel="stylesheet" href="../css/styles_login.css" type="text/css" media="screen">
		<script src="../../../js/lib.js" type="text/javascript"></script>
	</head>
	<body style="background-color:#B2C78A">
	<center><div id="TitGrande2"><b>Renovaci&oacute;n de Licencias<br><div id="TitChico">Acceso de Administradores</div></b></div></center>
		<form name="form_login" action="./validar_usuario.php" method="post">
			<p>
			<center>
				<table>
					<tr>
						<td><b>Usuario:</b></td>
						<td><input name="usuario" value="" style="font-size:90%;" type="text" size="25"></td>
					</tr>
					<tr>
						<td><b>Password:</b></td>
						<td><input name="pass" value="" style="font-size:90%;" type="password" size="25"></td>	
					</tr>
				</table>
			</center>
			</p>
		</form>
			<center>
				<Button class="boton" onClick="login()" name="modificar">Aceptar</button>
				<Button class="boton" type="button" Language="javascript" onClick="window.document.form_login.reset()" name="modificar">Resetear</button>
			</center>
	</body>
</html>