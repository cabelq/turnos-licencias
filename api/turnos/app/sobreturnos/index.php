<?php
	$cryptinstall="../../lib/crypt/cryptographp.fct.php";
	include $cryptinstall;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
		<meta name="robots" content="index, follow">
		<meta name="keywords" content="Municipalidad de Luján Intendente Oscar Luciani sitio oficial de lujan.">
		<meta name="description" content="Portal Oficial del Municipio de LUJÁN.">
		<script src="../../js/lib.js?1.1.0" type="text/javascript"></script>
		<script src="../../js/jquery-1.9.1.js" type="text/javascript"></script>
		<script src="../../js/jquery.maskedinput.js" type="text/javascript"></script>
		<script type="text/javascript">
        jQuery(function($){
            // Definir las mascaras para cada input
            $("#vencimiento").mask("99/99/9999");
        });
		
		$(document).ready(function() {
			$("#cVenc").click();
		});
		
		function valDNI(){
			var status = false
			var dni = document.validar_dni.dni.value;
			var venc = document.validar_dni.vencimiento.value;
			var code = document.validar_dni.code.value;
			
			if($("#vencimiento").is(":visible")) {
				if ( dni != '' && code != '' && venc != '' ) {
					document.validar_dni.submit();
				} else {
					alert ("Debe completar el ambos campos.");
				}
			} else {
				if ( dni != '' && code != '' ) {
					document.validar_dni.submit();
				} else {
					alert ("Debe completar el ambos campos.");
				}
			}
		}
		
		function valida() {
			$("#vencimiento").show();
			$("#msgVenc").show();
		}
		
		function valida2() {
			$("#vencimiento").hide();
			$("#msgVenc").hide();
		}
    </script>
	</head>
	<title>Municipalidad de Luján</title>
	<LINK rel="stylesheet" href="../../css/estilo_login.css" type="text/css" media="screen">
	<body>
		<div class="Main">
		<center><div id="TitGrande2"><b>Solicitud de Turno</b></div></center><br>
			<form name="validar_dni" action="./validar_dni.php" method="post">
				<center>
					<div id="cons">
					<div  id="contenedor2" style="height:auto;">
						<table style="margin-bottom:10px;background:#666666;color:white;">
							<tr>
								<td><input id="cVenc" type="radio" style="width:50px;border:none;background:white;" value="1" name="operacion" onClick="valida()"></td><td width="200px">Renovaci&oacute;n de Registro emitido en Luj&aacute;n.</td>
								<!--<td style="width:40px;"></td>-->
								<td><input id="sVenc" type="radio" style="width:50px;border:none;background:white;" value="2" name="operacion" onClick="valida2()"></td><td width="200px">1° Vez. / Otra Localidad. / Ampliaci&oacute;n. / Robo o Extrav&iacute;o.</td>
							</tr>
						</table><br>
						<IMG style="float:left;width:230px;height:110px;margin-top:00px" SRC="../../img/logo_muni.png">
						<table>
							<tr>
								<td align="center"><strong>Tipo</strong></td>
								<td align="center"><strong>Escriba su DNI</strong></td>
							</tr>
							<tr>
								<td align="center">
									<div id="combo2">
										<select name="tipo" id="tipo">
											<option value="DNI">DNI</option>
											<option value="LC">LC</option>
											<option value="LE">LE</option>
											<option value="SD">SD</option>
											<option value="CIP">CIP</option>
											<option value="CI">CI</option>
											<option value="CIF">CIF</option>
										</select>
									</div>
								</td>
								<td><input style="text-align:center;width:125px;" maxlength="8" name="dni" value="" type="text" onkeypress="return permite(event, 'num_esp')"><br></td>
							</tr>
							<tr>
								<td align="center" colspan="2" style="height:60px;"><br><strong><div id="msgVenc">Vencimiento del Registro</div></strong>
								<input style="text-align:center;font-weight:bold" name="vencimiento" id="vencimiento" value="" type="text"><br></td>
							</tr>
						</table>
						<div id="captcha">
						<table>
							<tr>
								<td align="center" colspan="2" style="margin-bottom:10px;border-top: 1px solid gray;border-left: 1px solid gray;border-right: 1px solid gray;">
									Ingrese el c&oacute;digo que ve en la im&aacute;gen
								</td>
							</tr>
							<tr>
								&nbsp;&nbsp;<td align="center"style="border-left: 1px solid gray;border-bottom: 1px solid gray;">
	<?php
		dsp_crypt(0,1);
	?>
								</td>
								<td align="center" height="50px" style="border-bottom: 1px solid gray;border-right: 1px solid gray;">
									&nbsp;&nbsp;<input style="text-transform:uppercase;width:125px;text-align:center;" maxlength="4" class="captcha" type="text" name="code" />&nbsp;
								</td>
							</tr>
						</div><br>
					</table><br>						
					<div style="float:right;margin-top:5px;"><input type="button" id="button2" value="Consultar" style="text-transform:none;height: inherit;width:110px; background:#4fa338" onClick="valDNI()" name="consultar"/></div>
					<table><tr><td><img src="../../img/alert.png"></td><td>La falsedad de los datos consignados impedir&aacute; la obtenci&oacute;n del beneficio.</td></tr></table>
					<br>
					<table style="color:black;font-weight:bold;"><tr><td colspan="2" align="center"><font color="#f02f2f">IMPORTANTE:</font> Usted puede reservar su turno hasta con 12 meses de anticipaci&oacute;n al vencimiento. Solo debe tener en cuenta que la fecha del mismo no puede ser anterior a los 30 d&iacute;as del vencimiento de su licencia de conducir.
					<td><tr></table>
					</div>
					</div>
				</center>
			</form>
		</div>
	</body>
</html>
