<?php
	include "../../../lib/funciones.php";
	session_start();
	$dbh = crear_pdo();
	
	if (isset($_SESSION['Id'])) {
		$id_usuario = $_SESSION['Id'];
	} else {
		$id_usuario = null;
	}
	
	$delete = "UPDATE turnos SET fecha_anulado = ?,id_usuario_delete = ? WHERE id_turno = ?";
	$update = "UPDATE vencimientos SET id_turno = ? WHERE id_turno = ?";
	
	$sth = $dbh->prepare( $delete );
	$sth2 = $dbh->prepare( $update );
	
	$exito = $sth->execute( array (date('Y-m-d'),$id_usuario,$_GET['id']) );
	$exito2 = $sth2->execute( array (0,$_GET['id']) );
		
	if ( !($exito && $exito2) ) echo '<script>alert("¡Ocurrió un error! El turno no pudo ser eliminado!.");</script>';
	else echo '<script>alert("El turno ha sido eliminado...");</script>';
	echo '<Script>
			location.href = "../../panel/turnos/turnos_panel.php";
		  </script>';
	$dbh = null;
?>