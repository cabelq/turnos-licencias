<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title></title>
		<LINK rel="stylesheet" href="../../../css/principal.css" type="text/css" media="screen">
		<LINK rel="stylesheet" href="../../../css/estilo_boton.css" type="text/css" media="screen">
		<LINK rel="stylesheet" href="../../../css/table.css" type="text/css" media="screen">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body bgcolor="gray">
		<div id="recuadro">
			<center>
	<?php
		include "../../../lib/funciones.php";
		$dbh = crear_pdo();
		
		$sql="SELECT * FROM horarios WHERE publico = 1 ";
		$sth = $dbh->query( $sql );
		$total = $sth->rowCount();
		$bgcolor = '#ffffff';
		
		echo '<br><table><tr><td>';
		echo '<table class="tabla" cellpadding="0" cellspacing="0">';
		echo '<tr><td colspan="2" align="center" height="30"><strong>Horarios Publicos (' .$total. ')</strong></td></tr>';
		echo '<tr height="30px" bgcolor="#D5D5D5">
				<td align="center" width="40px"><strong>ID</strong></td>
				<td align="center" width="100px" ><strong>Hora</strong></td>
			</tr>';
		while ($row = $sth->fetch()){
			( $bgcolor == '#ffffff' ) ? $bgcolor='#bedcfa' :  $bgcolor='#ffffff';
			echo '<tr bgcolor="'.$bgcolor.'">';
			echo '<td align="center">'.$row['id'].'</td>';
			echo '<td align="center">'.$row['hora_puesto'].'</td>';
			echo '</tr>';
		}
		echo "</table>";
		echo '</td>';		
		
		$sql="SELECT * FROM horarios WHERE publico = 0 ";
		$sth = $dbh->query( $sql );
		$total = $sth->rowCount();
		$bgcolor = '#ffffff';
		
		echo '<td>';
		echo '<table class="tabla" cellpadding="0" cellspacing="0">';
		echo '<tr><td colspan="2" align="center" height="30"><strong>Horarios Sobreturnos (' .$total. ')</strong></td></tr>';
		echo '<tr height="30px" bgcolor="#D5D5D5">
				<td align="center" width="40px"><strong>ID</strong></td>
				<td align="center" width="100px" ><strong>Hora</strong></td>
			</tr>';
		while ($row = $sth->fetch()){
			( $bgcolor == '#ffffff' ) ? $bgcolor='#bedcfa' :  $bgcolor='#ffffff';
			echo '<tr bgcolor="'.$bgcolor.'">';
			echo '<td align="center">'.$row['id'].'</td>';
			echo '<td align="center">'.$row['hora_puesto'].'</td>';
			echo '</tr>';
		}
		echo "</table>";
		echo '<br></td>';
		echo '</tr></table>';
		
		echo '<br>';
		
	?>	
			</center>
		</div>
	</body>
</html>