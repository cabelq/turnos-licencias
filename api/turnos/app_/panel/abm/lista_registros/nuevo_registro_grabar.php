<?php
	include "../../../../lib/funciones.php";
	session_start();
	$dbh = crear_pdo();
	
	$query = "INSERT INTO vencimientos (dni, tipo_dni, ApeNom, fech_hab, tel, email) VALUES (?,?,?,?,?,?)";
	$sth = $dbh->prepare( $query );
	
	if( verificaDNI($_POST['dni']) == 0 ) {
		if ( $sth ) {
			if(trim($_POST['dni']) != "" && trim($_POST['ApeNom']) != "" && trim($_POST['vencimiento']) != "" && trim($_POST['email']) != "") {
				$tipo = strtoupper(($_POST['tipo']));
				$nombre = strtoupper(($_POST['ApeNom']));
				$sth->execute( array($_POST['dni'], $tipo, $nombre, $_POST['vencimiento'], $_POST['tel'], $_POST['email']));
				echo '<script>alert("El nuevo Registro ha sido agregado a la base de datos!");</script>';
				echo '<script>window.vlose();</script>';
			} else {
				echo '<script>alert("Ha ocurrido un error al intentar recibir los datos...");</script>';
			}
		} else {
			echo '<script>alert("Ha ocurrido un error al intentar grabar el registro...");</script>';
		}
	} else {
		echo '<script>alert("Ya existe una persona con ese DNI. La operacion ha sido cancelada.");</script>';
		echo '<script>history.go(-1);</script>';
	}
	$dbh = null;
?>