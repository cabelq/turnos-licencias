<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	include "../../../lib/funciones.php";
	
	$dbh = crear_pdo();
	$sql="SELECT count(*) AS cantidad FROM causas " ;
	$sth = $dbh->query( $sql );
	$row = $sth->fetch();
	$cantidad = $row['cantidad'];
	
	if (isset($_SESSION['k_username'])) {
		$msj_alerta = <<<INI
		<table><tr><td style="background:#DF0101;"><span style="color:white;font-size:11px;"><strong>Cantidad de Registros en tabla [Faltas]: $cantidad</strong> - COMUNICARSE CON SISTEMAS!!!</span></td>
		<td><img src="../../../img/signo_exclamacion.gif" width="15px" height="15px" title="Eliminar Feriado"></td></tr></table>
INI;
		$msj_normal = <<<INI
		<span style="background:gray;color:white;font-size:11px;"><strong>Cantidad de Registros en tabla [Faltas]: $cantidad</strong> - NORMAL</span>
INI;

	} else {	
		$mensaje_error = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>Validaci&oacute;n de Usuario: Incorrecta</title>
				<LINK rel="stylesheet" href="../../../../css/principal.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../../css/estilo_boton.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../../css/table.css" type="text/css" media="screen">
			</head>
			<body style="background-color:#bbb">
				<div id="recuadro">
					<center>
					<br><br>
						<table class="tabla_2" cellpadding="0" cellspacing="0">
						<!--DWLayoutTable-->
							<tr bgcolor="#FFBBBB">
								<td height="100px" width="600" align="center"><strong>¡Nombre de Usuario o Contrase&ntilde;a incorrectos! <br><br>
									<a href="../../login/login.php"> - Volver - </a></strong></td>
							</tr>
						</table>
					<br><br>
				</div>
			</body>
		</html>
INI;
		die($mensaje_error);
	}
?>
	<head>
		<title>TURNOS LIC. CONDUCIR - Municipalidad de Luj&aacute;n</title>
		<LINK rel="stylesheet" href="../../../css/principal.css" type="text/css" media="screen">
		<LINK rel="stylesheet" href="../../../css/estilo_boton.css" type="text/css" media="screen">
		<LINK rel="stylesheet" href="../../../css/table.css" type="text/css" media="screen">
		<script src="../js/lib.js" type="text/javascript"></script>
		<script src="../js/jquery.js" type="text/javascript"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script language="JavaScript" type="text/javascript">
		// creando objeto XMLHttpRequest de Ajax
		
		$(document).ready(function(){
			cargar();
		});
		
		var obXHR;
		try {
			obXHR=new XMLHttpRequest();
		} catch(err) {
			try {
				obXHR=new ActiveXObject("Msxml2.XMLHTTP");
			} catch(err) {
				try {
					obXHR=new ActiveXObject("Microsoft.XMLHTTP");
				} catch(err) {
					obXHR=false;
				}
			}
		}
		
		function Check() {
			if ( $("#anio").attr("value") != '' && $("#mes").attr("value") != '' ) {
				cargar();
			} else {
				alert("Debe ingresar datos para la busqueda...");
			}
		}
		
		function cargar() {
			var B = document.getElementById('loading');
			var obDiv = document.getElementById("idDiv");
			obXHR.open("GET", "tabla.php?anio="+$("#anio").attr("value")+'&mes='+$("#mes").attr("value"));
			obXHR.onreadystatechange = function() {
				if ( obXHR.readyState == 1 ) {
					B.innerHTML = "<img src='../../../img/loading.gif'>";
				} else if ( obXHR.readyState == 4 && obXHR.status == 200 ) {
					obDiv.innerHTML = obXHR.responseText;
				} else {
					obDiv.innerHTML = obXHR.responseText;
					B.innerHTML = "";
				}
			}
			obXHR.send(null);
		}
		</script>
	</head>

<body bgcolor="gray">
	<div id="recuadro">
		<div style="margin-left:10px;">
			<center>
				<br>
				<span style="color:black;font-size:12px;"><strong>VISOR DE LOGS Y ESTADO DE IMPORTACI&Oacute;N DE FALTAS:</strong></span>
				<br>
				<?php if ( $cantidad == 0 ) echo $msj_alerta;
						else echo $msj_normal;
				?>
				<table><tr>
					<div style="width:100px;">
						<td>Ingrese el a&ntilde;o (aaaa): <input style="text-align:center;width:80px;" id="anio" name="anio" value="<?php echo date("Y");?>" type="text"></td>
						<td>Ingrese el mes (mm): <input style="text-align:center;width:60px;" id="mes" name="mes" value="<?php echo date("m");?>" type="text"></td>
						<td width="20px"><span id="loading"></span></td>
						<td>
							<div style="padding-left:18px;padding-top:3px;margin-top:-4px;width:150px;background:#D5D5D5;border:1px solid black;height:30px;">
								<Button style="height:26px;width:62px;background:#EEE;" class="boton" onClick="Check();" name="nuevo">Buscar</button>
								<Button style="height:26px;width:62px;background:#EEE;" class="boton" onClick="history.go(0)" name="nuevo">Resetear</button>
							</div>
						</td>
						<br>
					</div>
				</tr></table>
				<div id="idDiv"></div>
			</center>
		</div>
		<br>
	</div>
</body>
<?php $dbh = Null; ?>
</html>