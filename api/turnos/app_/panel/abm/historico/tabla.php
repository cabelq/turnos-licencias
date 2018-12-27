<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title></title>
	</head>
	<body>
	<?php
		include "../../../../lib/funciones.php";
		$dbh = crear_pdo();
		
		$sql="SELECT * FROM v_turnos WHERE 1=1 " ;
		if ( isset( $_GET['dni'] ) && $_GET['dni'] != null ) {
			$dni = $_GET['dni'];
			$sql .=  " AND DNI = ".$dni;
		}
		$sql .= " ORDER BY fecha DESC";
		$sth = $dbh->query( $sql );
		$total = $sth->rowCount();
		$bgcolor = '#ffffff';
		if ($total < 100) { //Pongo como limite 100 para que no tenga que cargar tantos registros en memoria.
			echo '<br><table class="tabla" cellpadding="0" cellspacing="0">';
			echo '<tr height="30px" bgcolor="#D5D5D5">
					<td align="center" width="90px"><strong>DNI</strong></td>
					<td align="center" width="250px" ><strong>Apellido y Nombre</strong></td>
					<td align="center" style="color:black;" width="130px" ><strong>DELETEADO</strong></td>
					<td align="center" width="70px" ><strong>Vencimiento</strong></td>
					<td align="center" width="70px" ><strong>Fecha</strong></td>
					<td align="center" width="130px" ><strong>Turno</strong></td>
					<td width="40px" ><strong>Anulado</strong></td>
					<td align="center" width="120px" ><strong>Anul&oacute;</strong></td>
					<td align="center" width="70px" ><strong>D&iacute;a</strong></td>
					<td align="center" width="300px" ><strong>Motivo</strong></td>
				</tr>';
				$msg = "";
			while ($row = $sth->fetch()){
				( $bgcolor == '#ffffff' ) ? $bgcolor='#bedcfa' :  $bgcolor='#ffffff';
				if ( $row['Estado_Registro_Vencimiento'] == "1" ) {
					echo '<tr style="color:black;" bgcolor="pink">';
					$msg = "Eliminado por duplicado.";
				} else {
					if ( $row['Anulado'] == "" ) $bgcolor='#9ACD32';
					echo '<tr bgcolor="'.$bgcolor.'">';
				}
				echo '<td align="center">'.$row['DNI'].'</td>';
				echo '<td align="left">'.utf8_encode(ucwords($row["Apellido_Nombre"])).' </td>';
				echo '<td align="center">'.$msg.'</td>';
				$v = explode("-", $row["Vencimiento"]);$d1 = $v[0];$m1 = $v[1];$y1 = $v[2];
				$vencimiento = $y1."/".$m1."/".$d1;echo '<td align="center">'.$vencimiento.'</td>';
				$t = explode("-", $row["Fecha"]);$d1 = $t[0];$m1 = $t[1];$y1 = $t[2];
				$turno = $y1."/".$m1."/".$d1;echo '<td align="center"><strong>'.$turno.'</strong></td>';
				echo '<td align="center"><strong>'.$row['Turno'].' ('.$row['Orden'].')</strong></td>';
				if ( $row['Anulado'] == "" ) {
					$anulado = "<strong>No</strong>";
					echo '<td align="center" >'.$anulado.'</td>';
				}
				else {
					$anulado = "Si";
					echo '<td align="center" style="color:red"  ><strong>'.$anulado.'</strong></td>';
				}
				echo '<td align="center" style="color:red">'.utf8_encode($row["Usuario"]).'</td>';
				$anulado = null;
				if ( $row["Anulado"] != "" ) {
					$f = explode("-", $row["Anulado"]);
					$anulado = $f[2].'/'.$f[1].'/'.$f[0];
					echo '<td align="center" style="color:red">'.$anulado.'</td>';
				} else echo '<td align="center" >'.$anulado.'</td>';
				echo '<td align="center">'.utf8_encode($row['Motivo']).'</td>';
				echo '</tr>';
				$msg = "";
			}
			echo "</table>";
			echo '<table><tr><td>Ser&aacute;n marcados con color </td><td style="background:#9ACD32;" width="15px"></td><td>los turnos que NO hayan sido ANULADOS.</td></tr>';
			echo '<tr><td>Ser&aacute;n marcados con color </td><td style="background:pink;" width="15px"></td><td>los turnos en donde la persona haya sido borrada por DNI Duplicado.</td></tr></table>';
			echo '<br><div style="color:blue;">COINCIDENCIAS ENCONTRADAS: '.$total.'</div>';
		} else {
			echo '<br><div style="color:red;">Demasiadas coincidencias. Contin&uacute;e ingresando datos para su b&uacute;squeda...</div>';
		}
		
	?>
	</body>
</html>