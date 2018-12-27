<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title></title>
	</head>
	<body>
	<?php
		include "../../../../lib/funciones.php";
		$dbh = crear_pdo();
		
		$sql = "SELECT * FROM usuarios WHERE mostrar = 1 AND tipo <> 1";
		
		$sth = $dbh->query( $sql );
		$total = $sth->rowCount();
		$bgcolor = '#ffffff';
		$cnt = 0;
		if ($total < 1000) {
			echo '<br><table class="tabla" cellpadding="0" cellspacing="0">';
			echo '<tr height="30px" bgcolor="#D5D5D5">
					<td align="center" width="30px"><strong>ID</strong></td>
					<td align="center" width="80px"><strong>Usuario</strong></td>
					<td width="280px"><strong>Apellido y Nombre</strong></td>
					<td align="center" width="45px"><strong>Estado</strong></td>
				</tr>';
			while ($row = $sth->fetch()){
				
				( $bgcolor == '#ffffff' ) ? $bgcolor='#bedcfa' :  $bgcolor='#ffffff';
				echo '<tr bgcolor="'.$bgcolor.'">';
				echo '<td align="center">'.$row['id_usuario'].'</td>';
				echo '<td align="left"><STRONG>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row['usuario'].'</STRONG></td>';
				echo '<td>'.utf8_encode($row['ApeNom']).'</td>';
				if ( $row['estado'] == 1 ) {
					echo '<td align="center"><img title="Modificar Permiso" style="cursor:pointer" id="idImg-'.$cnt.'" onClick="accion(this,1,'.$row['id_usuario'].');" src="../../images/menu/ok.png"></td>';
				} else {
					echo '<td align="center"><img title="Modificar Permiso" style="cursor:pointer" id="idImg-'.$cnt.'" onClick="accion(this,0,'.$row['id_usuario'].');" src="../../images/menu/no.png"></td>';
				}
				echo '</tr>';
				$cnt++;
			}
			echo "</table>";
			echo '<br><div style="color:blue;">COINCIDENCIAS ENCONTRADAS: '.$total.'</div>';
		} else {
			echo '<br><div style="color:red;">Demasiadas coincidencias. Contin&uacute;e ingresando datos para su b&uacute;squeda...</div>';
		}
		
	?>
	</body>
</html>