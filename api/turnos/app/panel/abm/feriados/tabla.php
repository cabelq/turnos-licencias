<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title></title>
	</head>
	<body>
	<?php
		include "../../../../lib/funciones.php";
		$dbh = crear_pdo();
		
		$sql="SELECT * FROM feriados WHERE 1=1 " ;
		if ( isset( $_GET['anio'] ) && $_GET['anio'] != null ) {
			$anio = $_GET['anio'];
			$sql .=  " AND fecha LIKE '%".$anio."%'";
		}
		$sql .= " ORDER BY fecha ASC";
		$sth = $dbh->query( $sql );
		$total = $sth->rowCount();
		$bgcolor = '#ffffff';
		if ($total < 100) { //Pongo como limite 100 para que no tenga que cargar tantos registros en memoria.
			echo '<br><table class="tabla" cellpadding="0" cellspacing="0">';
			echo '<tr height="30px" bgcolor="#D5D5D5">
					<td align="center" width="40px"><strong>ID</strong></td>
					<td align="center" width="100px" ><strong>Fecha</strong></td>
					<td align="center" width="100px" ><strong>D&iacute;as</strong></td>
					<td align="center" width="100px" ><strong>Estado</strong></td>
					<td width="350px" ><strong>Feriado</strong></td>
					<td colspan="2"><strong></strong></td>
				</tr>';
			while ($row = $sth->fetch()){
				( $bgcolor == '#ffffff' ) ? $bgcolor='#bedcfa' :  $bgcolor='#ffffff';
				echo '<tr bgcolor="'.$bgcolor.'">';
				echo '<td align="center">'.$row['id_feriado'].'</td>';
				$f = explode("-", $row["fecha"]);
				$d1 = $f[0];
				$m1 = $f[1];
				$y1 = $f[2];
				$fecha = $y1."/".$m1."/".$d1;
				echo '<td align="center">'.$fecha.'</td>';
				echo '<td align="center">'.utf8_encode(ucwords(nomDia($row["fecha"]))).' </td>';
				if( $row["fecha"] >= date("Y-m-d") ) {
					echo '<td style="color:red;" align="center"><strong>Pendiente!</strong></td>';
				} else {
					echo '<td style="color:green;" align="center">Cumplido</td>';
				}
				echo '<td align="left">&nbsp;'.strtoupper($row['descripcion']).'</td>';
				echo '<td width="21" align="center" valign="middle">';
				$url = "'./feriado_modificar.php?id=$row[id_feriado]'";
				echo '<a href="javascript:popupSizablePosition('.$url.',550,200,220,60)">'.'<img src="../../images/lapiz.png" title="Ver y Editar" width="16" height="16">';
				echo '</a></td>';
				echo '<td width="21" style="cursor: pointer; _cursor: hand;" align="center" valign="middle">';
				echo '<img src="../../images/elim.png" onclick="JavaScript:verificarEliminar('."'feriado',".$row['id_feriado'].');" title="Eliminar Feriado">';
				echo '</td>';
				echo '</tr>';
			}
			echo "</table>";
			echo '<br><div style="color:blue;">COINCIDENCIAS ENCONTRADAS: '.$total.'</div>';
		} else {
			echo '<br><div style="color:red;">Demasiadas coincidencias. Contin&uacute;e ingresando datos para su b&uacute;squeda...</div>';
		}
		
	?>
	</body>
</html>