function verificarEliminar ( tipo, id ) {
	if(tipo == 'feriado'){
		if( confirm("¿Está seguro que desea eliminar el "+tipo+"?") )
			location.href = "./eliminar_feriado.php?id="+id;
	}
	else if(tipo == 'turno'){
		if( confirm("¿Está seguro que desea eliminar el "+tipo+"?") ) 
			location.href = "./eliminar_turno.php?id="+id;
	}
}

function EliminarPersona(tipo,dni) {
	if( confirm("¿Confirma eliminar el Registro?") ) {
		location.href ="../abm/lista_registros/eliminar_registro.php?tipo="+tipo+"&dni="+dni;
	}
}

function verificarEliminar2 ( tipo, procedencia, id ) {
	if(tipo == 'turno' && procedencia == 'filtro'){
		if( confirm("¿Está seguro que desea eliminar el "+tipo+"?") )
			$("#cuerpo2").load("./turnos/eliminar_turno.php", {id: id});
	}
}

function verificarEliminar3 ( tipo, id ) {
	if(tipo == 'licencia'){
		if( confirm("¿Está seguro que desea eliminar el "+tipo+"?") )
			$("#cuerpo2").load("./panel2_eliminar_registro.php", {id: id});
	}
}

function popupFiltro(dia) {
	var doc = 1; var apeNom = 'a'; var venc = 'b';
	var a = '?dia='+dia+'&doc='+doc+'&apeNom='+apeNom+'&venc='+venc;
	document.forms.filtrar.reset();
	var url = '../panel/panel2.php'+a;
	open(url,'','top=10,left=20,width=1000,height=800, scrollbars=YES');
}

function popupFiltro2(dia) {
	var doc = 1; var apeNom = 'a'; var venc = 'b';
	var a = '?dia='+dia+'&doc='+doc+'&apeNom='+apeNom+'&venc='+venc;
	document.forms.filtrar2.reset();
	var url = '../panel/turnos/lista_asignados.php'+a;
	open(url,'','top=10,left=20,width=1000,height=800, scrollbars=YES');
}

function popupSizablePosition(url,ancho,alto,x,y) {
	open(url,'','top='+y+',left='+x+',width='+ancho+',height='+alto+',scrollbars=YES');
}

function popupSizablePosition2(url,valor,ancho,alto,x,y) {
	open(url+'?dia='+valor,'','top='+y+',left='+x+',width='+ancho+',height='+alto+',scrollbars=YES');
}

function popupLicencia ( url ) {
	open(url,'','top=60,left=220,width=580,height=300, scrollbars=YES');
}

function popupLicencia2 ( url ) {
	open(url,'','top=20,left=220,width=630,height=650, scrollbars=YES');
}

function popupFeriados ( url ) {
	open(url,'','top=60,left=220,width=630,height=260, scrollbars=YES');
}

function popupTurnos ( url ) {
	open(url,'','top=10,left=20,width=1000,height=800, scrollbars=YES');
}

function popupTurno ( url ) {
	open(url,'','top=20,left=220,width=380,height=170, scrollbars=YES');
}

function grabNvoReg () {
	var f = document.nuevo_registro;
	var dni = f.dni;
	var ApeNom = f.ApeNom;
	var venc = f.vencimiento;
	var email = f.email;
	if ( dni.value && ApeNom.value && venc.value && email.value ) {
		f.submit();
	} else {
		alert ('Error: Debe completar todos los datos!');
	}
}

function grabNvoFer () {
	var f = document.nuevo_feriado;
	var feriado = f.desc;
	var fecha = f.fecha;
	if ( fecha.value && feriado.value ) {
		f.submit();
	} else {
		alert ('Error: Debe completar todos los datos!');
	}
}

function grabModReg () {
	var f = document.modificar_registro;
	var dni = f.dni;
	var ApeNom = f.ApeNom;
	var venc = f.vencimiento;
	//alert(dni.value +'-'+ ApeNom.value +'-'+ venc.value);
	if ( dni.value && ApeNom.value && venc.value ) {
		f.submit();
	} else {
		alert ('Error: Debe completar todos los datos!');
	}
}

function grabModFer () {
	var f = document.modificar_feriado;
	var feriado = f.desc;
	var fecha = f.fecha;
	if ( fecha.value && feriado.value ) {
		f.submit();
	} else {
		alert ('Error: Debe completar todos los datos!');
	}
}
