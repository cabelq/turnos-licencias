<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	$fecha = date("d-m-Y");
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
	<form style="padding-top:10px;padding-bottom:10px;"name="nuevo_feriado" action="./nuevo_feriado_grabar.php" method="post">			
		<strong>Nuevo Feriado:</strong>			
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
			<tr><td>Descripci&oacute;n:</td><td ><input value="" style="width:370px;text-transform:uppercase;height:10px;font-size:10px;float:left;" type="text" name="desc" id="desc"></td></tr>
		</table>
		<script>
			var cal = new calendar1(document.nuevo_feriado.fecha);
			cal.year_scroll = true;
			cal.time_comp = false;
		</script>
	</form>
		<center>
		<div class="BotUbi">
			<Button class="boton" onClick="grabNvoFer()" name="grabar">Aceptar</button>
			<Button class="boton" Language="javascript" onclick="window.close()">Cancelar</button>
		</div>			
		</center>		
	</body>
</html>