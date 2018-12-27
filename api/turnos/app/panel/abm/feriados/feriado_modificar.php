<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php	
	include "../../../../lib/funciones.php";
	$dbh = crear_pdo();
	$query = 'SELECT * FROM feriados where id_feriado = ?';
	$sth = $dbh->prepare( $query );
	$sth->execute( array($_GET['id']));
	if ($sth) {
		while ( $row = $sth->fetch() ) {
		$f = explode("-", $row["fecha"]);
		$d1 = $f[0];
		$m1 = $f[1];
		$y1 = $f[2];
		$fecha = $y1."-".$m1."-".$d1;
		
?>		
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>		
		<LINK rel="stylesheet" href="../../css/estilo_boton.css" type="text/css" media="screen">		
		<script src="../../js/lib.js" type="text/javascript"></script>
		<script src="../../js/jquery.js" type="text/javascript"></script>
		<script language="JavaScript" src="../../js/calendar1.js"></script>
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
	<form style="padding-top:10px;padding-bottom:10px;"name="modificar_feriado" action="./modificar_feriado_grabar.php" method="post">			
		<strong>Modificar Feriado:</strong>			
		<hr size="3" width="100%" color="grey">
		<table>
			<tr>
			<?php 
				echo '<td>Fecha:</td>';
				echo '<td align="left"><input style="height:10px;font-size:10px" name="fecha" readonly size="10" maxlength="10" value="'.$fecha.'" type="text" size="10">';
				echo '<a href="javascript:cal.popup();">';
				echo '<img src="../../../../img/cal.gif" width="18" height="18" valign="middle" border="0"';
				echo 'title="Seleccione la Fecha"></a></td>';
			?></tr>
			<tr><td>Descripci&oacute;n:</td><td ><input <?php echo 'value = "'.$row['descripcion'].'"'; ?> style="width:370px;text-transform:uppercase;height:10px;font-size:10px;float:left;" type="text" name="desc" id="desc"></td></tr>
			<input type="hidden" name="id" id="id" <?php echo 'value = "'.$_GET['id'].'"' ?> >
		</table>
		<script>
			var cal = new calendar1(document.modificar_feriado.fecha);
			cal.year_scroll = true;
			cal.time_comp = false;
		</script>
	</form>
	<?php				
		}
	} else echo 'Falló operación';	
	?>
		<center>
		<div class="BotUbi">
			<Button class="boton" onClick="grabModFer()" name="grabar">Aceptar</button>
			<Button class="boton" Language="javascript" onclick="window.close()">Cancelar</button>
		</div>			
		</center>		
	</body>
</html>