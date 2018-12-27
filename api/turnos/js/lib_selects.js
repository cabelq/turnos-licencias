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
	////////////
// Declaro los selects que componen el documento HTML. Su atributo ID debe figurar aqui.
var listadoSelects=new Array();
listadoSelects[0]="select1";
listadoSelects[1]="select2";
listadoSelects[2]="select3";

function buscarEnArray(array, dato) {
	// Retorna el indice de la posicion donde se encuentra el elemento en el array o null si no se encuentra
	var x=0;
	while(array[x]) {
		if(array[x]==dato) return x;
		x++;
	}
	return null;
}
function cargaContenido(idSelectOrigen) {
	// Obtengo la posicion que ocupa el select que debe ser cargado en el array declarado mas arriba
	var posicionSelectDestino=buscarEnArray(listadoSelects, idSelectOrigen)+1;
	// Obtengo el select que el usuario modifico
	var selectOrigen=document.getElementById(idSelectOrigen);
	// Obtengo la opcion que el usuario selecciono
	var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
	//Obtengo la fecha en formato texto.
	var fecha_text = selectOrigen.options[selectOrigen.selectedIndex].text;
	// Si el usuario eligio la opcion "Elige", no voy al servidor y pongo los selects siguientes en estado "Selecciona opcion..."
	if(opcionSeleccionada==0) {
		var x=posicionSelectDestino, selectActual=null;
		// Busco todos los selects siguientes al que inicio el evento onChange y les cambio el estado y deshabilito
		while(listadoSelects[x]) {
			selectActual=document.getElementById(listadoSelects[x]);
			selectActual.length=0;
			
			var nuevaOpcion=document.createElement("option"); nuevaOpcion.value=0; nuevaOpcion.innerHTML="Seleccione hora...";
			selectActual.appendChild(nuevaOpcion);	selectActual.disabled=true;
			x++;
		}
	}
	// Compruebo que el select modificado no sea el ultimo de la cadena
	else if(idSelectOrigen!=listadoSelects[listadoSelects.length-1]) {
		// Obtengo el elemento del select que debo cargar
		var B = document.getElementById('loading');
		var idSelectDestino=listadoSelects[posicionSelectDestino];
		var selectDestino=document.getElementById(idSelectDestino);
		// Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		obXHR.open("GET", "select_turnos.php?select="+idSelectDestino+"&opcion="+opcionSeleccionada+"&fecha="+fecha_text, true);
		obXHR.onreadystatechange=function() {
			if (obXHR.readyState == 1 ) {
				B.innerHTML = "<img src='http://www.lujan.gov.ar/turnos/img/loading.gif'>";
			} else if (obXHR.readyState == 2 ) {
				B.innerHTML = "<img src='http://www.lujan.gov.ar/turnos/img/loading.gif'>";
			} else if (obXHR.readyState == 4 && obXHR.status == 200) {
				selectDestino.parentNode.innerHTML=obXHR.responseText;
				B.innerHTML = "";
			} else {
				B.innerHTML = "";
			}
		}
		obXHR.send(null);
	}
}