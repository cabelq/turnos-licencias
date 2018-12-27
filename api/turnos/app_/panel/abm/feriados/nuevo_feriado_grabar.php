<?php
	include "../../../../lib/funciones.php";
	session_start();
	$dbh = crear_pdo();
	
	$query = "INSERT INTO feriados (fecha, descripcion) VALUES (?,?)";
	$sth = $dbh->prepare( $query );
	
	if ( $sth ) {
		if(trim($_POST['desc']) != "" && trim($_POST['fecha']) != "" ) {
			$f = explode("-", $_POST['fecha']);
			$d1 = $f[0];
			$m1 = $f[1];
			$y1 = $f[2];
			$fecha = $y1."-".$m1."-".$d1;
			$sth->execute( array($fecha, $_POST['desc']));
			echo '<script>alert("El nuevo Feriado ha sido agregado a la base de datos!");</script>';
		} else {
			echo '<script>alert("Ha ocurrido un error al intentar recibir los datos...");</script>';
		}
	} else {
		echo '<script>alert("Ha ocurrido un error al intentar grabar el registro...");</script>';
	}
	echo '<Script>
			window.opener.location.href = window.opener.location.href;
			if (window.opener.progressWindow) {
				window.opener.progressWindow.close()
			}
			window.close();
		  </script>';
	$dbh = null;
?>