<?php
require('fpdf.php');

class PDF extends FPDF
{

public $hojaNro;

function setHojaNro($nro){
	$this->hojaNro = $nro;
}

function getHojaNro(){
	return $this->hojaNro;
}




//Cargar los datos
function LoadData($file)
{
    //Leer las líneas del fichero
    $lines=file($file);
    $data=array();
    foreach($lines as $line)
        $data[]=explode(';',chop($line));
    return $data;
}

//Una tabla más completa
function ImprovedTable($header,$data)
{
    //Anchuras de las columnas
    $w=array(40,35,40,75);
    //Cabeceras
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    //Datos
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    //Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}

function titulo_ppal($titulo, $anchos){
	$this->Cell(array_sum($anchos),5,"$titulo",0,0,'C');
	$this->Ln();
}

function titulo($titulo, $anchos){
	$this->Cell(array_sum($anchos),5,"$titulo",1,0,'C');
	$this->Ln();
}

function fila($columnas, $anchos)
{
    for($i=0;$i<count($columnas);$i++)
        $this->Cell($anchos[$i],5,$columnas[$i],1,0,'C');
    $this->Ln();
}

function cierre_tabla($anchos){
	$this->Cell(array_sum($anchos),0,'','T');
}

function br($altura){
	$this->Ln();
	$this->Cell(0,$altura);
	$this->Ln();
}

function Footer()
{
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','I',8);
	//Número de página
	$this->Cell(170,5,'Predicson S.H. - HOJA DE RUTA Nº '. $this->getHojaNro(),1,0,'C');
	$this->Cell(170,5,'Página '.$this->PageNo().'/{nb}',1,0,'C');
}

}
?>