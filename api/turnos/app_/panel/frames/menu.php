<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<?php
	include "../../../lib/funciones.php";
	if (isset($_SESSION['k_username'])) {		
	} else {
		$mensaje_error = <<<INI
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>Validaci&oacute;n de Usuario: Incorrecta</title>
				<LINK rel="stylesheet" href="../../../css/principal.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../css/estilo_boton.css" type="text/css" media="screen">
				<LINK rel="stylesheet" href="../../../css/table.css" type="text/css" media="screen">
			</head>
			<body style="background-color:#bbb">
				<div id="recuadro">
					<center>
					<br><br>
						<table class="tabla_2" cellpadding="0" cellspacing="0">
						<!--DWLayoutTable-->
							<tr bgcolor="#FFBBBB">
								<td height="100px" width="600" align="center"><strong>¡Nombre de Usuario o Contrase&ntilde;a incorrectos! <br><br>
									<a href="../login/login.php"> - Volver - </a></strong></td>
							</tr>
						</table>
					<br><br>
				</div>
			</body>
		</html>
INI;
		die($mensaje_error);
	}
	
	$menu_usuarios = <<<INI
		<div id="menu_barra_herramientas"  >
			<div id="individual" style="width:95px;font-size:15px;">Administrador: </div>
			<div id="individual"><A href="../abm/usuarios/usuarios_panel.php" target="principal"><input Title="Permisos de Usuarios" type=image src="../images/menu/usuarios.png" width="19px" height="19px"></a></div>
		</div>
INI;

//Se ejecuta solo en servidor. Las variables $_SESSION expiran y hay valores que se pierden como por ejemplo $_SESSION["tipo"]...
$mensaje = <<<INI
		<div id="menu_barra_herramientas">
			<table><tr><td><div style="text-align:center;padding-left:2px;border:1px solid orange;background:#F3E2A9;width:500px;font-size:11px"><strong>PARA ACCEDER AL MEN&Uacute; DE USUARIOS DEBE VOLVER A LOGUEARSE EN EL SISTEMA.</strong></td></tr></table>
		</div>
INI;
?>
	<HEAD>
		<script src="../../../js/lib.js" type="text/javascript"></script>	
		<title>TURNOS LIC. CONDUCIR - Municipalidad de Luj&aacute;n</title>
		<LINK rel="stylesheet" href="../css/menu_barra_herramientas.css" type="text/css" media="screen">
	</HEAD>
	<BODY style="background-color:#EEE;font-family: Arial, sans-serif;">
		<div style="width:auto;" id="contenedor">
		
			<div id="menu_barra_herramientas" >
				<div id="individual"><A href="../index.php" target="_top"><input Title="INICIO" type=image src="../images/menu/inicio.png" width="19px" height="19px"></a></div>
			</div>
			
			<div style="background-color:gray;" id="menu_barra_herramientas">
			</div>
			<div id="menu_barra_herramientas" >
				<div id="individual"><A href="./principal.php" target="principal"><input Title="Personas y Asignaci&oacute;n de Turnos" type=image src="../images/menu/persona.png" width="19px" height="19px"></a></div>
				<div id="individual"><A href="../turnos/turnos_panel.php" target="principal"><input Title="Listar turnos asignados" type=image src="../images/menu/turno.png" width="19px" height="19px"></a></div>
				<div id="individual"><A href="../turnos/turnos_extendidos.php" target="principal"><input Title="Ver Turnos extendidos" type=image src="../images/menu/extendido.png" width="19px" height="19px"></a></div>
				<div id="individual"><A href="../faltas/faltas_panel.php" target="principal"><input Title="Faltas" type=image src="../images/menu/falta.png" width="19px" height="19px"></a></div>
				<div id="individual"><A href="../abm/feriados/feriados_panel.php" target="principal"><input Title="Feriados" type=image src="../images/menu/feriado.png" width="19px" height="19px"></a></div>
				<div id="individual"><A href="../importacion/importacion_panel.php" target="principal"><input Title="Registros de Importaci&oacute;n de faltas" type=image src="../images/menu/import.png" width="19px" height="19px"></a></div>
			</div>
			<div id="menu_barra_herramientas" >
				<div id="individual"><A href="../horarios/tabla.php" target="principal"><input Title="Lista de Horarios" type=image src="../images/menu/reloj.png" width="19px" height="19px"></a></div>
				<div id="individual"><A href="../abm/historico/historico_panel.php" target="principal"><input Title="Hist&oacute;rico de Turnos" type=image src="../images/menu/historial.png" width="19px" height="19px"></a></div>
			</div>
			<!-------------------NOMBRE DE USUARIO------------------->
			<div id="menu_barra_herramientas1" style="font-size:13px;background:white;">		
				<strong>Usuario: <?php echo utf8_encode($_SESSION["usuario"]); ?></strong>
			</div>
			<!-------------------FIN------------------->
<?php
	if ( $_SESSION["tipo_usuario"] == 1 ) {
		echo $menu_usuarios;
	} else {
		echo $mensaje;
	}
?>
			<div id="menu_barra_herramientas" style="float:right;">
				<div id="individual">
					<A href="../login/logout.php" target="_top"><input Title="Salir" type=image src="../images/menu/salir.png" width="19px" height="19px"></a>
				</div>
			</div>
		</div>
	</BODY>
</HTML>