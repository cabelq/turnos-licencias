<?php
	session_start();
	include "../../../../lib/funciones.php";
	$dbh = crear_pdo();
	$sql="SELECT * FROM horarios WHERE 1=1" ;
	$sth = $dbh->query( $sql );
	//$total = $sth->rowCount();
?>

<?php
		$cnt = 1;
		while ($row = $sth->fetch()) {
						
			$tipo = "";
			$img1 = "";
			$img2 = "";
			$img3 = "";
			if ($row['publico'] == 1 ) {
				$tipo = '<span style="color:black;font-weight:normal;" id="idMsg-'.$cnt.'">Publico</span>';
				$img1 = "../../images/green.png";
				$img2 = "../../images/turn_off.png";
				$img3 = "../../images/turn_off.png";
				echo '<div class="adminTur" id="recuadro-'.$cnt.'">';
			} elseif ($row['publico'] == 0) {
				$tipo = '<span style="color:yellow;font-weight:bold;" id="idMsg-'.$cnt.'">Sobreturno</span>';
				$img1 = "../../images/turn_off.png";
				$img2 = "../../images/yellow.png";
				$img3 = "../../images/turn_off.png";
				echo '<div class="adminTur" id="recuadro-'.$cnt.'" style="background:rgb(190, 220, 250)">';
			} elseif ($row['publico'] == 3) {
				$tipo = '<span style="color:red;font-weight:bold;" id="idMsg-'.$cnt.'">Cancelado</span>';
				$img1 = "../../images/turn_off.png";
				$img2 = "../../images/turn_off.png";
				$img3 = "../../images/red.png";
				echo '<div class="adminTur" id="recuadro-'.$cnt.'" style="background:pink">';
			} else {
				$tipo = '<span style="color:white;font-weight:bold;" id="idMsg-'.$cnt.'">ERROR</span>';
				$img1 = "../../images/turn_off.png";
				$img2 = "../../images/turn_off.png";
				$img3 = "../../images/turn_off.png";
				echo '<div class="adminTur" id="recuadro-'.$cnt.'" style="background:gray">';
			}
						
			echo '<table>
					<tr>
						<td width="40px" align="center">Id</td>
						<td width="130px">Turno</td>
						<td width="70px">Tipo</td>
						<td colspan="3" align="center">Acciones</td>
					</tr>
					<tr>';
			
			echo '<td align="center">'.$row['id']."</td><td><strong>".$row['hora_puesto'].'</strong></td><td>'.$tipo.'</td>';
			echo '<td align="center"><img title="Hacer Turno P&uacute;blico" style="cursor:pointer;width:20px;height:20px" id="idImgG-'.$cnt.'" onClick="accion(this,1);" src="'.$img1.'"></td>';
			echo '<td align="center"><img title="Hacer Sobreturno"           style="cursor:pointer;width:20px;height:20px" id="idImgY-'.$cnt.'" onClick="accion(this,0);" src="'.$img2.'"></td>';
			echo '<td align="center"><img title="Cancelar Turno"             style="cursor:pointer;width:20px;height:20px" id="idImgR-'.$cnt.'" onClick="accion(this,3);" src="'.$img3.'"></td>';
			echo '</tr></table>';
			echo "</div>";
			$cnt++;
		}
?>
	