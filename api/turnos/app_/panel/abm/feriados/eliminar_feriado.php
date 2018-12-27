<?php
	include "../../../../lib/funciones.php";
	session_start();
	$dbh = crear_pdo();
	
	$delete = "DELETE from feriados WHERE id_feriado = ?";
	
	$sth = $dbh->prepare( $delete );
	$exito = $sth->execute( array ($_GET['id']) );
		
	if ( !($exito) ) echo '<script>alert("¡Ocurrió un error! El feriado no pudo ser eliminado!.");</script>';
	else echo '<script>alert("El feriado ha sido eliminado...");</script>';
	echo '<Script>
			location.href = "./feriados_panel.php";
		 </script>';
	$dbh = null;
?>