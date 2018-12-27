<?php
	include "../../../../lib/funciones.php";
	session_start();
	$dbh = crear_pdo();
	
	$query = "UPDATE vencimientos SET tipo_dni=?, dni=?, ApeNom=?, tel=?, email=?, fech_hab=? WHERE dni=? AND tipo_dni = ?";
	$sth = $dbh->prepare( $query );
	
	if ( $sth ) {
		if(trim($_POST['dni']) != "" && trim($_POST['ApeNom'])) {
			$tipo = strtoupper(($_POST['tipo']));
			$nombre = strtoupper(($_POST['ApeNom']));
			$sth->execute( array($tipo, $_POST['dni'], $nombre, $_POST['tel'], $_POST['email'], $_POST["vencimiento"], $_POST['dni'], $_POST['tipo']) );
			echo '<script>alert("El Registro ha sido modificado!");</script>';
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