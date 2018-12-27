<?php
include "../../lib/funciones.php";
$dbh = crear_pdo();

// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"select1"=>"select_1",
"select2"=>"horarios",
);

function validaSelect($selectDestino) {
	// Se valida que el select enviado via GET exista
	global $listadoSelects;
	if(isset($listadoSelects[$selectDestino])) return true;
	else return false;
}

function validaOpcion($opcionSeleccionada) {
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}
//$fecha_text = $_GET["fecha"];
$f = explode ("/", $_GET["fecha"]);
$d1 = $f[0];
$m1 = $f[1];
$y1 = $f[2];
$f1 = $y1."-".$m1."-".$d1;
//echo $f1;
$selectDestino=$_GET["select"];
$opcionSeleccionada=1;

if ( validaSelect( $selectDestino ) && validaOpcion ( $opcionSeleccionada ) ) {
	$dbh = crear_pdo();
	//$select = "SELECT * FROM horarios h WHERE h.hora_puesto NOT IN (SELECT t.hora_puesto FROM turnos t where fecha_turno = ? AND fecha_anulado IS NULL)"; //Consulto todos los turnos asignados para ese dia.
	  $select = "SELECT * FROM horarios h WHERE h.hora_puesto NOT IN (SELECT t.hora_puesto FROM turnos t where fecha_turno = ? AND fecha_anulado IS NULL) AND publico = 0"; //Consulto todos los turnos asignados para ese dia.
	$sth2 = $dbh->prepare( $select );
	$sth2->execute( array($f1));
	if ( $sth2->rowCount() <= 0 ) { //Para saber si en el dia seleccionado hay al menos un turno asignado.
		echo "<select style=width:290px;' disabled='disabled' name='".$selectDestino."' id='".$selectDestino."'>";
		echo "<option value='0'>No hay turnos disponibles</option>";
	} else {
		echo "<select style=width:290px;' name='".$selectDestino."' id='".$selectDestino."'>";
		echo "<option value='1'>Seleccione hora...</option>";
	}
	foreach( ($row2 = $sth2->fetchAll()) as $d=>$e ) {
		//if ( $e["id"]%3!=0 ) { //Evito mostrar los turnos reservados para otorgar manualmente en oficina de licencias (Todos los Puestos 3).
			echo "<option value='".$d.",$e[hora_puesto],$e[id]'>".$e['hora_puesto']."</option>";
		//}
	}
	echo "</select>";
}
$dbh = null;
?>