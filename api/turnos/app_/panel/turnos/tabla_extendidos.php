<?php 
	session_start();
	include "../../../lib/funciones.php";
	$dbh = crear_pdo();
		$cnt = 0;
		echo '<div>';
		
		$mes1='0';
		$mes2='0';
		$mes3='0';
		$mes4='0';
		$mes5='0';
		
		$arreglo_fechas = generaFechaTurno ( date ("Y-m-d") );
		foreach ( $arreglo_fechas  as $k => $v ) {
			$f = explode("/", $v);
			$mes = $f[1];
			$fecha = $f[2].'-'.$f[1].'-'.$f[0];
			if( $f[2] == date("Y") ){ //Año actual.
				if ( $mes == date("m") && $f[2] == date("Y") ) {
					echo '<div style="margin-bottom:1px;margin-right:1px;padding-top:-5px;padding-bottom:1px;float:left;width:180px;height:24px;background:#A9D0F5;border:1px solid gray"><table><tr><td><strong>'.utf8_encode(ucwords(nomDia($fecha))).'</strong> - '.$v.'</td>';
					echo '<td><img title="Contar turnos" style="cursor:pointer" id="idImg-'.$cnt.'" onClick="cargarContador(this,'.'\''.$fecha.'\');" vspace="3px" width="15px" height="15px" src="../../../img/contar.png"></td><td><strong><div  title="Cantidad de Turnos otorgados" style="color:white;background:black;width:15px;text-align:center;" id="idDiv-'.$cnt.'"></div></strong></td></tr></table></div>';
					$mes1 = $mes;
				} else if ( $mes == (date("m")+1) ) {
					echo '<div style="margin-bottom:1px;margin-right:1px;padding-top:-5px;padding-bottom:1px;float:left;width:180px;height:24px;background:#E1F5A9;border:1px solid gray"><table><tr><td><strong>'.utf8_encode(ucwords(nomDia($fecha))).'</strong> - '.$v.'</td>';
					echo '<td><img title="Contar turnos" style="cursor:pointer" id="idImg-'.$cnt.'" onClick="cargarContador(this,'.'\''.$fecha.'\');" vspace="3px" width="15px" height="15px" src="../../../img/contar.png"></td><td><strong><div  title="Cantidad de Turnos otorgados" style="color:white;background:black;width:15px;text-align:center;" id="idDiv-'.$cnt.'"></div></strong></td></tr></table></div>';
					$mes2 = $mes;
				} else if ( $mes == (date("m")+2) ) {
					echo '<div style="margin-bottom:1px;margin-right:1px;padding-top:-5px;padding-bottom:1px;float:left;width:180px;height:24px;background:white;border:1px solid gray"><table><tr><td><strong>'.utf8_encode(ucwords(nomDia($fecha))).'</strong> - '.$v.'</td>';
					echo '<td><img title="Contar turnos" style="cursor:pointer" id="idImg-'.$cnt.'" onClick="cargarContador(this,'.'\''.$fecha.'\');" vspace="3px" width="15px" height="15px" src="../../../img/contar.png"></td><td><strong><div  title="Cantidad de Turnos otorgados" style="color:white;background:black;width:15px;text-align:center;" id="idDiv-'.$cnt.'"></div></strong></td></tr></table></div>';
					$mes3 = $mes;
				} else if ( $mes == (date("m")+3) ) {
					echo '<div style="margin-bottom:1px;margin-right:1px;padding-top:-5px;padding-bottom:1px;float:left;width:180px;height:24px;background:#F7D358;border:1px solid gray"><table><tr><td><strong>'.utf8_encode(ucwords(nomDia($fecha))).'</strong> - '.$v.'</td>';
					echo '<td><img title="Contar turnos" style="cursor:pointer" id="idImg-'.$cnt.'" onClick="cargarContador(this,'.'\''.$fecha.'\');" vspace="3px" width="15px" height="15px" src="../../../img/contar.png"></td><td><strong><div  title="Cantidad de Turnos otorgados" style="color:white;background:black;width:15px;text-align:center;" id="idDiv-'.$cnt.'"></div></strong></td></tr></table></div>';
					$mes4 = $mes;
				} else {
					echo '<div style="margin-bottom:1px;margin-right:1px;padding-top:-5px;padding-bottom:1px;float:left;width:180px;height:24px;background:#DF0101;border:1px solid gray"><table><tr><td><strong>'.utf8_encode(ucwords(nomDia($fecha))).'</strong> - '.$v.'</td>';
					echo '<td><img title="Contar turnos" style="cursor:pointer" id="idImg-'.$cnt.'" onClick="cargarContador(this,'.'\''.$fecha.'\');" vspace="3px" width="15px" height="15px" src="../../../img/contar.png"></td><td><strong><div  title="Cantidad de Turnos otorgados" style="color:white;background:black;width:15px;text-align:center;" id="idDiv-'.$cnt.'"></div></strong></td></tr></table></div>';
					$mes5 = $mes;
				}
				$cnt++;
			} else if ( $f[2] == (date("Y")+1) ){ //Un año mas.
				if ( ($mes - 12) == 0 ) {
					echo '<div style="margin-bottom:1px;margin-right:1px;padding-top:-5px;padding-bottom:1px;float:left;width:180px;height:24px;background:#A9D0F5;border:1px solid gray"><table><tr><td><strong>'.utf8_encode(ucwords(nomDia($fecha))).'</strong> - '.$v.'</td>';
					echo '<td><img title="Contar turnos" style="cursor:pointer" id="idImg-'.$cnt.'" onClick="cargarContador(this,'.'\''.$fecha.'\');" vspace="3px" width="15px" height="15px" src="../../../img/contar.png"></td><td><strong><div  title="Cantidad de Turnos otorgados" style="color:white;background:black;width:15px;text-align:center;" id="idDiv-'.$cnt.'"></div></strong></td></tr></table></div>';
					$mes1 = $mes;
				} else if ( ($mes - 12) == -11) {
					echo '<div style="margin-bottom:1px;margin-right:1px;padding-top:-5px;padding-bottom:1px;float:left;width:180px;height:24px;background:#E1F5A9;border:1px solid gray"><table><tr><td><strong>'.utf8_encode(ucwords(nomDia($fecha))).'</strong> - '.$v.'</td>';
					echo '<td><img title="Contar turnos" style="cursor:pointer" id="idImg-'.$cnt.'" onClick="cargarContador(this,'.'\''.$fecha.'\');" vspace="3px" width="15px" height="15px" src="../../../img/contar.png"></td><td><strong><div  title="Cantidad de Turnos otorgados" style="color:white;background:black;width:15px;text-align:center;" id="idDiv-'.$cnt.'"></div></strong></td></tr></table></div>';
					$mes2 = $mes;
				} else if ( ($mes - 12) == -10) {
					echo '<div style="margin-bottom:1px;margin-right:1px;padding-top:-5px;padding-bottom:1px;float:left;width:180px;height:24px;background:white;border:1px solid gray"><table><tr><td><strong>'.utf8_encode(ucwords(nomDia($fecha))).'</strong> - '.$v.'</td>';
					echo '<td><img title="Contar turnos" style="cursor:pointer" id="idImg-'.$cnt.'" onClick="cargarContador(this,'.'\''.$fecha.'\');" vspace="3px" width="15px" height="15px" src="../../../img/contar.png"></td><td><strong><div  title="Cantidad de Turnos otorgados" style="color:white;background:black;width:15px;text-align:center;" id="idDiv-'.$cnt.'"></div></strong></td></tr></table></div>';
					$mes3 = $mes;
				} else if ( ($mes - 12) == -9) {
					echo '<div style="margin-bottom:1px;margin-right:1px;padding-top:-5px;padding-bottom:1px;float:left;width:180px;height:24px;background:#F7D358;border:1px solid gray"><table><tr><td><strong>'.utf8_encode(ucwords(nomDia($fecha))).'</strong> - '.$v.'</td>';
					echo '<td><img title="Contar turnos" style="cursor:pointer" id="idImg-'.$cnt.'" onClick="cargarContador(this,'.'\''.$fecha.'\');" vspace="3px" width="15px" height="15px" src="../../../img/contar.png"></td><td><strong><div  title="Cantidad de Turnos otorgados" style="color:white;background:black;width:15px;text-align:center;" id="idDiv-'.$cnt.'"></div></strong></td></tr></table></div>';
					$mes4 = $mes;
				} else {
					echo '<div style="margin-bottom:1px;margin-right:1px;padding-top:-5px;padding-bottom:1px;float:left;width:180px;height:24px;background:#DF0101;border:1px solid gray"><table><tr><td><strong>'.utf8_encode(ucwords(nomDia($fecha))).'</strong> - '.$v.'</td>';
					echo '<td><img title="Contar turnos" style="cursor:pointer" id="idImg-'.$cnt.'" onClick="cargarContador(this,'.'\''.$fecha.'\');" vspace="3px" width="15px" height="15px" src="../../../img/contar.png"></td><td><strong><div  title="Cantidad de Turnos otorgados" style="color:white;background:black;width:15px;text-align:center;" id="idDiv-'.$cnt.'"></div></strong></td></tr></table></div>';
					$mes5 = $mes;
				}
				$cnt++;
			}
			
		}
		echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			<div style="width:620px;height:100px;font-size:12px;padding:5px 0px 0px 5px"><strong><br>Cuadro de Referencias:</strong>
				<br><br><div style="margin-bottom:1px;margin-right:1px;padding-bottom:1px;float:left;width:120px;height:24px;background:#A9D0F5;border:1px solid gray"><table><tr><td>'.nomMes($mes1).'</td></tr></table></div>
				<div style="margin-bottom:1px;margin-right:1px;padding-top:-5px;padding-bottom:1px;float:left;width:120px;height:24px;background:#E1F5A9;border:1px solid gray"><table><tr><td>'.nomMes($mes2).'</td></tr></table></div>
				<div style="margin-bottom:1px;margin-right:1px;padding-top:-5px;padding-bottom:1px;float:left;width:120px;height:24px;background:white;border:1px solid gray"><table><tr><td>'.nomMes($mes3).'</td></tr></table></div>
				<div style="margin-bottom:1px;margin-right:1px;padding-top:-5px;padding-bottom:1px;float:left;width:120px;height:24px;background:#F7D358;border:1px solid gray"><table><tr><td>'.nomMes($mes4).'</td></tr></table></div>
				<div style="color:white;margin-bottom:1px;margin-right:1px;padding-top:-5px;padding-bottom:1px;float:left;width:120px;height:24px;background:#DF0101;border:1px solid gray"><table><tr><td>'.nomMes($mes5).'</td></tr></table></div>
			</div>';
		echo '</div>';
?>