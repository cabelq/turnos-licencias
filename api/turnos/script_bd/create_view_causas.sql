CREATE OR REPLACE VIEW v_causas AS 
	SELECT 
		causas.Tipo_Doc AS Tipo,
		causas.Nro_Doc AS DNI,
		vencimientos.ApeNom AS Apellido_Nombre,
		concat(causas.ID_Tipo_Acta , '-' , causas.Nro_Acta) As Num_Acta,
		CONCAT(causas.Causa_Nro , '/', causas.Causa_Anio) AS Nro_Causa,
		causas.Fecha_Acta AS Fecha_Acta,
		((causas.Total_UND_Fijas * causas.Valor_UF) + (causas.Total_Concepto)) AS Valor,
		causas.Patente AS Dominio,
		causas.Accion AS Accion,
		causas.Descripcion_Estado AS Desc_Estado,
		vencimientos.venc_estado AS Estado_Registro_Vencimiento,
		vencimientos.id_venc AS ID_Vencimiento,
		causas.Codigo_Estado AS Cod_Estado
	
FROM   causas
       LEFT OUTER JOIN vencimientos ON causas.Nro_Doc = vencimientos.dni
