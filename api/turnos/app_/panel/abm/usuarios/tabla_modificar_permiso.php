<?php 
	include "../../../../lib/funciones.php";
	$dbh = crear_pdo();
	
	$query1 = "SELECT estado AS estado FROM usuarios WHERE id_usuario = ?";
	$sth1 = $dbh->prepare( $query1 );
	$sth1->execute( array($_GET['usuario']) );
	while ( $row = $sth1->fetch() ) {
		$accion = $row['estado'];
	}
	
	if ( $accion == 1 ) {
		$estado = 0;
	} else $estado = 1;
	
	$query = "UPDATE usuarios SET estado = ? WHERE id_usuario = ?";
	$sth = $dbh->prepare( $query );
	if ( $sth ) {
		$sth->execute( array($estado, $_GET['usuario']) );
	}
	
	$dbh = null;
?>