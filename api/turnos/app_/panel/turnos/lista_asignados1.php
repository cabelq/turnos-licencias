<?php
	require ('../../../lib/fpdf/fpdf.php');
	include "../../../lib/funciones.php";
	$dbh = crear_pdo();
	
	$pdf = new FPDF('L', 'mm', 'A4');
	$pdf->AddPage();
	$pdf->SetMargins(10, 10 , 14);
	
	if ( $_GET['dia'] != NULL ) {
		$f = explode("-", $_GET['dia']);
		$d1 = $f[0];
		$m1 = $f[1];
		$y1 = $f[2];
		$fecha = $y1."-".$m1."-".$d1;
	} else {
		$fecha = date("Y-m-d");
	}
	
	$f = explode("-", $fecha);
	$d1 = $f[2];
	$m1 = $f[1];
	$y1 = $f[0];
	$fecha2 = $d1."/".$m1."/".$y1;
	
	$ln = 35;
	$pdf->SetFont('Arial','',15);
	$pdf->MultiCell(0,10,"ASIGNACIÓN DE TURNOS: $fecha2",1,'C');
	$pdf->Ln(20);
	$cnt = 0;

	$sql = "SELECT * FROM v_turnos WHERE Fecha = '".$fecha."' AND Anulado IS NULL AND Estado_Registro_Vencimiento = 0 ORDER BY Orden ASC" ;
	$sth = $dbh->query( $sql );
	$pdf->SetFont('Arial','B',10);
	if ( $sth->rowCount() > 0 ) {
		$pdf->Cell(20,5,"DNI",0,0,'R');
		$pdf->Cell(90,5,"APELLIDO Y NOMBRE",0,0,'L');
		$pdf->Cell(10,5,"ORDEN",0,0,'R');
		$pdf->Cell(35,5,"TURNO",0,0,'C');
		$pdf->Cell(35,5,"F. SOLICITADO",0,0,'C');
		$pdf->Cell(0,5,"TIENE FALTAS",0,1,'C');
		$pdf->SetFont('Arial','',10);
		while ($row = $sth->fetch()){
			$f = explode("-", $row['Solicitado']);
			$ff = explode(" ", $f[2]);
			$solicitado = $ff[0]."/".$f[1]."/".$f[0]." ".$ff[1];
			$pdf->Cell(20,5,$row['DNI'],0,0,'R');
			$pdf->Cell(90,5,$row['Apellido_Nombre'].' ('.$row['Tel'].')',0,0,'L');
			$pdf->Cell(10,5,$row['Orden'],0,0,'R');
			$pdf->Cell(35,5,$row['Turno'],0,0,'C');
			$pdf->Cell(35,5,$solicitado,0,0,'C');
			$pdf->Cell(0,5,verificaCausa($row['DNI']),0,1,'C');
		}
	}
	
	$pdf->Output();
	$dbh = null;
?>