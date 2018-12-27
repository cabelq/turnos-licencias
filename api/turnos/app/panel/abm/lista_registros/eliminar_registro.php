<?php
	include "../../../../lib/funciones.php";
	session_start();
	$dbh = crear_pdo();
	
	$delete = "DELETE from vencimientos WHERE dni = ? AND tipo_dni = ?";
	
	$sth = $dbh->prepare( $delete );
	$exito = $sth->execute( array ($_GET['dni'],$_GET['tipo']) );
	if ( !($exito) ) echo '<script>alert("¡Ocurrió un error! El registro no pudo ser eliminado!.");</script>';
	else echo '<script>alert("El registro ha sido eliminado...");</script>';
	echo '<Script>
			location.href = "../../frames/principal.php";
		  </script>';
	$dbh = null;
?>