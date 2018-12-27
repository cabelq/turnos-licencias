<?php
	session_start();
	require ('../lib/fpdf/fpdf.php');
	include "../lib/funciones.php";
	
	generoComprobante3($_GET['tipo_dni'],$_GET['dni'],$_GET['fecha'],$_GET['hora'],$_GET['turno'],$_GET['apeNom'],$_GET['tel'],0,$_GET['rutaFondo'],$_GET['msjRutaFalta'],'',$_GET['procedencia'],$_GET['descargar']);

?>