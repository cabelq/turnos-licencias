ALTER table horarios ADD publico int NOT NULL

UPDATE `horarios` SET `publico`= 1 WHERE id <= 68

--select count(*) AS publicos from horarios where publico = 1
--select count(*) AS sobreturnos from horarios where publico = 0