<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title></title>
	</head>
	<body>
	<?php
		//echo $_SESSION["tipo_usuario"];
		include "../../../lib/funciones.php";
		$dbh = crear_pdo();
		$sql="SELECT * FROM turnos WHERE 1=1 AND fecha_anulado IS NULL " ;
		if ( isset( $_GET['dni'] ) && $_GET['dni'] != null ) {
			$dni = $_GET['dni'];
			$sql .=  " AND dni_vencimiento LIKE '%".$dni."%'";
			//$sql .=  " AND dni_vencimiento = ".$dni;
			$_SESSION['hoy'] = 1;
		}
		if ( isset( $_GET['fecha'] ) && $_GET['fecha'] != null ) {
			$fecha = $_GET['fecha'];
			$sql .=  " AND fecha_turno LIKE '%".$fecha."%'";
			$_SESSION['hoy'] = 1;
		}
		if( $_SESSION['hoy'] == 0 || (isset( $_GET['hoy'] ) && $_GET['hoy'] == 0 ) ) {
			$sql .= " AND fecha_turno = '".date('Y-m-d')."'";
		}
		$sql .= " ORDER BY hora_puesto ASC";
		//echo $sql;
		$sth = $dbh->query( $sql );
		$total = $sth->rowCount();
		$bgcolor = '#ffffff';
		$cnt = 1;
		
		//Se ejecuta solo en servidor. Las variables $_SESSION expiran y hay valores que se pierden como por ejemplo $_SESSION["tipo"]...
		if( $_SESSION["tipo_usuario"] != 1 ) {
			echo '<table><tr><td><div style="color:black;text-align:center;padding-left:2px;border:1px solid orange;background:#F3E2A9;width:500px;"><strong>PARA PODER ANULAR UN TURNO DEBE VOLVER A LOGUEARSE EN EL SISTEMA.</strong></td></tr></table>';
		}
		
		if ($total < 1000) { //Pongo como limite 5000 para que no tenga que cargar tantos registros en memoria.
			echo '<br><table class="tabla" cellpadding="0" cellspacing="0">';
			echo '<tr height="30px" bgcolor="#D5D5D5">
					<td align="center" width="30px"><strong>N</strong></td>
					<td align="center" width="80px"><strong>DNI</strong></td>
					<td width="280px"><strong>APELLIDO Y NOMBRE</strong></td>
					<td align="center" style="color:black;" width="130px" ><strong>DELETEADO</strong></td>
					<td align="center" width="70px"><strong>ID</strong></td>
					<td align="center" width="100px" ><strong>FECHA TURNO</strong></td>
					<td width="100px" ><strong>TURNO</strong></td>
					<td align="center" width="50px" ><strong>ORDEN</strong></td>
					<td align="center" width="120px" ><strong>FECHA SOLICITADO</strong></td>
					<td align="center" width="320px" ><strong>MOTIVO</strong></td>
					<td colspan="2"><strong></strong></td>
				</tr>';
				$msg = "";
			while ($row = $sth->fetch()){
				//------HAGO QUERY PARA OBTENER NOMBRE Y APELLIDO
				$query2 = "SELECT * FROM vencimientos WHERE dni = ? AND venc_estado = 0";
				$sth2 = $dbh->prepare( $query2);
				$sth2->execute( array($row['dni_vencimiento']));
				$tipoDNI = "";
				if( $sth2->rowCount() >= 1 ) {
					while ( $row2 = $sth2->fetch() ) {
						$a=$sth2->rowCount();
						$ApeNom = $row2['ApeNom'];
						$tipoDNI = $row2['tipo_dni'];
						if ( $row2['venc_estado'] == 1 ) {
							$bgcolor = 'pink';
							$msg = "Eliminado por duplicado.";
						} else {
							( $bgcolor == '#ffffff' ) ? $bgcolor='#bedcfa' :  $bgcolor='#ffffff';
							$msg = "";
						}
					}
				} else {
					$ApeNom = "No existen datos.";
					$tipoDNI = "-";
					$msg = "";
				}
				//------FIN
				$ApeNom = utf8_encode($ApeNom);
				echo '<tr bgcolor="'.$bgcolor.'">';
				echo '<td align="center">'.$cnt.'</td>';
				echo '<td align="center">'.$row['dni_vencimiento'].'</td>';
				echo '<td>'.$ApeNom.'</td>';
				echo '<td align="center" style="color:black;" align="left">'.$msg.'</td>';
				echo '<td align="center">'.$row['id_turno'].'</td>';
				$f = explode("-", $row["fecha_turno"]);
				$d1 = $f[0];
				$m1 = $f[1];
				$y1 = $f[2];
				$fecha = $y1."/".$m1."/".$d1;
				echo '<td align="center">'.$fecha.'</td>';
				echo '<td align="left">'.$row['hora_puesto'].'</td>';
				//echo($row["fecha_turno"]);
				//echo '<td align="center">'.$row['orden_turno'].'</td>';
				echo '<td align="center">'.$cnt.'</td>';
				echo '<td align="center">'.$row['fecha_solicitado'].'</td>';
				echo '<td align="center">'.utf8_encode($row['observaciones']).'</td>';
				$turno = explode(" - ",$row['hora_puesto']);
				// REIMPRIMIR TURNO
				echo '<td width="21" align="center" valign="middle">';
				$url = "'../../descargar.php?tipo_dni=$tipoDNI&dni=$row[dni_vencimiento]&fecha=$row[fecha_turno]&hora=$turno[0]&turno=$row[orden_turno]&apeNom=$ApeNom&tel=$row2[tel]&tipoTram=1&rutaFondo=../img/decjur5.jpg&msjRutaFalta=../img/msj_deuda.jpg&rutaFormMenor=../img/instructivos/decjur4.jpg&procedencia=noSobretur&descargar=0'";
				echo '<a href="javascript:popupSizablePosition('.$url.',580,300,220,60)">'.'<img src="../images/print.png" title="Reimprimir Turno" width="16" height="16">';
				echo '</a></td>';
				// ELIMINAR TURNO
				if( $_SESSION["tipo_usuario"] == 1 ) {
					echo '<td width="21" style="cursor: pointer; _cursor: hand;" align="center" valign="middle">';
					echo '<img src="../images/elim.png" onclick="JavaScript:verificarEliminar('."'turno', ".$row["id_turno"].');" title="Eliminar turno">';
					echo '</td>';
				} else {
					echo "<td>&nbsp;-&nbsp;</td>";
				}
				echo '</tr>';
				$cnt++;
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