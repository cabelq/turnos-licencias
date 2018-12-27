ALTER VIEW v_turnos AS 
	SELECT 
		t.id_turno AS ID,
		t.dni_vencimiento AS DNI,
		v.ApeNom AS Apellido_Nombre,
		v.tel AS Tel,
		v.fech_hab AS Vencimiento,
		t.hora_puesto AS Turno,
		0 AS Orden,
		t.fecha_turno AS Fecha,
		t.fecha_anulado AS Anulado,
		t.fecha_solicitado AS Solicitado,
		v.venc_estado AS Estado_Registro_Vencimiento,
		v.id_venc AS ID_Vencimiento,
		u.ApeNom AS Usuario,
		t.observaciones AS Motivo
	FROM 
		turnos t inner join  vencimientos v on (t.dni_vencimiento = v.dni)
		--inner join horarios h on (t.hora_puesto = h.hora_puesto)
		left outer join usuarios u on (t.id_usuario_delete = u.id_usuario)