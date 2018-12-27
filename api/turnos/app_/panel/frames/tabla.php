<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title></title>
	</head>
	<body>
	<?php
		include "../../../lib/funciones.php";
		$dbh = crear_pdo();
		
		$sql="SELECT * FROM vencimientos WHERE 1=1 " ;
		if ( isset( $_GET['nom'] ) && $_GET['nom'] != null ) {
			$apeNom = $_GET['nom'];
			$sql .=  " AND ApeNom LIKE '%".$apeNom."%'";
		}
		if ( isset( $_GET['dni'] ) && $_GET['dni'] != null ) {
			$dni = $_GET['dni'];
			$sql .=  " AND dni LIKE '%".$dni."%'";
		}
		
		$sth = $dbh->query( $sql );
		$total = $sth->rowCount();
		$bgcolor = '#ffffff';
		if ($total < 3000) { //Pongo como limite 5000 para que no tenga que cargar tantos registros en memoria.
			echo '<br><table class="tabla" cellpadding="0" cellspacing="0">';
			echo '<tr height="30px" bgcolor="#D5D5D5">
					<td align="center" width="50px"><strong>Tipo</strong></td>
					<td width="100px"><strong>DNI</strong></td>
					<td width="300px" ><strong>APELLIDO Y NOMBRE</strong></td>
					<td align="center" style="color:black;" width="130px" ><strong>DELETEADO</strong></td>
					<td align="center" width="80px" ><strong>VENCIMIENTO</strong></td>
					<td width="150px" ><strong>TELEFONO</strong></td>
					<td width="250px" ><strong>E-MAIL</strong></td>
					<td colspan="2" ><strong></strong></td>
				</tr>';
				$msg = "";
			while ($row = $sth->fetch()){
				( $bgcolor == '#ffffff' ) ? $bgcolor='#bedcfa' :  $bgcolor='#ffffff';
				if ( $row['venc_estado'] == 1 ) {
					echo '<tr style="color:black;" bgcolor="pink">';
					$msg = "Eliminado por duplicado.";
				} else echo '<tr bgcolor="'.$bgcolor.'">';
				echo '<td align="center">'.$row['tipo_dni'].'</td>';
				echo '<td align="center">'.$row['dni'].'</td>';
				echo '<td align="left">'.utf8_encode($row['ApeNom']).'</td>';
				echo '<td align="center" align="left">'.$msg.'</td>';
				$f = explode("-", $row["fech_hab"]);
				$d1 = $f[0];
				$m1 = $f[1];
				$y1 = $f[2];
				$fecha = $y1."/".$m1."/".$d1;
				echo '<td align="center">'.$fecha.'</td>';
				echo '<td align="left">'.$row['tel'].'</td>';
				echo '<td align="center">'.$row['email'].'</td>';
				echo '<td width="21" align="center" valign="middle">';
				$url = "'../abm/lista_registros/registro_modificar.php?dni=$row[dni]&tipo=$row[tipo_dni]'";
				echo '<a href="javascript:popupSizablePosition('.$url.',580,300,220,60)">'.'<img src="../images/lapiz.png" title="Ver y Editar" width="16" height="16">';
				echo '</a></td>';
				echo '<td width="21" style="cursor: pointer; _cursor: hand;" align="center" valign="middle">';
				echo '<img src="../images/elim.png" onclick="JavaScript:EliminarPersona('."'".$row['tipo_dni']."',".$row['dni'].');" title="Eliminar Persona">';
				echo '</td></tr>';
				$msg = "";
			}
			echo "</table>";
			echo '<br><div style="color:blue;">COINCIDENCIAS ENCONTRADAS: '.$total.'</div>';
		} else {
			echo '<br><div style="color:red;">Demasiadas coincidencias. Contin&uacute;e ingresando datos para su b&uacute;squeda...</div>';
		}
		
	?>
	</body>
</html>