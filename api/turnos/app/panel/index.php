<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">

<?php
	if (isset($_SESSION['k_username'])) {		
	} else {
		$mensaje_error = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>Validación de Usuario: Incorrecta</title>
				<LINK rel="stylesheet" href="../../css/principal.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../css/estilo_boton.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../css/table.css" type="text/css" media="screen">
				<style type="text/css">
					body {
						background:#D8D8D8;
						font-family: Arial, Helvetica, Sans-Serif;
						font-size: 13px;
					}
				</style>
			</head>
			<body>
				<div id="recuadro">
					<center><br><br>
						<table class="tabla_2" cellpadding="0" cellspacing="0">
						<!--DWLayoutTable-->
							<tr bgcolor="#FFBBBB">
								<td height="100px" width="600" align="center"><strong>¡Nombre de Usuario o Contraseña incorrectos! <br><br>
									<a href="./login/login.php"> - Volver - </a></strong></td>
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

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>TURNOS LIC. CONDUCIR - Municipalidad de Luj&aacute;n</title>
		<LINK rel="stylesheet" href="../../css/principal.css" type="text/css" media="screen">
	</head>
	<frameset rows="35,*" cols="*" frameborder="0" border="0" framespacing="0">
		<frame name="menu" src="./frames/menu.php" marginheight="0px" marginwidth="0px" scrolling="auto" noresize>
		<frame name="principal" src="./frames/principal.php" marginheight="1" marginwidth="1" scrolling="auto" noresize>
	</frameset>
	<noframes>
		<body>
			<h2>Su explorador no le permite visualizar el sitio correctamente.<br>
			Por favor actualice su explorador.<br>
			Le recomendamos utilizar cualquier versión de Google Chorme o Mozilla Firefox.</h2>
		</body>
	</noframes>
</html>
