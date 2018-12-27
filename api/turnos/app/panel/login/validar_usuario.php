<?php
	//ini_set( "session.cookie_lifetime" , 28800 );
	include "../../../lib/funciones.php";
	session_start();
	$dbh = crear_pdo();
	
	$mensaje_error = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>Validación de Usuario: Incorrecta</title>
				<LINK rel="stylesheet" href="../../../css/principal.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../css/estilo_boton.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../css/table.css" type="text/css" media="screen">
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
									<a href="login.php"> - Volver - </a></strong></td>
							</tr>
						</table>
					<br><br>
				</div>
			</body>
		</html>
INI;

	$mensaje_error_1 = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>Validación de Usuario: Incorrecta</title>
				<LINK rel="stylesheet" href="../../../css/principal.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../css/estilo_boton.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../css/table.css" type="text/css" media="screen">
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
								<td height="100px" width="600" align="center"><strong>¡Usted no tiene permiso de acceso al Sistema! <br><br>
									<a href="login.php"> - Voler - </a></strong></td>
							</tr>
						</table>
					<br><br>
				</div>
			</body>
		</html>
INI;

$mensaje_error_hora = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>Validación de Usuario: Incorrecta</title>
				<LINK rel="stylesheet" href="../../../css/principal.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../css/estilo_boton.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../css/table.css" type="text/css" media="screen">
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
								<td height="100px" width="600" align="center"><strong>Horario de acceso no permitido...<br><br>
									<a href="login.php"> - Voler - </a></strong></td>
							</tr>
						</table>
					<br><br>
				</div>
			</body>
		</html>
INI;

	$mensaje_ok = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>Validación de Usuario: Correcta</title>
				<LINK rel="stylesheet" href="../../../css/principal.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../css/estilo_boton.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../css/table.css" type="text/css" media="screen">
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
						<table class="tabla_3" cellpadding="0" cellspacing="0">
						<!--DWLayoutTable-->
							<tr bgcolor="#B0E0E6">
								<td height="50px" width="600" align="center"><strong>¡Usuario logueado correctamente!</strong></td>
							</tr>
						</table>
					<br><br>
				</div>
			</body>
		</html>
INI;
	
	if(trim($_POST['usuario']) != "" && trim($_POST['pass']) != "") {
		$password = md5($_POST["pass"]);
		$usuario = strtolower(htmlentities($_POST["usuario"], ENT_QUOTES));
		//$pass = md5($password);
		$sth = $dbh->prepare("SELECT * FROM usuarios WHERE usuario = ?");
		$sth->execute( array($usuario) );
		if( $row = $sth->fetch() ) {
			if($row["password"] == $password) {
				if ( $row["estado"] == 1 ) {
					if ( time() <= strtotime( "13:00:00" ) || $row ['tipo'] == 1 ) {
						$_SESSION["k_username"] = $row ['password'];
						$_SESSION["usuario_nombre"] = $row ['usuario'];
						$_SESSION["usuario"] = $row ['ApeNom'];
						$_SESSION["Id"] = $row['id_usuario'];
						$_SESSION["tipo_usuario"] = $row['tipo'];
						//Grabo en LOGS//
						$sth2 = $dbh->prepare("INSERT INTO logs (id_usuario, entra) VALUES (?,?)");
						$fechHora =  date("Y-m-d H:i:s");
						$sth2->execute(array($row['id_usuario'], $fechHora));
						echo $mensaje_ok;
						echo '<Script>location.href = "../index.php";</script>';
					} else {
						grabarLogNoPermitido($_POST['usuario'],$_POST['pass']);
						echo $mensaje_error_hora;
					}
				} else {
					grabarLogNoPermitido($_POST['usuario'],$_POST['pass']);
					echo $mensaje_error_1;
				}
			} else {
				echo $mensaje_error;
			}
		} else {
			echo $mensaje_error;
		}
		
		$sth = null;
	} else {
		echo $mensaje_error;
	}
	$dbh = $sth = $sth2 = null;
?>