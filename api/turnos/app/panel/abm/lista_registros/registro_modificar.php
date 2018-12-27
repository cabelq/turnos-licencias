<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php	
	include "../../../../lib/funciones.php";
	$dbh = crear_pdo();
	$query = 'SELECT * FROM vencimientos where dni = ? AND tipo_dni = ?';
	$sth = $dbh->prepare( $query );
	$sth->execute( array($_GET['dni'] , $_GET['tipo']));
	if ($sth) {
		while ( $row = $sth->fetch() ) {
		$query2 = "SELECT * FROM turnos WHERE id_turno = ?";
		$sth2 = $dbh->prepare( $query2);
		$sth2->execute( array($row['id_turno']));
		$turno = null;
		if($sth2) {
			while ( $row2 = $sth2->fetch() ) {
				$f = explode("-", $row2["fecha_turno"]);
				$d1 = $f[0];
				$m1 = $f[1];
				$y1 = $f[2];
				$fecha = $y1."/".$m1."/".$d1;
				$turno = $fecha.' - ('.$row2['hora_puesto'].')';
			}
		} else {
			$turno = '';
		}
		
?>		
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>		
		<LINK rel="stylesheet" href="../../css/estilo_boton.css" type="text/css" media="screen">		
		<script src="../../js/lib.js" type="text/javascript"></script>		
		<script src="../../js/jquery.js" type="text/javascript"></script>		
		<script type="text/javascript">			
		//JQUERY PARA CERRAR CON SCAPE			
		$(document).keydown(function(e){  				
			if(e.keyCode == 27){
			window.close();
			}
		});
		</script>
	</head>	
<body style="background-color:#eee; color:black;">		
	<form style="padding-top:10px;padding-bottom:10px;"name="modificar_registro" action="./modificar_registro_grabar.php" method="post">			
		<strong>Nuevo Registro:</strong>			
		<hr size="3" width="100%" color="grey">
		<table>
			<tr><td>DNI: (Sin puntos)</td><td><input <?php echo 'value = "'.$row['dni'].'"'; ?> style="height:10px;font-size:10px;float:left;" type="text" name="dni" id="dni"></td></tr>
			
			<tr><td>TIPO Documento</td><td><input <?php echo 'value = "'.$row['tipo_dni'].'"'; ?> style="text-transform:uppercase;height:10px;font-size:10px;float:left;" type="text" name="tipo" id="tipo"></td></tr>
			
			<tr><td>Apellido y Nombre:</td><td><input <?php echo 'value = "'.$row['ApeNom'].'"'; ?> style="text-transform:uppercase;height:10px;font-size:10px;width:250px;float:left;" type="text" name="ApeNom" id="ApeNom"></td></tr>
			
			<tr><td>F. Vencimiento: (aaaa-mm-dd)</td><td><input <?php echo 'value = "'.$row['fech_hab'].'"'; ?> style="height:10px;font-size:10px;float:left;" type="text" name="vencimiento" id="vencimiento"></td></tr>
			
			<tr><td>Tel&eacute;fono</td><td><input <?php echo 'value = "'.$row['tel'].'"'; ?> style="width:250px;height:10px;font-size:10px;float:left;" type="text" name="tel" id="tel"></td></tr>
			
			<tr><td>E-Mail:</td><td><input <?php echo 'value = "'.$row['email'].'"'; ?> style="width:250px;height:10px;font-size:10px;float:left;" type="text" name="email" id="email"></td></tr>
			
			<tr><td>&Uacute;ltimo Turno asignado:</td><td><input <?php echo 'value = "'.$turno.'"'; ?> style="width:250px;height:10px;font-size:10px;float:left;" type="text" name="turno" id="turno" disabled="disabled"></td></tr>
		</table>
	</form>
	<?php				
		}
	} else echo 'Falló operación';	
	?>
		<center>
		<div class="BotUbi">
			<Button class="boton" onClick="grabModReg()" name="grabar">Aceptar</button>
			<Button class="boton" Language="javascript" onclick="window.close()">Cancelar</button>
		</div>			
		</center>		
</body>
</html>