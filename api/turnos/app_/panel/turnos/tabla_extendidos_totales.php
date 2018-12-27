<?php 
	include "../../../lib/funciones.php";
	$dbh = crear_pdo();
	$query1 = "SELECT COUNT(fecha_turno) AS total FROM turnos where fecha_turno = ? AND fecha_anulado IS NULL ORDER BY orden_turno";
	$turnos = $dbh->prepare( $query1 );
	$turnos->execute( array($_GET['fecha']) );
	while ( $row = $turnos->fetch() ) {
		echo $row['total'];
	}
?>