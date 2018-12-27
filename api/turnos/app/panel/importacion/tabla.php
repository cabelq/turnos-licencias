<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title></title>
	</head>
	<body>
	<?php
		include "../../../lib/funciones.php";
		$dbh = crear_pdo();
		
		$sql="SELECT * FROM logs_importacion WHERE 1=1 " ;
		if ( isset( $_GET['anio'] ) && $_GET['anio'] != null ) {
			$anio = $_GET['anio'];
			$sql .=  " AND fecha_operacion LIKE '%".$anio."-%'";
		}
		if ( isset( $_GET['mes'] ) && $_GET['mes'] != null ) {
			$mes = $_GET['mes'];
			$sql .=  " AND fecha_operacion LIKE '%-".$mes."-%'";
		}
		$sql .= " ORDER BY 	id_logs DESC";
		//echo $sql;
		$sth = $dbh->query( $sql );
		$total = $sth->rowCount();
		$bgcolor = '#ffffff';
		if ($total < 3000) { //Pongo como limite 3000 para que no tenga que cargar tantos registros en memoria.
			echo '<br><table class="tabla" cellpadding="0" cellspacing="0">';
			echo '<tr style="border:0px" height="30px" bgcolor="#D5D5D5">
					<td style="border:0px" align="center" width="50px"><strong>ID</strong></td>
					<td style="border:0px" width="110px" align="center"><strong>Fecha de Import.</strong></td>
					<td style="border:0px" width="110px" align="center"><strong>Fecha CSV</strong></td>
					<td style="border:0px" align="center" width="60px" ><strong>Reg. en Tabla</strong></td>
					<td style="border:0px" align="center" width="60px" ><strong>Reg. en CSV</strong></td>
					<td style="border:0px" width="400px" align="center"><strong>Res&uacute;men</strong></td>
					<td style="border:0px" bgcolor="white" width="20px" align="center"><strong></strong></td>
				</tr>';
			while ($row = $sth->fetch()){
				//Doy formato a fecha de operacion...
				$f = explode("-",$row['fecha_operacion']);
				$g = explode(" ",$f[2]);
				$fecha_operacion = $g[0].'/'.$f[1].'/'.$f[0].' '.$g[1];
				$fe_op = $f[0].'-'.$f[1].'-'.$g[0];
				//Doy formato a fecha creacion archivo CSV...
				$f = explode("-",$row['fecha_creacion_csv']);
				$g = explode(" ",$f[2]);
				$fecha_creacion_csv = $g[0].'/'.$f[1].'/'.$f[0].' '.$g[1];
				$fe_cre = $f[0].'-'.$f[1].'-'.$g[0];
				if ( ($row['reg_en_tabla']-$row['reg_en_csv']) >= 2000 || $row['reg_en_csv'] == 0 || $row['reg_en_csv'] == 1 || $row['resumen'] != Null ) {
					$td = '<td bgcolor="white" style="border:0px;" align="center"><img src="../../../img/signo_exclamacion.gif" width="15px" height="15px" title="Alerta!"></td>';
					$background = '#E6E6E6';
				} else {
					$td = '<td style="border:0px" align="center"><img src="../images/menu/ok.png" width="15px" height="15px" title="Normal"></td>';
					$background = 'white';
				}
				echo '<tr bgcolor="'.$background.'" >';
				echo '<td style="border:0px;" align="center">'.$row['id_logs'].'</td>';
				echo '<td style="border:0px" align="center">'.$fecha_operacion.'</td>';
				echo '<td style="border:0px" align="center">'.$fecha_creacion_csv.'</td>';
				echo '<td style="border:0px" align="center">'.$row['reg_en_tabla'].'</td>';
				echo '<td style="border:0px" align="center">'.$row['reg_en_csv'].'</td>';
				if ( $row['resumen'] == Null ) {
					$resumen = 'OK.';
					if ( strtotime($fe_cre) != strtotime($fe_op) ) {
						$resumen .= ' Discrepancia en fechas.';
					}
				} else $resumen = $row['resumen'];
				echo '<td style="border:0px" align="center">'.$resumen.'</td>';
				echo $td;
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