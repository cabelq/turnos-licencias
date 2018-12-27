function GuardarNuevaPersona() {
	var f = document.otorgamiento_extravio;
	var apeNom = f.apeNom;
	var tipo = f.tipo
	var dni = f.dni;
	var tel = f.tel;
	var email = f.email;
	var grupo_radio = f.motivo;
	var valorSeleccionado = "";
	if (apeNom.value && tipo.value && dni.value && tel.value) {
		f.submit();
	} else {
		alert ("Debe completar los campos obligatorios...");
	}
}

function popupBusq(dni,apeNom,fVenc) {
	var dia = 'a';
	var a = '?doc='+dni+'&apeNom='+apeNom+'&venc='+fVenc+'&dia='+dia;
	document.forms.buscar.reset();
	var url = './panel2.php'+a;
	document.location.href=url;
	//open(url,'','top=60,left=60,width=1100,height=800, scrollbars=YES');
}

function popupBusq2(dni,apeNom) {
	var a = '?doc='+dni+'&apeNom='+apeNom;
	document.forms.buscar.reset();
	var url = '../panel/faltas/panel2.php'+a;
	document.location.href=url;
	//open(url,'','top=60,left=60,width=1100,height=800, scrollbars=YES');
}

function validarDni() {
	var f = document.validar_dni;
	var dni = f.dni;
	var captcha = f.code;
	if ( dni.value != '' && captcha.value != '' ) {
		f.submit();
	} else {
		alert ("Debe completar el ambos campos.");
	}
}

function login() {
	var f = document.form_login;
	var usu = f.usuario;
	var pass = f.pass;
	if ( usu.value && pass.value ) {
		f.submit();
	} else {
		alert('Debe completar el formulario');
	}
}

function confirmarTurnoOtorExtrav() {
	var i = document.insertar_turno_otorYextravio;
	var motivo = i.motivo;
	var apeNom = i.apeNom;
	var tipo = i.tipo;
	var dni = i.dni;
	var tel = i.tel;
	var fecha = i.select1;
	var fecha1 = fecha.value.split(',');
	var hora = i.select2;
	var hora1 = hora.value.split(',');
	if ( fecha1[1] && hora1[1] ) {
		i.submit();
	} else {
		alert('Debe seleccionar una fecha y hora para la reserva del turno...');
	}
}

function confirmarTurno() {
	var i = document.insertar;
	var dni = i.dni;
	var tel = i.tel;
	var email = i.email;
	var fecha = i.select1;
	var fecha1 = fecha.value.split(',');
	var hora = i.select2;
	var hora1 = hora.value.split(',');
	if ( fecha1[1] && hora1[1] ) {
		if ( tel.value != '' ) {
			if ( email.value == '' ) {
				i.submit();
			}
			else if ( ValidarCorreo(email.value) ) {
				i.submit();
			} else {
				alert('Correo electronico invalido...');
			}
		} else {
			alert('Por favor, complete el formulario con su Telefono...');
		}
	} else {
		alert('Debe seleccionar una fecha y hora para la reserva del turno...');
	}
}

function ValidarCorreo( email ){
    var Formato = /^([\w-\.])+@([\w-]+\.)+([a-z]){2,4}$/;
	var Comparacion = Formato.test(email);
     if(Comparacion == false){
          return false;
     } else return true;
}

function permite(elEvento, permitidos) {
  // Variables que definen los caracteres permitidos
  var numeros = "0123456789";
  var teclas_especiales = [8, 9, 37, 39, 46]; // 8 = BackSpace, 9 = tab, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha
  // Obtener la tecla pulsada
  permitidos = numeros;
  var evento = elEvento || window.event;
  var codigoCaracter = evento.charCode || evento.keyCode;
  var caracter = String.fromCharCode(codigoCaracter);
  // Comprobar si la tecla pulsada es alguna de las teclas especiales
  // (teclas de borrado y flechas horizontales)
  var tecla_especial = false;
  for(var i in teclas_especiales) {
    if(codigoCaracter == teclas_especiales[i]) {
      tecla_especial = true;
      break;
    }
  }
  // Comprobar si la tecla pulsada se encuentra en los caracteres permitidos
  // o si es una tecla especial
  return permitidos.indexOf(caracter) != -1 || tecla_especial;
}


