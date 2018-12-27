<?php
	require ('../../../lib/fpdf/fpdf.php');
	include "../../../lib/funciones.php";
	$dbh = crear_pdo();
	
	$pdf = new FPDF('P', 'mm', 'A4');
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

	$ln = 35;
	$pdf->SetFont('Arial','',15);
	$pdf->MultiCell(0,10,"ASIGNACIÓN DE TURNOS: $fecha",1,'C');
	$pdf->Ln(20);
	$cnt = 0;

	//Obtengo todos los registros de Tabla maestra horarios para mostrar siempre.
	$horarios = $dbh->query( "SELECT * FROM horarios" );
	while ( $row_horarios = $horarios->fetch() ) {
		//Obtengo los turnos asignados según fecha y Id. Cuanto esto no trae nada, completo datos del Query anterior $horarios.
		$select = "SELECT * FROM turnos WHERE fecha_turno = ? AND orden_turno = ? AND fecha_anulado IS NULL";
		$sth2 = $dbh->prepare( $select );
		$sth2->execute( array($fecha,$row_horarios['id']));
		$row_turnos = $sth2->fetch();
		
		//Obtengo el Nombre y Apellido según DNI.
		$select2 = "SELECT ApeNom FROM vencimientos WHERE dni = ?";
		$sth3 = $dbh->prepare( $select2 );
		$sth3->execute( array($row_turnos['dni_vencimiento']));
		$row_nombre = $sth3->fetch();

		$orden = null;
		$dni = null;
		if ( $row_turnos['orden_turno'] == 0 || $row_turnos['orden_turno'] == '' ) {
			$orden = $row_horarios['id'];
			$turno = $row_horarios['hora_puesto'].' - LIBRE';
			$ocupado = false;
		} else {
			$ocupado = true;
			$orden = $row_turnos['orden_turno'];
			$dni = $row_turnos['dni_vencimiento'];
			$turno = $row_horarios['hora_puesto'];
		}

		$nombre = substr($row_nombre["ApeNom"],0,14);
		$pdf->SetFont('Arial','',12);
		$pdf->SetDrawColor(170,170,170);
		$pdf->SetTextColor(50,50,50);
		$pdf->SetFillColor(230,230,230);
		$pdf->MultiCell(62,10,"Turno: $orden\n$turno\n$dni $nombre",1,'L',$ocupado);
		if ( $orden == 48 ) {
			//$pdf->SetAutoPageBreak(false,8);
			$pdf->addPage();
			$pdf->SetTopMargin(10);
		}
		if ( $orden == 69 ) {
				$pdf->addPage();
		}
		$cnt++;
		if ( $cnt >= 3 ) {
			$pdf->Ln($ln);
			$cnt = 0;
		}
		$ln=+30;
		
	}
	$pdf->Output();
	$dbh = null;
?>