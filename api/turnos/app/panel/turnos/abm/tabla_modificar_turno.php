<?php 

	session_start();
	include "../../../../lib/funciones.php";
	$dbh = crear_pdo();
	
	echo '<script>alert("Entro 1.");</script>';
	$query = "UPDATE horarios SET publico = ? WHERE id = ?";
	$sth = $dbh->prepare( $query );
	if ( $sth ) {
		$sth->execute( array($_GET['valor'], $_GET['id']) );
		echo '<script>alert("Modificado correctamente.");</script>';
	}
	
	$dbh = null;
?>