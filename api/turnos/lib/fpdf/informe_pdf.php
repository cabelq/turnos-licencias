<?php
require('fpdf.php');

class INFORME extends FPDF
{
	public $fecha_inf;
	public $empresa_nom;
	public $informe_cod;

	function setFecha($fecha){
		$this->fecha_inf = $fecha;
	}

	function getFecha(){
		return $this->fecha_inf;
	}
	
	function setEmpresa($emp){
		$this->empresa_nom = $emp;
	}
	
	function setCodigo($cod){
		$this->informe_cod = $cod;
	}	
	
	function caratula($logo){
		$this->Image($logo);
	}

	//Cabecera de página
	function Header()
	{
		if ($this->PageNo() == 1){
			$this->Rect(17, $this->GetY(), 180, 253);
			//Logo
			$this->Image('../../../images/imagen_caratula.jpg',20,11,75);
			//Arial bold 15
			$this->SetFont('Arial','B',15);
		   
		   /*//Movernos a la derecha
			$this->Cell(80);
			//Título
			$this->Cell(30,10,'Title',1,0,'C');*/
		   
		   //Salto de línea
			$this->Ln(30);
		}else{
			
			 $this->Cell(55,15,$this->Image('../../../images/logo.jpg',20,11,40),1,0,'C');
			 $this->Cell(70,15,'Informe predictivo por Ultrasonido',1,0,'C');
			 $this->Cell(55,15,"Fecha: ".$this->getFecha(),1,0,'C');
			 $this->Ln();
			 $this->Cell(55,5,'Mantenimiento Predictivo',1,0,'C');
			 $this->Cell(70,5,"$this->empresa_nom",1,0,'C');
			 $this->Cell(55,5,"$this->informe_cod",1,0,'C');
			 $this->Ln(10);
		
		}
	}

	//Pie de página
	function Footer()
	{
		if ($this->PageNo() == 1){
			//no hacer nada
		}else{
			//Posición: a 1,5 cm del final
			$this->SetY(-15);
			//Arial italic 8
			$this->SetFont('Arial','I',8);
			//Número de página
			
			$this->Cell(90,5,'Predicson S.H.',1,0,'C');
			$this->Cell(90,5,'Página '.$this->PageNo().'/{nb}',1,0,'C');
			//$this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',1,0,'C');
		}
	}

	function fila($columnas, $anchos, $alto=5)
	{
		for($i=0;$i<count($columnas);$i++)
			$this->Cell($anchos[$i],$alto,$columnas[$i],1,0,'C');
		$this->Ln();
	}

	function filaAuto($columnas, $anchos, $alto=7)
	{
		$nlineas_mayor = 0;
		for($i=0;$i<count($columnas);$i++){
			$nl = $this->MultiCellSimulate($anchos[$i],$alto,$columnas[$i], 1);
			if ($nl > $nlineas_mayor) $nlineas_mayor=$nl;
		}
		
		for($i=0;$i<count($columnas);$i++){
			
			$nlineas = $this->MultiCellSimulate($anchos[$i],$alto,$columnas[$i], 1);
			if ($nlineas < $nlineas_mayor){
				$lineas_faltantes = ($nlineas_mayor-$nlineas)+1;
				$lineas_extras = str_repeat ("\n", $lineas_faltantes);
				$columnas[$i].= $lineas_extras;
			}
		}
		
		for($i=0;$i<count($columnas);$i++){
			$this->MultiCell($anchos[$i],$alto,"$columnas[$i]", 1);
		}
		
		$y=$nlineas_mayor*$alto;
		$this->Ln($y);
		return $y;
	}

	function filaAutoSimular($columnas, $anchos, $alto=7)
	{
		$nlineas_mayor = 0;
		for($i=0;$i<count($columnas);$i++){
			$nl = $this->MultiCellSimulate($anchos[$i],$alto,$columnas[$i], 1);
			if ($nl > $nlineas_mayor) $nlineas_mayor=$nl;
		}
		$y=$nlineas_mayor*$alto;
		return $y;
	}
	
	function cierre_tabla($anchos){
		$this->Cell(array_sum($anchos),0,'','T');
	}

}