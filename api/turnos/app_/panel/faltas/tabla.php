<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title></title>
	</head>
	<body>
	<?php
		include "../../../lib/funciones.php";
		$dbh = crear_pdo();
		
		$sql="SELECT * FROM v_causas WHERE 1=1 " ;
		if ( isset( $_GET['nom'] ) && $_GET['nom'] != null ) {
			$apeNom = $_GET['nom'];
			$sql .=  " AND Apellido_Nombre LIKE '%".$apeNom."%'";
		}
		if ( isset( $_GET['dni'] ) && $_GET['dni'] != null ) {
			$dni = $_GET['dni'];
			$sql .=  " AND DNI LIKE '%".$dni."%'";
		}
		$sql .= " AND (Estado_Registro_Vencimiento = 0 OR Estado_Registro_Vencimiento IS NULL) ORDER BY Apellido_Nombre ASC";
		
		$sth = $dbh->query( $sql );
		$total = $sth->rowCount();
		$bgcolor = '#ffffff';
		$totAcum = 0;
		if ($total < 3000) { //Pongo como limite 5000 para que no tenga que cargar tantos registros en memoria.
			echo '<br><table class="tabla" cellpadding="0" cellspacing="0">';
			echo '<tr height="30px" bgcolor="#D5D5D5">
					<td align="center" width="50px"><strong>Tipo</strong></td>
					<td width="80px" align="center"><strong>DNI</strong></td>
					<td width="250px" ><strong>APELLIDO Y NOMBRE</strong></td>
					<td align="center" width="60px" ><strong>Num. Acta</strong></td>
					<td width="80px" align="center"><strong>Num. Causa</strong></td>
					<td width="80px" align="center"><strong>Fecha Acta</strong></td>
					<td width="80px" align="center"><strong>Valor</strong></td>
					<td width="80px" align="center"><strong>Dominio</strong></td>
					<td width="100px" align="center"><strong>Tipo</strong></td>
					<td width="150px" align="center"><strong>Estado</strong></td>
					<td width="30px" align="center"><strong>C&oacute;d.</strong></td>
				</tr>';
			while ($row = $sth->fetch()){
				( $bgcolor == '#ffffff' ) ? $bgcolor='#bedcfa' :  $bgcolor='#ffffff';
				echo '<tr bgcolor="'.$bgcolor.'">';
				echo '<td align="center">'.$row['Tipo'].'</td>';
				echo '<td align="center">'.$row['DNI'].'</td>';
				if ( $row['Apellido_Nombre'] ) {
					$nombre = utf8_encode($row['Apellido_Nombre']);
				} else {
					$nombre = "<strong>SIN DETERMINAR.</strong>";
				}
				echo '<td align="left">'.$nombre.'</td>';
				echo '<td align="center">'.$row['Num_Acta'].'</td>';
				echo '<td align="center">'.$row['Nro_Causa'].'</td>';
				$f = explode("-", $row["Fecha_Acta"]);
				$d1 = $f[0];
				$m1 = $f[1];
				$y1 = $f[2];
				$fecha = $y1."/".$m1."/".$d1;
				echo '<td align="center">'.$fecha.'</td>';
				echo '<td align="right">'.$row['Valor'].'</td>';
				echo '<td align="center">'.$row['Dominio'].'</td>';
				echo '<td align="center">'.$row['Accion'].'</td>';
				echo '<td align="center">'.$row['Desc_Estado'].'</td>';
				echo '<td align="center">'.$row['Cod_Estado'].'</td>';
				echo '</tr>';
				$totAcum += $row['Valor'];
			}
			echo '<tr style="font-size:110%;"><td colspan="6" align="right"><strong>TOTAL DEUDA A REGULARIZAR:</strong></td><td align="right"><strong>'.number_format($totAcum,2).'</strong></td></tr>';
			echo "</table>";
			echo '<br><div style="color:blue;">COINCIDENCIAS ENCONTRADAS: '.$total.'</div>';
		} else {
			echo '<br><div style="color:red;">Demasiadas coincidencias. Contin&uacute;e ingresando datos para su b&uacute;squeda...</div>';
		}
		guardarLog($sql);
	?>
	</body>
</html>