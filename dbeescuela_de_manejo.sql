-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-04-2021 a las 21:34:47
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbeescuela_de_manejo`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_answer` (IN `_id_pregunta` INT(11), IN `_respuesta` VARCHAR(500))  BEGIN
	DECLARE _correcta VARCHAR(500);
    IF (SELECT r.Correcta FROM examen_respuestas r WHERE r.IdPregunta = _id_pregunta LIMIT 1) IS NULL OR
	   (SELECT r.Correcta FROM examen_respuestas r WHERE r.IdPregunta = _id_pregunta LIMIT 1)  = ''
    THEN
		SET _correcta = (SELECT r.Correcta FROM examen_respuestas r WHERE r.IdPregunta = _id_pregunta LIMIT 1);
    ELSE 
		SET _correcta  = NULL;
    END IF;
	INSERT INTO examen_respuestas (IdPregunta, Respuesta, Correcta)
    VALUES (_id_pregunta, _respuesta, _correcta);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_question` (IN `_id_examen` INT(11), IN `_pregunta` VARCHAR(200))  BEGIN
	INSERT INTO examen_preguntas (IdExamen, Preguntas, TipoExamen, Puntaje)
    VALUES (_id_examen, _pregunta, (
		SELECT e.TipoExamen FROM examen e WHERE e.IdExamen = _id_examen
    ), 5);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_answer` (IN `_id_respuesta` INT(11))  BEGIN
	DELETE FROM examen_respuestas WHERE IdRespuestas = _id_respuesta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_question` (IN `id_pregunta` INT(11))  BEGIN
	DELETE FROM examen_respuestas WHERE IdPregunta = id_pregunta;
	DELETE FROM examen_preguntas WHERE IdPregunta = id_pregunta;    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_course_levels` ()  BEGIN
	SELECT IdNivel, CONCAT_WS(' / ', Nivel, HorasPracticas) AS NivelCurso FROM nivel_curso;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_Info_Resultado_Examen` (IN `_IdEstudiante` INT(11))  BEGIN

SELECT ee.Fecha,ex.TipoExamen, e.Foto,ee.Nota,ex.TipoExamen,e.Nombre, e.Apellido,
			(CASE  WHEN ee.Nota >= 80 THEN 'Aprobado'
               WHEN ee.Nota <= 79 THEN 'Reprobado'
         END) AS Resultado from examen_estudiante ee INNER JOIN estudiante e  on e.IdEstudiante = ee.IdEstudiante 
INNER JOIN examen ex on ex.IdExamen = ee.IdExamen WHERE ee.IdEstudiante = _IdEstudiante;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_info_student_by_id` (IN `_id` INT(11))  BEGIN
	DECLARE _estado, _verificacion TINYINT(1);
    
    SET _estado = (SELECT Estado FROM estudiante WHERE IdEstudiante = _id);
    SET _verificacion = (SELECT ControldePago FROM estudiante WHERE IdEstudiante = _id);
    
	CASE _estado = TRUE AND _verificacion = TRUE
      WHEN TRUE THEN 
			SELECT 
				e.Foto, e.Nombre, e.Apellido, 
				e.FechaNacimiento, e.Sexo, e.Cedula, 
				e.Pasaporte, e.email AS Email, e.Telefono,e.MetodoPago, 
				e.Direccion, e.`Password`, e.FotoCedulaDelante,e.FotoCedulaDetras,e.FotoBaucher,e.Seminario,e.ComprobanteET,e.ComprobanteEP,
                (CASE  WHEN e.ControldePago = 1 THEN 'Habilitado'
						WHEN e.ControldePago = 0 THEN 'Deshabilitado'
				END) AS Verificacion,
				(CASE  WHEN e.Estado = 1 THEN 'Habilitado'
						WHEN e.Estado = 0 THEN 'Deshabilitado'
				END) AS Estado,
				(CASE  WHEN i.Principiante = 'Si' THEN TRUE
						WHEN i.Principiante = 'No' THEN FALSE
				END) AS Principiante,
				(CASE  WHEN i.LicenciadeConducir = 'Si' THEN TRUE
						WHEN i.LicenciadeConducir = 'No' THEN FALSE
				END) AS LicenciadeConducir,
				i.Categoria,
				t.Tipo AS Turno,
				t.Codigo AS CodigoTurno,
				t.Descripcion AS Modalidad, 
				CONCAT_WS (' / ', n.Nivel, n.HorasPracticas) AS NivelCurso,
				DATE_FORMAT(e.ExamenTeorico, '%Y-%m-%d') AS FechaExamen,
                DATE_FORMAT(e.ExamenPractico, '%Y-%m-%d') AS FechaPractica,
                DATE_FORMAT(e.ExamenTeoricoTransito, '%Y-%m-%d') AS FechaETeoricoTransito,
                DATE_FORMAT(e.ExamenPracticoTransito, '%Y-%m-%d') AS FechaEPracticaTransito
			FROM estudiante e
			INNER JOIN inscripcion i
			ON e.IdEstudiante = i.IdEstudiante
			INNER JOIN turno t
			ON i.IdTurno = t.IdTurno
			INNER JOIN nivel_curso n
			ON i.IdNivel = n.IdNivel
			WHERE e.IdEstudiante = _id;
      WHEN FALSE THEN 
			SELECT 
				e.Foto, e.Nombre, e.Apellido, 
				e.FechaNacimiento, e.Sexo, e.Cedula, 
				e.Pasaporte, e.email AS Email, e.Telefono,e.MetodoPago, 
				e.Direccion, e.`Password`,e.FotoCedulaDelante,e.FotoCedulaDetras,e.FotoBaucher,
                (CASE  WHEN e.ControldePago = 1 THEN 'Habilitado'
						WHEN e.ControldePago = 0 THEN 'Deshabilitado'
				END) AS Verificacion,
				(CASE  WHEN e.Estado = 1 THEN 'Habilitado'
						WHEN e.Estado = 0 THEN 'Deshabilitado'
				END) AS Estado
			FROM estudiante e			
			WHERE e.IdEstudiante = _id;
      ELSE
        BEGIN
        END;
    END CASE;         
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_more_info_student_by_Id` (IN `_id` INT(11))  BEGIN
	SELECT i.IdInscripcion,i.NombreCE,i.ApellidoCE,i.TelefonoCE,i.EmailCE,i.DireccionCE,
	i.LugardeTrabajo as Lugar_de_trabajo, i.DireccionLT, i.TelefonoLT,i.EmailLT,i.Observaciones
	FROM inscripcion i INNER JOIN estudiante e
	ON e.IdEstudiante = i.IdEstudiante WHERE e.IdEstudiante = _id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_next_schedule` (IN `_offset` INT, IN `_id` INT(11))  BEGIN
	SELECT h.FechaCreacion,h.FechaInicio,h.FechaFin, h.HoraInicio,h.HoraFin 
    FROM horario h INNER JOIN estudiante e 
    ON e.IdEstudiante = h.IdEstudiante 
    WHERE e.IdEstudiante=_id LIMIT _offset,6
	;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_next_students` (IN `_offset` INT)  BEGIN
        SET @count := _offset;
		SELECT (@count := @count + 1) AS Count, CONCAT_WS(" ", e.Nombre, e.Apellido) AS NombreCompleto, e.Cedula AS Cedula, e.Telefono AS Telefono, 
        (CASE  WHEN e.Estado = 1 THEN 'Habilitado'
               WHEN e.Estado = 0 THEN 'Deshabilitado'
         END) AS Estado,
         e.Estado AS EstadoBoolean, 
		(CASE WHEN (SELECT sum(h.IdHorario) FROM horario h WHERE h.IdEstudiante = e.IdEstudiante) IS NULL THEN CONCAT("<a href='/admin/vistas/gestion-horario.php?data=", e.IdEstudiante, "'>Asignar Horario</a>")
			   WHEN (SELECT sum(h.IdHorario) FROM horario h WHERE h.IdEstudiante = e.IdEstudiante) IS NOT NULL THEN 'Asignado'
		 END) AS Practica,
		(CASE WHEN e.ControldePago = 0 THEN CONCAT("<a href='/admin/vistas/verificacion.php?data=", e.IdEstudiante, "'>Verificar</a>")
			  WHEN e.ControldePago = 1 THEN 'Verificado'
		 END) AS Inscripcion,
		CONCAT("<a class='btn btn-primary btn-sm' href='/admin/vistas/info-estudiante.php?info=", e.IdEstudiante, "'>Ver Información</a>") AS Informacion
		FROM estudiante e
		LIMIT _offset, 15;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_next_student_exams` (IN `_offset` INT, IN `_id` INT(11))  BEGIN

SET @count := @_offset; 
	SELECT (@count := @count + 1) AS Count, ex.TipoExamen, es.Fecha FROM  examen_estudiante es 
	INNER JOIN estudiante e ON e.IdEstudiante = es.IdEstudiante INNER JOIN examen ex 
	ON ex.IdExamen = es.IdExamen WHERE e.IdEstudiante=_id  LIMIT  _offset,6;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_question_answers` (IN `_id_pregunta` INT(11))  BEGIN
	SELECT r.IdRespuestas, r.Respuesta, 
    (CASE  WHEN r.Correcta = r.Respuesta THEN 1 
		   WHEN r.Correcta <> r.Respuesta THEN 0 
	END) AS Correcta
    FROM examen_preguntas p
	INNER JOIN examen_respuestas r
	ON r.IdPregunta = p.IdPregunta
	WHERE p.IdPregunta = _id_pregunta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_test_questions` (IN `_id_examen` INT(11))  BEGIN
	SELECT p.IdPregunta, p.Preguntas FROM examen e
	INNER JOIN examen_preguntas p
	ON e.IdExamen = p.IdExamen
	WHERE e.IdExamen = _id_examen;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_week_modalities` (IN `_turn` VARCHAR(80))  BEGIN
	SELECT IdTurno,Codigo AS CodigoTurno, Descripcion FROM turno WHERE Tipo = _turn;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `is_modality_available` (IN `_modality` VARCHAR(15))  BEGIN
	DECLARE _cantidad_disponible INT(11);
    SET _cantidad_disponible = (SELECT Disponibilidad FROM turno WHERE Codigo = _modality);
                               
	SELECT (CASE WHEN _cantidad_disponible > 0 AND _cantidad_disponible <= 2  THEN 'true'
				 WHEN _cantidad_disponible <= 0 THEN 'false'
			END) AS Disponibilidad;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `search_student_by_text` (IN `_text` VARCHAR(300))  BEGIN
		SET @count := 0;
		SELECT (@count := @count + 1) AS Count, CONCAT_WS(" ", e.Nombre, e.Apellido) as NombreCompleto, e.Cedula, e.Telefono, 
        (CASE  WHEN e.Estado = 1 THEN 'Habilitado'
               WHEN e.Estado = 0 THEN 'Deshabilitado'
         END) AS Estado,
         e.Estado AS EstadoBoolean, 
		(CASE WHEN (SELECT sum(h.IdHorario) FROM horario h WHERE h.IdEstudiante = e.IdEstudiante) IS NULL THEN CONCAT("<a href='/admin/vistas/gestion-horario.php?data=", e.IdEstudiante, "'>Asignar Horario</a>")
			   WHEN (SELECT sum(h.IdHorario) FROM horario h WHERE h.IdEstudiante = e.IdEstudiante) IS NOT NULL THEN 'Asignado'
		 END) AS Practica,
		(CASE WHEN e.ControldePago = 0 THEN CONCAT("<a href='/admin/vistas/verificacion.php?data=", e.IdEstudiante, "'>Verificar</a>")
			  WHEN e.ControldePago = 1 THEN 'Verificado'
		 END) AS Inscripcion,
		CONCAT("<a class='btn btn-primary btn-sm' href='/admin/vistas/info-estudiante.php?info=", e.IdEstudiante, "'>Ver Información</a>") AS Informacion
		FROM estudiante e
		WHERE 
        CONCAT_WS(' ', e.Nombre, e.Apellido) LIKE CONCAT('%', _text, '%') OR
        e.Cedula LIKE CONCAT('%', _text, '%') LIMIT 15;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `search_student_exams_by_text` (IN `_text` VARCHAR(300))  BEGIN

SELECT CONCAT_WS(" ", e.Nombre, e.Apellido) as NombreCompleto, e.IdEstudiante as Id,
ex.TipoExamen, ee.Fecha FROM estudiante e
INNER JOIN examen_estudiante ee ON e.Idestudiante = ee.IdEstudiante
INNER JOIN examen ex ON ex.IdExamen = ee.IdExamen
WHERE 
CONCAT_WS(' ', e.Nombre, e.Apellido) LIKE CONCAT('%', _text, '%') OR
ex.TipoExamen LIKE CONCAT('%',_text, '%')  OR  ee.Fecha LIKE CONCAT('%',_text, '%')  LIMIT 15;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_as_correct_answer` (IN `_id_pregunta` INT(11), IN `_id_respuesta` INT(11))  BEGIN
	DECLARE _respuesta VARCHAR(500);
    SET _respuesta = (SELECT Respuesta FROM examen_respuestas WHERE IdRespuestas = _id_respuesta);
    UPDATE examen_respuestas SET Correcta = _respuesta WHERE IdPregunta = _id_pregunta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_answer` (IN `_id_respuesta` INT(11), IN `_respuesta` VARCHAR(200))  BEGIN
	UPDATE examen_respuestas SET Respuesta = _respuesta WHERE IdRespuestas = _id_respuesta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_info_student` (IN `_id` INT(11), IN `_nombre` VARCHAR(50), IN `_apellido` VARCHAR(50), IN `_fecha_nacimiento` VARCHAR(10), IN `_sexo` VARCHAR(10), IN `_cedula` VARCHAR(16), IN `_pasaporte` VARCHAR(100), IN `_correo` VARCHAR(200), IN `_password` VARCHAR(200), IN `_telefono` VARCHAR(10), IN `_direccion` VARCHAR(80), IN `_estado` INT(1), IN `_principiante` VARCHAR(20), IN `_licencia` VARCHAR(20), IN `_categoria` VARCHAR(50), IN `_codigo_modalidad_viejo` VARCHAR(15), IN `_codigo_modalidad_nuevo` VARCHAR(15), IN `_fecha_examen` VARCHAR(20), IN `_fecha_practica` VARCHAR(20), IN `_id_nivel` INT(11), IN `_fecha_examen_transito` VARCHAR(20), IN `_fecha_practica_transito` VARCHAR(20))  BEGIN
    
	   DECLARE _id_turno INT(11);
       DECLARE _disponibilidad_cod_anterior INT(11);
	   DECLARE _disponibilidad_cod_nuevo INT(11);

	   DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
			BEGIN
				SELECT 'Ha ocurrido un error en la actualización' AS ErrorMysql;
			END;
            
       UPDATE estudiante e SET 
            e.Nombre = _nombre, 
            e.Apellido = _apellido, 
            e.FechaNacimiento = _fecha_nacimiento, 
            e.Sexo = _sexo, 
            e.Cedula = _cedula, 
            e.Pasaporte = _pasaporte, 
            e.email = _correo, 
            e.`Password` = _password,
            e.Telefono = _telefono, 
            e.Direccion = _direccion,
            e.Estado = _estado,
			e.ControldePago = _estado,
            e.ExamenTeorico = _fecha_examen,
            e.ExamenPractico =_fecha_practica,
            e.ExamenTeoricoTransito = _fecha_examen_transito,
            e.ExamenPracticoTransito = _fecha_practica_transito            
       WHERE e.IdEstudiante = _id; 
       
       SET _id_turno = (SELECT IdTurno FROM turno WHERE Codigo = _codigo_modalidad_nuevo);
       SET _disponibilidad_cod_anterior =(SELECT Disponibilidad FROM turno WHERE Codigo = _codigo_modalidad_viejo);
	   SET _disponibilidad_cod_nuevo =(SELECT Disponibilidad FROM turno WHERE Codigo = _codigo_modalidad_nuevo);

       UPDATE inscripcion SET 
            Principiante = _principiante,
            LicenciadeConducir = _licencia,
            Categoria = _categoria,
            IdTurno = _id_turno,
            IdNivel = _id_nivel
       WHERE IdEstudiante = _id;
       
       -- cASO EN EL QUE LA DISPONIBILIDAD SEA >= 2
	 IF (_disponibilidad_cod_anterior = 2 and _disponibilidad_cod_nuevo = 2) THEN
         UPDATE turno SET Disponibilidad = Disponibilidad WHERE Codigo = _codigo_modalidad_viejo;
         UPDATE turno SET Disponibilidad = Disponibilidad - 1 WHERE Codigo = _codigo_modalidad_nuevo;			
      -- CASO EN QUE LA DISPONIBILIDAD SEA MENOR A 2
      ELSE IF(_disponibilidad_cod_anterior =1  and _disponibilidad_cod_nuevo = 1) THEN
       UPDATE turno SET Disponibilidad = Disponibilidad + 1 WHERE Codigo = _codigo_modalidad_viejo;
       UPDATE turno SET Disponibilidad = Disponibilidad - 1 WHERE Codigo = _codigo_modalidad_nuevo;			 
	 ELSE IF(_disponibilidad_cod_anterior =2  and _disponibilidad_cod_nuevo = 1) THEN
       UPDATE turno SET Disponibilidad = Disponibilidad WHERE Codigo = _codigo_modalidad_viejo;
       UPDATE turno SET Disponibilidad = Disponibilidad - 1 WHERE Codigo = _codigo_modalidad_nuevo;			 
	ELSE IF(_disponibilidad_cod_anterior =1  and _disponibilidad_cod_nuevo = 2) THEN
       UPDATE turno SET Disponibilidad = Disponibilidad + 1 WHERE Codigo = _codigo_modalidad_viejo;
       UPDATE turno SET Disponibilidad = Disponibilidad - 1 WHERE Codigo = _codigo_modalidad_nuevo;			 
    ELSE IF(_disponibilidad_cod_anterior=0) THEN
       UPDATE turno SET Disponibilidad = Disponibilidad + 1 WHERE Codigo = _codigo_modalidad_viejo;
       UPDATE turno SET Disponibilidad = Disponibilidad -1 WHERE Codigo = _codigo_modalidad_nuevo;			 
     END IF;
    END IF;
    END IF;	
   END IF;
 END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_info_student_registered` (IN `_id` INT(11), IN `_nombre` VARCHAR(50), IN `_apellido` VARCHAR(50), IN `_fecha_nacimiento` VARCHAR(10), IN `_sexo` VARCHAR(10), IN `_cedula` VARCHAR(16), IN `_pasaporte` VARCHAR(100), IN `_correo` VARCHAR(200), IN `_password` VARCHAR(200), IN `_telefono` VARCHAR(10), IN `_direccion` VARCHAR(80))  BEGIN
     
	   DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
			BEGIN
				SELECT 'Ha ocurrido un error en la actualización' AS ErrorMysql;
			END;     
       UPDATE estudiante e SET 
            e.Nombre = _nombre, 
            e.Apellido = _apellido, 
            e.FechaNacimiento = _fecha_nacimiento, 
            e.Sexo = _sexo, 
            e.Cedula = _cedula, 
            e.Pasaporte = _pasaporte, 
            e.email = _correo, 
            e.`Password` = _password,
            e.Telefono = _telefono, 
            e.Direccion = _direccion
       WHERE e.IdEstudiante = _id;        	
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_info_user` (IN `_id_user` INT(11), IN `_nombre` VARCHAR(100), IN `_apellido` VARCHAR(100), IN `_password` VARCHAR(200))  BEGIN
UPDATE `usuario` SET `Nombre`=_nombre,`Apellido`=_apellido,`Password`=_password WHERE `IdUsuario` = _id_user;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_more_info_student_by_Id` (IN `_Id` INT(11), IN `_nombreCE` VARCHAR(50), IN `_apellidoCE` VARCHAR(50), IN `_direccionCE` VARCHAR(200), IN `_telefonoCE` VARCHAR(10), IN `_emailCE` VARCHAR(200), IN `_LT` VARCHAR(100), IN `_direccionLT` VARCHAR(200), IN `_telefonoLT` VARCHAR(10), IN `_emailLT` VARCHAR(200), IN `_observaciones` VARCHAR(200))  BEGIN
	
    UPDATE inscripcion i SET  
	i.NombreCE= _nombreCE,
    i.ApellidoCE = _apellidoCE,
    i.DireccionCE = _direccionCE,
    i.TelefonoCE = _telefonoCE,
    i.EmailCE = _emailCE,
    i.LugardeTrabajo = _LT,
    i.DireccionLT = _direccionLT,
    i.TelefonoLT = _telefonoLT,
    i.EmailLT = _emailLT,
    i.Observaciones = _observaciones
    WHERE i.IdEstudiante = _Id;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_photo_question` (IN `_id_pregunta` INT(11), IN `_url_foto` VARCHAR(200))  BEGIN
	UPDATE examen_preguntas SET FotoPregunta = _url_foto WHERE IdPregunta = _id_pregunta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_photo_student` (IN `_Id_student` INT(11), IN `_url_foto` VARCHAR(200))  BEGIN
	UPDATE estudiante SET Foto = _url_foto WHERE IdEstudiante = _Id_student;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_photo_user` (IN `_id_user` INT(11), IN `_url_foto` VARCHAR(200))  BEGIN
	UPDATE usuario SET Foto = _url_foto WHERE IdUsuario = _id_user;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_question` (IN `_id_pregunta` INT(11), IN `_pregunta` VARCHAR(200))  BEGIN
	UPDATE examen_preguntas SET Preguntas = _pregunta WHERE IdPregunta = _id_pregunta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_time` (IN `_tiempo` INT(11), IN `_id_estudiante` INT(11), IN `_id_Examen` VARCHAR(200))  BEGIN
UPDATE `examen_estudiante` SET `TiempoTranscurrido`= _tiempo WHERE `IdEstudiante`=_IdEstudiante AND `idExamen`=_Id_Examen;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `verificarEstudiante` (IN `_idEstudiante` INT(11), IN `_id_nivel` INT(11), IN `_pago` INT(1), IN `_codigo` VARCHAR(500))  BEGIN
         
	   DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
			BEGIN
				SELECT 'Ha ocurrido un error en la verificacion' AS ErrorMysql;
			END;
     
       UPDATE estudiante e SET 
			e.ControldePago = _pago,
            e.CodigoVerificacion = _codigo
       WHERE e.IdEstudiante = _idEstudiante; 
              
		INSERT INTO inscripcion(IdEstudiante,IdNivel) VALUES(_idEstudiante,_id_nivel);
       
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleexamenestudiante`
--

CREATE TABLE `detalleexamenestudiante` (
  `IdDetalleExamenEstudiante` int(11) NOT NULL,
  `IdPregunta` int(11) NOT NULL,
  `IdRespuesta` int(11) NOT NULL,
  `IdExamenEstudiante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalleexamenestudiante`
--

INSERT INTO `detalleexamenestudiante` (`IdDetalleExamenEstudiante`, `IdPregunta`, `IdRespuesta`, `IdExamenEstudiante`) VALUES
(3131, 1, 0, 149),
(3132, 2, 0, 149),
(3133, 3, 0, 149),
(3134, 4, 0, 149),
(3135, 5, 0, 149),
(3136, 6, 0, 149),
(3137, 7, 0, 149),
(3138, 8, 0, 149),
(3139, 9, 0, 149),
(3140, 10, 0, 149),
(3141, 11, 0, 149),
(3142, 12, 0, 149),
(3143, 13, 0, 149),
(3144, 14, 0, 149),
(3145, 15, 0, 149),
(3146, 16, 0, 149),
(3147, 17, 0, 149),
(3148, 18, 0, 149),
(3149, 19, 0, 149),
(3150, 20, 0, 149),
(3151, 21, 65, 150),
(3152, 22, 68, 150),
(3153, 23, 71, 150),
(3154, 24, 74, 150),
(3155, 25, 77, 150),
(3156, 26, 83, 150),
(3157, 27, 85, 150),
(3158, 28, 88, 150),
(3159, 29, 91, 150),
(3160, 30, 94, 150),
(3161, 31, 97, 150),
(3162, 32, 100, 150),
(3163, 33, 103, 150),
(3164, 34, 106, 150),
(3165, 35, 109, 150),
(3166, 36, 112, 150),
(3167, 37, 115, 150),
(3168, 38, 118, 150),
(3169, 41, 129, 151),
(3170, 42, 132, 151),
(3171, 43, 135, 151),
(3172, 44, 138, 151),
(3173, 45, 141, 151),
(3174, 46, 144, 151),
(3175, 47, 147, 151),
(3176, 48, 150, 151),
(3177, 49, 153, 151),
(3178, 50, 156, 151),
(3179, 51, 159, 151),
(3180, 52, 162, 151),
(3181, 53, 165, 151),
(3182, 54, 170, 151),
(3183, 55, 173, 151),
(3184, 56, 176, 151),
(3185, 57, 179, 151),
(3186, 58, 182, 151),
(3187, 59, 185, 151),
(3188, 60, 188, 151),
(3189, 21, 65, 153),
(3190, 22, 68, 153),
(3191, 23, 71, 153),
(3192, 24, 74, 153),
(3193, 25, 77, 153),
(3194, 26, 80, 153),
(3195, 27, 86, 153),
(3196, 28, 88, 153),
(3197, 29, 91, 153),
(3198, 30, 94, 153),
(3199, 31, 97, 153),
(3200, 32, 100, 153),
(3201, 33, 103, 153),
(3202, 34, 106, 153),
(3203, 35, 109, 153),
(3204, 36, 112, 153),
(3205, 37, 115, 153),
(3206, 38, 121, 153),
(3207, 39, 123, 153),
(3208, 40, 126, 153),
(3209, 81, 259, 154),
(3210, 82, 262, 154),
(3211, 83, 268, 154),
(3212, 84, 270, 154),
(3213, 85, 273, 154),
(3214, 86, 279, 154),
(3215, 87, 281, 154),
(3216, 88, 284, 154),
(3217, 89, 287, 154),
(3218, 90, 290, 154),
(3219, 91, 293, 154),
(3220, 92, 298, 154),
(3221, 93, 300, 154),
(3222, 94, 302, 154),
(3223, 95, 305, 154),
(3224, 96, 309, 154),
(3225, 97, 314, 154),
(3226, 98, 317, 154),
(3227, 99, 323, 154),
(3228, 100, 325, 154);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `IdEstudiante` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Cedula` varchar(16) NOT NULL,
  `Pasaporte` varchar(100) NOT NULL,
  `Sexo` varchar(10) NOT NULL,
  `FechaNacimiento` varchar(10) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Direccion` varchar(80) NOT NULL,
  `Foto` varchar(200) DEFAULT NULL,
  `Estado` bit(1) NOT NULL DEFAULT b'0',
  `FotoCedulaDelante` varchar(200) NOT NULL,
  `FotoCedulaDetras` varchar(200) NOT NULL,
  `ControldePago` bit(1) NOT NULL DEFAULT b'0',
  `MetodoPago` varchar(200) DEFAULT NULL,
  `ExamenTeorico` date DEFAULT NULL,
  `ExamenPractico` date DEFAULT NULL,
  `ExamenTeoricoTransito` date DEFAULT NULL,
  `ExamenPracticoTransito` date DEFAULT NULL,
  `FotoBaucher` varchar(200) NOT NULL,
  `CodigoContrasenia` varchar(200) DEFAULT NULL,
  `CodigoContraseniaDate` date DEFAULT NULL,
  `CodigoVerificacion` varchar(200) DEFAULT NULL,
  `Seminario` int(11) DEFAULT NULL,
  `ComprobanteET` varchar(300) DEFAULT NULL,
  `ComprobanteEP` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`IdEstudiante`, `Nombre`, `Apellido`, `email`, `Password`, `Cedula`, `Pasaporte`, `Sexo`, `FechaNacimiento`, `Telefono`, `Direccion`, `Foto`, `Estado`, `FotoCedulaDelante`, `FotoCedulaDetras`, `ControldePago`, `MetodoPago`, `ExamenTeorico`, `ExamenPractico`, `ExamenTeoricoTransito`, `ExamenPracticoTransito`, `FotoBaucher`, `CodigoContrasenia`, `CodigoContraseniaDate`, `CodigoVerificacion`, `Seminario`, `ComprobanteET`, `ComprobanteEP`) VALUES
(40, 'Xochilt', 'Piche', 'xochiltpiche0008@gmail.com', 'JFuge6CmgwPVHboZ11qboQ==', '001-181097-0008D', 'Lo perdí', 'Femenino', '1997-10-18', '57801789', 'Reparto Lopez, de la sandak 1 c abajo', 'Plataforma/Imagenes/Estudiante/Perfil/PROFILE_PHOTO_40.png', b'1', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'1', NULL, '2021-01-19', '2021-01-14', '2021-04-05', '2021-04-15', 'Plataforma/Imagenes/template.png', 'f70066f78e8eab05307455f29723f813', '2021-03-21', NULL, NULL, 'Plataforma/File/Comprobante/ComprobanteET/ComprobanteET40.pdf', 'Plataforma/File/Comprobante/ComprobanteEP/ComprobanteEP40.pdf'),
(41, 'Donaldd', 'Munguia', 'donald@gmail.com', 'JFuge6CmgwPVHboZ11qboQ==', '001-110221-0054W', '033-002-300JJK', 'Masculino', '2021-01-14', '88059933', 'Jinotepe', 'Plataforma/Imagenes/Estudiante/Perfil/PROFILE_PHOTO_41.png', b'1', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'1', NULL, '2021-01-15', '0000-00-00', '2021-04-10', '2021-04-22', 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, 1, 'Plataforma/File/Comprobante/ComprobanteET/ComprobanteET41.pdf', 'Plataforma/File/Comprobante/ComprobanteEP/ComprobanteEP41.pdf'),
(42, 'Igors', 'Sweet', 'pharetra.felis@cursusa.org', 'JFuge6CmgwPVHboZ11qboQ==', '16070508 3954', '16731122 7974', 'Masculino', '2021-04-27', '010-089-46', '6391 Ac Av.', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'1', NULL, '2021-02-27', '0000-00-00', '0000-00-00', '0000-00-00', 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, 'Plataforma/File/Comprobante/ComprobanteET/ComprobanteET42.pdf', 'Plataforma/File/Comprobante/ComprobanteEP/ComprobanteEP42.pdf'),
(43, 'Ronald', 'Mendieta', 'hamilton@gmail.com', 'JFuge6CmgwPVHboZ11qboQ==', '001-010698-0036P', '033-002-300JJK', 'Femenino', '2021-01-16', '88059933', 'Granada', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'1', NULL, '2021-01-15', '0000-00-00', '0000-00-00', '0000-00-00', 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, 1, 'Plataforma/File/Comprobante/ComprobanteET/ComprobanteET43.pdf', 'Plataforma/File/Comprobante/ComprobanteEP/ComprobanteEP43.pdf'),
(44, 'Kevin', 'Jordan', 'calvito@jordan.com', 'JFuge6CmgwPVHboZ11qboQ==', '16190227 7480', '16690418 8288', 'Masculino', '2021-10-15', '047-743-11', '8372 Odio ', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'1', NULL, '2021-03-14', '0000-00-00', '0000-00-00', '0000-00-00', 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, 1, 'Plataforma/File/Comprobante/ComprobanteET/ComprobanteET44.pdf', 'Plataforma/File/Comprobante/ComprobanteEP/ComprobanteEP44.pdf'),
(45, 'Linda', 'Hamilton', 'hamiltonn@gmail.com', 'JFuge6CmgwPVHboZ11qboQ==', '001-090989-0090A', '033-002-300JJK', 'Femenino', '2021-01-16', '88059933', 'Granada', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'1', NULL, '2021-01-15', '0000-00-00', '0000-00-00', '0000-00-00', 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, 1, NULL, NULL),
(46, 'Rebekah', 'Chen', 'et@amet.org', 'JFuge6CmgwPVHboZ11qboQ==', '16741012 1334', '16880501 0793', 'Femenino', '2021-09-11', '068-977-87', '7299 Semper ', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'1', NULL, '0000-00-00', '0000-00-00', '2021-04-16', '2021-04-09', 'Plataforma/Imagenes/template.png', NULL, NULL, '043d98b0848c115b8c5e1220db473353', 1, NULL, NULL),
(47, 'Stacey', 'Dean', 'inceptos@tortoratrisus.com', 'JFuge6CmgwPVHboZ11qboQ==', '16480414 7504', '16180514 3524', '', '2021-08-18', '041-964-08', '705-6608 Lacus. Avenida', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'1', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, '454124e86eb058a6a831a669142b406b', 1, NULL, NULL),
(48, 'Samuel', 'L. Jackson', 'hamilton@gmail.com', 'JFuge6CmgwPVHboZ11qboQ==', '001-070388-0077U', '033-002-300JJK', 'Femenino', '2021-01-16', '88059933', 'Granada', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'1', NULL, '2021-01-15', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'Bethany', 'Cochran', 'sem@utodio.com', 'JFuge6CmgwPVHboZ11qboQ==', '16750709 5029', '16030505 3159', 'Femenino', '2020-07-05', '039-891-27', '996-2592 Vitae, Calle', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'1', NULL, '2021-03-17', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, 'd4643093446a5d6adcdefcde4ee95cc1', 1, NULL, NULL),
(50, 'Maxine', 'Cline', 'sapien.Cras@Namconsequatdolor.org', 'JFuge6CmgwPVHboZ11qboQ==', '16220909 0824', '16241017 0530', '', '2021-12-05', '010-731-56', '697 Diam Calle', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'1', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, 'd83d83550839438ddfb761545d591d2b', NULL, NULL, NULL),
(51, 'Ainsley', 'Witt', 'arcu.Sed.et@lobortis.net', 'JFuge6CmgwPVHboZ11qboQ==', '16171029 8637', '16310518 3556', 'Femenino', '2020-08-26', '008-441-88', '2199 Sed Ctra.', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'1', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, '96bb7290f3d22bfcc3a0b090c5e995f4', 1, NULL, NULL),
(52, 'Mari', 'Nicholson', 'sapien.cursus@variusultrices.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16410228 7085', '16270320 2123', '', '2020-04-10', '066-316-37', '4821 Vestibulum Ctra.', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'1', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, '01c8058faf554e06138c0f99fb872a7e', NULL, NULL, NULL),
(53, 'Mona', 'Robertson', 'nisi@Proin.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16410813 8795', '16491013 2424', 'Femenino', '2021-12-23', '068-087-09', 'Apdo.:768-7759 Mi. Ctra.', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'1', NULL, '2021-03-10', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, '0b033aa45a0acda9c3a23c4fd1ad5b48', NULL, NULL, NULL),
(54, 'Oliver', 'Hogan', 'enim.commodo.hendrerit@tellusfaucibus.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16131223 4543', '16000317 5429', 'Femenino', '2021-11-30', '007-343-06', 'Apartado núm.: 518, 2052 Sed ', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'1', NULL, '2021-03-14', '2021-03-22', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, 1, NULL, NULL),
(55, 'Clementine', 'Young', 'eleifend.nec.malesuada@eu.org', 'JFuge6CmgwPVHboZ11qboQ==', '16540906 4051', '16020917 5512', '', '2020-12-28', '092-598-56', '8917 Nec, Calle', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'Whoopi', 'Waller', 'sagittis@et.org', 'JFuge6CmgwPVHboZ11qboQ==', '16040220 1354', '16231003 0545', '', '2020-02-06', '016-249-77', '6022 Arcu Carretera', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'Clark', 'Cain', 'diam@sapienmolestieorci.co.uk', 'JFuge6CmgwPVHboZ11qboQ==', '16180702 9366', '16141204 1376', '', '2021-09-22', '072-005-88', '8962 Vestibulum Av.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(58, 'Daryl', 'Dunlap', 'rutrum.Fusce.dolor@magnisdis.co.uk', 'JFuge6CmgwPVHboZ11qboQ==', '16250929 2369', '16401020 8512', '', '2021-10-15', '074-058-40', '9859 Turpis Calle', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'Lucas', 'Burks', 'tellus@Pellentesque.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16920816 5341', '16941115 8547', '', '2020-07-20', '073-465-05', '5423 A Calle', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'Baxter', 'Mcpherson', 'adipiscing.non.luctus@Vestibulumanteipsum.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16700728 5690', '16100411 0548', '', '2020-01-26', '030-167-67', 'Apdo.:341-217 Eros C/', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'Eve', 'Schultz', 'faucibus.id@etrutrumnon.net', 'JFuge6CmgwPVHboZ11qboQ==', '16020908 0977', '16620827 3075', '', '2020-04-09', '031-450-45', 'Apartado núm.: 452, 2373 Eu Avda.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(63, 'Carl', 'Flynn', 'luctus@sempererat.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16230724 9694', '16000406 8078', '', '2021-07-27', '085-223-04', 'Apdo.:284-9614 Sodales Carretera', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'Bethany', 'Rhodes', 'Nulla.eget@porttitorinterdumSed.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16460715 5803', '16560813 2816', '', '2021-01-12', '064-445-04', '355-3083 Nunc Calle', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'Kenyon', 'Waters', 'sem.magna@eunibh.com', 'JFuge6CmgwPVHboZ11qboQ==', '16660805 2418', '16170827 6462', '', '2021-04-05', '059-436-50', 'Apartado núm.: 163, 2223 Nam Avda.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'Maryam', 'Flynn', 'Phasellus.dolor@egestasSed.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16180126 1999', '16530715 3915', '', '2020-08-07', '044-738-77', '2983 Morbi Ctra.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'Alana', 'Kaufman', 'Nunc.commodo.auctor@ullamcorperDuis.co.uk', 'JFuge6CmgwPVHboZ11qboQ==', '16710627 2185', '16471029 6544', '', '2020-11-08', '000-941-82', 'Apdo.:361-4892 Fermentum Ctra.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'Cullen', 'Crosby', 'Donec.tempor.est@elitdictum.org', 'JFuge6CmgwPVHboZ11qboQ==', '16670708 6093', '16260207 3880', '', '2020-09-25', '012-900-44', '249-9073 Mauris Av.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'Alyssa', 'Levine', 'Donec@ipsumcursusvestibulum.org', 'JFuge6CmgwPVHboZ11qboQ==', '16240313 5771', '16710219 8830', '', '2020-10-09', '004-922-80', 'Apartado núm.: 940, 5792 Vel C/', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'Keaton', 'Ayers', 'torquent.per.conubia@augueSedmolestie.org', 'JFuge6CmgwPVHboZ11qboQ==', '16210719 2755', '16350822 7893', '', '2020-12-31', '016-909-53', '774-5408 Vitae ', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(71, 'Indira', 'Dean', 'ullamcorper@tacitisociosqu.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16060723 1826', '16750212 3552', '', '2021-12-10', '018-540-55', 'Apartado núm.: 415, 5592 Dui ', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'Chava', 'Maddox', 'felis.eget.varius@magnaNamligula.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16740521 3237', '16050113 5172', '', '2021-05-19', '077-155-08', 'Apartado núm.: 464, 9930 Integer Av.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'Zeus', 'Travis', 'turpis.egestas.Fusce@elitAliquam.org', 'JFuge6CmgwPVHboZ11qboQ==', '16820425 1402', '16871220 1295', '', '2021-09-15', '064-599-81', 'Apartado núm.: 134, 4692 Dignissim Avenida', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'Lani', 'Witt', 'velit.in@tempusloremfringilla.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16501026 9511', '16200524 7099', '', '2021-06-01', '025-733-18', '836-6338 Diam ', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'Orlando', 'Reyes', 'mauris.a.nunc@Aeneansedpede.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16870827 0171', '16570917 9591', '', '2021-01-25', '043-828-46', 'Apdo.:650-3914 Ligula. Av.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'Kyra', 'Garner', 'sed.turpis.nec@posuereenimnisl.com', 'JFuge6CmgwPVHboZ11qboQ==', '16350318 4784', '16000303 5169', '', '2020-01-23', '016-110-52', 'Apartado núm.: 896, 9734 Donec Calle', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'David', 'Melendez', 'semper.egestas.urna@magnisdisparturient.com', 'JFuge6CmgwPVHboZ11qboQ==', '16991005 3926', '16740121 9220', '', '2020-03-04', '013-874-96', 'Apartado núm.: 563, 7761 Purus C/', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(78, 'Chantale', 'Livingston', 'sociosqu.ad.litora@laciniaSed.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16231011 6856', '16160916 2720', '', '2021-09-01', '038-670-84', 'Apdo.:740-7520 Tellus Av.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(79, 'Angelica', 'Barrett', 'mauris@turpisnec.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16830715 1228', '16190826 9325', '', '2020-05-27', '092-401-84', 'Apdo.:413-4074 Ante. Carretera', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(80, 'Quamar', 'Roth', 'ridiculus.mus@vulputate.org', 'JFuge6CmgwPVHboZ11qboQ==', '16590824 0749', '16820826 6455', '', '2021-05-08', '021-347-85', 'Apartado núm.: 561, 7749 A Calle', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(81, 'Jessica', 'Preston', 'urna@atlibero.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16161114 3866', '16970218 8104', '', '2020-05-30', '085-665-01', 'Apdo.:195-5404 Sed, Calle', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(82, 'Darryl', 'Reilly', 'eu@auctor.net', 'JFuge6CmgwPVHboZ11qboQ==', '16891206 6894', '16810226 3632', '', '2020-08-05', '011-757-02', '714-1106 Nunc. C/', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(83, 'Dominic', 'White', 'dolor.quam.elementum@aliquet.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16250917 3916', '16410917 3627', '', '2021-04-05', '048-858-26', '967-351 Euismod Avenida', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(84, 'Minerva', 'Love', 'vitae.nibh.Donec@ridiculusmusProin.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16450203 2560', '16361012 4475', '', '2021-12-30', '081-434-24', 'Apdo.:711-7259 Arcu. Av.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(85, 'Warren', 'Moses', 'eu.placerat.eget@enimnislelementum.co.uk', 'JFuge6CmgwPVHboZ11qboQ==', '16220217 8121', '16881126 9268', '', '2021-02-02', '028-085-98', '283-6608 Quis C.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(86, 'Ori', 'Richards', 'odio.Phasellus@magnaLoremipsum.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16650324 6131', '16361121 4051', '', '2021-09-12', '087-115-34', 'Apartado núm.: 822, 790 Duis Carretera', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(87, 'Kenneth', 'Rocha', 'ornare.lectus@nec.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16430702 8086', '16710230 2440', '', '2021-03-07', '028-562-66', '433-7732 Eu Carretera', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(88, 'Lars', 'Suarez', 'Donec.nibh.Quisque@lacusvariuset.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16870326 1381', '16080727 3461', '', '2021-01-25', '019-552-51', 'Apdo.:594-4530 Velit Av.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(89, 'Sawyer', 'Reynolds', 'Quisque.fringilla@Quisqueliberolacus.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16580109 8699', '16740605 8839', '', '2021-08-18', '092-719-51', 'Apdo.:963-5181 Nisi. Carretera', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(90, 'Levi', 'Franklin', 'justo@adipiscing.net', 'JFuge6CmgwPVHboZ11qboQ==', '16970501 3994', '16460707 6256', '', '2020-02-06', '045-430-10', 'Apdo.:853-4996 Eget Calle', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(91, 'Cherokee', 'Perkins', 'sodales.Mauris.blandit@auctorullamcorper.com', 'JFuge6CmgwPVHboZ11qboQ==', '16560129 4795', '16280918 7723', '', '2020-10-28', '091-588-36', 'Apdo.:823-1002 Phasellus Ctra.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(92, 'Xantha', 'Sharpe', 'Quisque.fringilla.euismod@parturientmontesnascetur.co.uk', 'JFuge6CmgwPVHboZ11qboQ==', '16630317 3832', '16270809 2131', '', '2021-05-22', '016-674-98', 'Apdo.:903-4822 Suspendisse Carretera', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(93, 'Arden', 'Fernandez', 'mattis.Integer@Proin.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16600113 1561', '16680505 0132', '', '2020-07-09', '032-947-98', 'Apartado núm.: 477, 4473 Orci Ctra.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(94, 'Isaac', 'Dudley', 'Nullam@dictumProineget.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16851006 3947', '16550901 0228', '', '2020-03-19', '090-573-97', 'Apartado núm.: 943, 9391 Donec C.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(95, 'Kylee', 'Mullins', 'molestie@vehicularisusNulla.co.uk', 'JFuge6CmgwPVHboZ11qboQ==', '16400418 5429', '16971117 1828', '', '2021-01-29', '030-300-08', '5925 Elit. Calle', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(96, 'Sandra', 'Banks', 'varius@Suspendissealiquet.com', 'JFuge6CmgwPVHboZ11qboQ==', '16030108 8597', '16171106 4160', '', '2020-10-11', '038-428-30', 'Apdo.:265-5325 Interdum ', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(97, 'David', 'Montoya', 'dictum.magna@neque.co.uk', 'JFuge6CmgwPVHboZ11qboQ==', '16900330 1133', '16600124 8589', '', '2020-10-10', '082-777-77', 'Apartado núm.: 796, 7239 Vel ', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(98, 'Halla', 'Santana', 'cubilia.Curae.Phasellus@magnaaneque.org', 'JFuge6CmgwPVHboZ11qboQ==', '16760405 5504', '16051111 0553', '', '2020-10-01', '066-056-64', '932-9825 Sit C/', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(99, 'Kaseem', 'Gay', 'Donec.tempor.est@erosNam.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16790315 6607', '16220317 4657', '', '2021-08-22', '096-128-52', 'Apartado núm.: 920, 2911 Laoreet Av.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(100, 'Bell', 'Baxter', 'Donec.egestas.Aliquam@et.net', 'JFuge6CmgwPVHboZ11qboQ==', '16250430 2940', '16510809 9978', '', '2020-08-24', '026-166-84', 'Apartado núm.: 855, 6230 Sociis Ctra.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(101, 'Quon', 'Holder', 'pretium.neque.Morbi@penatibus.org', 'JFuge6CmgwPVHboZ11qboQ==', '16921026 6004', '16960410 4258', '', '2020-11-06', '044-160-21', '1745 Integer C.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(102, 'Yetta', 'Dunn', 'rhoncus.Proin.nisl@eunullaat.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16280330 1247', '16641010 9661', '', '2020-01-18', '011-218-46', 'Apdo.:473-2331 Nulla. ', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(103, 'Lysandra', 'Kelly', 'dignissim@feugiat.co.uk', 'JFuge6CmgwPVHboZ11qboQ==', '16310410 8901', '16610906 9283', '', '2021-11-08', '047-983-75', 'Apdo.:726-4312 Dapibus Calle', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(104, 'Ursula', 'Allen', 'vel.lectus.Cum@iaculis.net', 'JFuge6CmgwPVHboZ11qboQ==', '16150509 6089', '16660215 4608', '', '2021-07-30', '078-436-89', 'Apartado núm.: 628, 453 Sodales Carretera', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(105, 'Alexander', 'Solis', 'Nam@sedorci.co.uk', 'JFuge6CmgwPVHboZ11qboQ==', '16190913 1631', '16650505 8328', '', '2020-11-18', '093-770-82', 'Apdo.:338-1273 Sodales C/', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(106, 'Anika', 'Smith', 'mauris@felis.com', 'JFuge6CmgwPVHboZ11qboQ==', '16621109 9764', '16490426 4407', '', '2020-02-05', '012-882-39', 'Apartado núm.: 487, 5118 Augue Av.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(107, 'Armand', 'Castaneda', 'at.lacus.Quisque@ametultricies.com', 'JFuge6CmgwPVHboZ11qboQ==', '16790819 8257', '16180624 3323', '', '2021-11-16', '096-347-62', '308-7244 Eget C/', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(108, 'Destiny', 'Sharp', 'interdum.ligula@anteipsum.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16460330 4454', '16280412 7310', '', '2020-11-22', '056-473-33', 'Apartado núm.: 523, 2138 Lacus. ', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(109, 'Rahim', 'Kim', 'dolor@neceuismod.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16660128 7169', '16340419 9709', '', '2020-12-25', '035-093-37', '340-616 Sollicitudin Ctra.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(110, 'Destiny', 'Alston', 'nibh@tempusmauriserat.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16971108 8162', '16401205 2736', '', '2021-07-12', '097-082-04', '253-454 Ut C/', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(111, 'Rachel', 'Bush', 'Maecenas@semperegestas.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16441015 8879', '16081119 2251', '', '2022-01-04', '010-519-17', '321-8942 Pede Carretera', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(112, 'Orlando', 'Phelps', 'amet.consectetuer.adipiscing@Vivamusrhoncus.co.uk', 'JFuge6CmgwPVHboZ11qboQ==', '16240112 7267', '16811127 1956', '', '2020-08-02', '058-238-05', 'Apdo.:462-8855 Porttitor C.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(113, 'Miranda', 'Griffith', 'semper.cursus.Integer@nisl.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16480602 0014', '16150210 2310', '', '2021-06-09', '061-011-15', '938-4774 Et, C.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(114, 'Wing', 'Doyle', 'quam.Pellentesque@veliteu.net', 'JFuge6CmgwPVHboZ11qboQ==', '16770815 7842', '16050812 9079', '', '2020-11-18', '001-255-24', '196-6723 Nunc. C/', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(115, 'Iris', 'Sandoval', 'eu@dictumcursusNunc.net', 'JFuge6CmgwPVHboZ11qboQ==', '16870606 4196', '16441002 5284', '', '2021-07-25', '099-067-76', 'Apdo.:832-8115 Cursus Ctra.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(116, 'Jeremy', 'Andrews', 'arcu@Maurisquisturpis.org', 'JFuge6CmgwPVHboZ11qboQ==', '16500819 7997', '16200213 3342', '', '2020-03-09', '047-263-02', '321-8696 Nibh ', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(117, 'Chiquita', 'Hughes', 'posuere@Etiambibendum.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16880307 8370', '16810921 2228', '', '2020-12-18', '043-417-55', '2813 Duis Avenida', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(118, 'Halee', 'Deleon', 'cursus.vestibulum.Mauris@quisurna.net', 'JFuge6CmgwPVHboZ11qboQ==', '16871211 8333', '16700610 4454', '', '2021-08-31', '076-739-80', '1473 Nullam Carretera', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(119, 'Lesley', 'Branch', 'fermentum.arcu.Vestibulum@senectuset.co.uk', 'JFuge6CmgwPVHboZ11qboQ==', '16760905 8669', '16390516 2263', '', '2021-06-17', '003-038-47', '548-6107 Duis Calle', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(120, 'Shea', 'Mcguire', 'ultrices@mipedenonummy.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16750229 5368', '16661014 0730', '', '2021-06-18', '065-163-44', '700-587 Non, ', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(121, 'Philip', 'Rocha', 'sem.egestas@erat.org', 'JFuge6CmgwPVHboZ11qboQ==', '16660219 3457', '16070414 5929', '', '2020-03-14', '036-250-77', 'Apartado núm.: 335, 6576 Mauris Av.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(122, 'Abel', 'Brock', 'nunc.sed.libero@FuscemollisDuis.com', 'JFuge6CmgwPVHboZ11qboQ==', '16290120 7353', '16550410 1428', '', '2021-11-09', '020-128-28', '9967 Ante ', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(123, 'Elvis', 'Benjamin', 'orci@Morbisit.com', 'JFuge6CmgwPVHboZ11qboQ==', '16431126 3778', '16040611 0528', '', '2020-05-13', '006-540-38', '949-2826 Imperdiet Avda.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(124, 'Ulric', 'Lara', 'elementum.sem@augueacipsum.org', 'JFuge6CmgwPVHboZ11qboQ==', '16630906 0207', '16910329 0079', '', '2021-09-11', '046-621-60', 'Apartado núm.: 317, 1036 Lectus Carretera', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(125, 'Lani', 'Gonzalez', 'dolor.Fusce@tempusscelerisque.com', 'JFuge6CmgwPVHboZ11qboQ==', '16251216 6477', '16080826 1697', '', '2020-09-11', '029-103-73', '3437 Tellus Carretera', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(126, 'Stone', 'Fuller', 'eu@eu.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16290302 8575', '16050121 7731', '', '2021-10-12', '011-439-53', '6850 Natoque Av.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(127, 'Winter', 'Gallegos', 'ac@Cumsociis.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16050518 1487', '16910507 0818', '', '2020-11-18', '001-989-07', 'Apartado núm.: 814, 830 Sed Carretera', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(128, 'Neil', 'Hawkins', 'nonummy.Fusce@Nullasemper.org', 'JFuge6CmgwPVHboZ11qboQ==', '16950511 8415', '16990702 1282', '', '2021-04-14', '053-269-00', '276-9388 Ornare, C/', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(129, 'Quyn', 'Sellers', 'scelerisque@sociosquadlitora.co.uk', 'JFuge6CmgwPVHboZ11qboQ==', '16270824 2363', '16361207 7887', '', '2021-08-28', '062-683-88', 'Apdo.:910-3224 Volutpat. Av.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(130, 'Walker', 'Dotson', 'mollis.Integer@rutrumFusce.com', 'JFuge6CmgwPVHboZ11qboQ==', '16490822 4563', '16540311 4100', '', '2021-08-11', '040-562-81', 'Apdo.:500-1892 A Avenida', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(131, 'Igor', 'Odonnell', 'euismod.et.commodo@idlibero.com', 'JFuge6CmgwPVHboZ11qboQ==', '16940416 2084', '16330920 1493', '', '2021-08-11', '012-908-92', '572-2747 Malesuada Calle', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(132, 'Whitney', 'Mcclure', 'tristique.pharetra@Donec.net', 'JFuge6CmgwPVHboZ11qboQ==', '16441219 5960', '16610114 3656', '', '2020-04-22', '087-707-33', 'Apartado núm.: 210, 5346 Facilisis ', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(133, 'Alexis', 'Warner', 'Nulla@justoProinnon.com', 'JFuge6CmgwPVHboZ11qboQ==', '16721206 4864', '16451008 8075', '', '2021-06-16', '007-964-56', '2135 Tellus C.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(134, 'Nell', 'Kelley', 'nisi@nonvestibulumnec.ca', 'JFuge6CmgwPVHboZ11qboQ==', '16880117 5897', '16311003 6898', '', '2021-05-21', '029-952-47', '8237 Porta Avda.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(135, 'Hector', 'Vang', 'ipsum.cursus@nequeetnunc.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16361221 5883', '16871214 8421', '', '2020-05-26', '074-968-00', 'Apartado núm.: 733, 561 Duis C/', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(136, 'Callum', 'Suarez', 'amet.diam.eu@placerategetvenenatis.org', 'JFuge6CmgwPVHboZ11qboQ==', '16321102 5337', '16850407 9115', '', '2020-12-16', '078-375-99', 'Apartado núm.: 729, 3755 Tellus Calle', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(137, 'Meghan', 'Benton', 'rhoncus.Donec@Namnullamagna.com', 'JFuge6CmgwPVHboZ11qboQ==', '16710303 6955', '16330810 6149', '', '2021-11-01', '090-823-64', 'Apartado núm.: 313, 5702 Interdum Avda.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(138, 'Blaze', 'Bailey', 'blandit@velarcueu.edu', 'JFuge6CmgwPVHboZ11qboQ==', '16510826 4176', '16181116 7590', '', '2021-11-09', '008-163-86', '487-7796 In Avenida', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(139, 'Christopher', 'Bullock', 'eget.dictum.placerat@Sedeu.com', 'JFuge6CmgwPVHboZ11qboQ==', '16120124 8794', '16430120 6662', '', '2021-07-18', '052-411-98', '297-3488 Luctus C.', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(140, 'Sade', 'Hayes', 'nisi.dictum@neque.com', 'JFuge6CmgwPVHboZ11qboQ==', '16890615 7972', '16890828 0384', '', '2021-07-05', '015-703-16', '9177 Vel Calle', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(141, 'Donald José', 'Munguía Guadamuz', 'jdonaldmunguia@gmail.com', 'JFuge6CmgwPVHboZ11qboQ==', '001-140195-0054W', '16192888 9384', 'Masculino', '1995-01-14', '84587686', '9177 Vel Calle', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/template.png', 'Plataforma/Imagenes/template.png', b'0', NULL, NULL, NULL, NULL, NULL, 'Plataforma/Imagenes/template.png', NULL, NULL, NULL, NULL, NULL, NULL),
(145, 'kenia', 'velasques', 'asistentecreativa2020@gmail.com', 'Kx9hs03Bi5QALSoN0p4k1Q==', '002-150720-0021H', '', 'Femenino', '2000-07-15', '48748456', '1 de marzo', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/Estudiante/Cedula-delante145.png', 'Plataforma/Imagenes/Estudiante/Cedula-detras145.png', b'1', NULL, '2021-02-27', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/Estudiante/Baucher145.png', 'a781b092e392e56de219773984bc3633', '2021-03-21', '164dace7e37eb1b5959e229fd6d117fe', NULL, NULL, NULL),
(147, 'Carmen', 'Piche', 'xochiltchan123@gmail.com', 'Z0MMmB8izq/hVYqor9MIHQ==', '001-181096-0007X', 'dsadsad', 'Femenino', '1996-10-18', '56486746', 'Managua', 'Plataforma/Imagenes/Estudiante/Perfil/PROFILE_PHOTO_147.png', b'1', 'Plataforma/Imagenes/Estudiante/Cedula-delante147.png', 'Plataforma/Imagenes/Estudiante/Cedula-detras147.png', b'1', NULL, '2021-02-25', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/Estudiante/Baucher147.png', NULL, NULL, 'ea7ec6f79362dbea33afac381f95ad4f', NULL, NULL, NULL),
(148, 'djrpruebas', 'djrpruebas', 'djrpruebas@gmail.com', '/ofJDSOhob9CKEU1ykiNqQ==', '001-151617-0089E', '', 'Femenino', '2000-07-18', '55667788', 'Villa Fontana', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/Estudiante/Cedula-delante148.png', 'Plataforma/Imagenes/Estudiante/Cedula-detras148.png', b'1', NULL, '2021-03-19', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/Estudiante/Baucher148.png', NULL, NULL, '2ac2864230df7aaa014d49176d959f60', NULL, NULL, NULL),
(149, 'xochilt del Carmen ', 'Piche Aragon', 'xochiltpiche008@gmail.com', 'k4U1VUfMNbDb8HdntbU7ng==', '002-185566-7785K', '001-18-1097-008D', 'Femenino', '1993-03-25', '55667788', 'Reparto San juan', 'Plataforma/Imagenes/template1.png', b'1', 'Plataforma/Imagenes/Estudiante/Cedula-delante149.png', 'Plataforma/Imagenes/Estudiante/Cedula-detras149.png', b'1', NULL, '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/Estudiante/Baucher149.png', NULL, NULL, '47f7f82a836f8b52aec8f6b8f3a80c3e', NULL, NULL, NULL),
(150, 'prueba', 'Método Pago', 'pruebasMP@gmail.com', 'pwnHZ1pkCZkAJtUAaDJyYA==', '001-154484-6655E', '', 'Femenino', '1996-07-26', '55789464', 'Managua', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/Estudiante/Cedula-delante150.png', 'Plataforma/Imagenes/Estudiante/Cedula-detras150.png', b'0', 'Efectivo Cordobas (C$)', '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/Estudiante/Pago150.png', NULL, NULL, NULL, NULL, NULL, NULL),
(151, 'prueba', '27-03-2021', 'pruebaMP2@gmail.com', 'GWMbRQo0k8dwunGUv0FRpg==', '545-615454-6654T', '', 'Femenino', '2021-03-27', '54784545', 'Managua', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/Estudiante/Cedula-delante151.png', 'Plataforma/Imagenes/Estudiante/Cedula-detras151.png', b'0', 'Efectivo Cordobas (C$)', '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/Estudiante/Pago151.png', NULL, NULL, NULL, NULL, NULL, NULL),
(152, 'pruebaMP', 'MP3', 'pruebaMP3@gmail.com', '0JGYhGUtKoDUaOHmyAvzQA==', '002-564864-8797E', '', 'Masculino', '2021-03-27', '54871561', 'De la iglesia ríos de agua viva un anden al norte 2 cuadras y media arriba', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/Estudiante/Cedula-delante152.png', 'Plataforma/Imagenes/Estudiante/Cedula-detras152.png', b'0', 'Efectivo Cordobas (C$)', '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/Estudiante/Pago152.png', NULL, NULL, NULL, NULL, NULL, NULL),
(153, 'PruebaMP', 'MP4', 'PruebaMP4@gmail.com', 'taxwl3oXp8shcyBM7YkU6Q==', '002-585477-7777E', '', 'Masculino', '2021-03-27', '79845615', 'Del colegio salvador Mendieta 1 cuadra arriba 20 vras al este', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/Estudiante/Cedula-delante153.png', 'Plataforma/Imagenes/Estudiante/Cedula-detras153.png', b'0', 'Efectivo Cordobas (C$)', '0000-00-00', '0000-00-00', NULL, NULL, 'Plataforma/Imagenes/Estudiante/Pago153.png', NULL, NULL, NULL, NULL, NULL, NULL),
(154, 'Martha', 'Alejandra', 'Martha@gmail.com', 'dEnKHKI24yTG4vN8R4bMAQ==', '002-250170-0002C', '0002154878748465456487', 'Femenino', '1970-01-25', '89888605', 'Reparto Lopez', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/Estudiante/Cedula-delante154.png', 'Plataforma/Imagenes/Estudiante/Cedula-detras154.png', b'0', 'Tarjeta', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Plataforma/Imagenes/Estudiante/Pago154.png', NULL, NULL, NULL, NULL, NULL, NULL),
(155, 'Prueba Registro', 'Registro', 'PruebaRegistro@gmail.com', '4zxk9I6UOQUVDfk8YTGDgQ==', '002-154879-5646E', '', 'Femenino', '2021-04-13', '54648746', 'Managua', 'Plataforma/Imagenes/template1.png', b'0', 'Plataforma/Imagenes/Estudiante/Cedula-delante155.png', 'Plataforma/Imagenes/Estudiante/Cedula-detras155.png', b'0', 'Transferencia Bancaria', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Plataforma/Imagenes/Estudiante/Pago155.png', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen`
--

CREATE TABLE `examen` (
  `IdExamen` int(11) NOT NULL,
  `TipoExamen` varchar(45) NOT NULL,
  `FechaCreacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `examen`
--

INSERT INTO `examen` (`IdExamen`, `TipoExamen`, `FechaCreacion`) VALUES
(1, 'A', '2020-12-18 10:35:04'),
(2, 'B', '2020-12-16 10:35:37'),
(3, 'C', '2020-12-17 10:35:56'),
(4, 'D', '2020-12-18 10:36:09'),
(5, 'E', '2020-12-17 10:36:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen_estudiante`
--

CREATE TABLE `examen_estudiante` (
  `IdExamenEstudiante` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `FechaFutura` datetime DEFAULT NULL,
  `Intento` int(45) NOT NULL,
  `Nota` double NOT NULL,
  `IdEstudiante` int(11) NOT NULL,
  `IdExamen` int(11) NOT NULL,
  `TiempoTranscurrido` int(11) DEFAULT NULL,
  `TiempoFormateado` varchar(100) DEFAULT NULL,
  `Disponibilidad` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `examen_estudiante`
--

INSERT INTO `examen_estudiante` (`IdExamenEstudiante`, `Fecha`, `FechaFutura`, `Intento`, `Nota`, `IdEstudiante`, `IdExamen`, `TiempoTranscurrido`, `TiempoFormateado`, `Disponibilidad`) VALUES
(149, '2021-03-15 14:25:16', '2021-03-16 14:25:16', 1, 5, 40, 1, -1, '00:00', 1),
(150, '2021-03-15 15:46:18', '2021-03-16 15:46:18', 1, 0, 41, 2, -1, '00:00', 1),
(151, '2021-03-15 16:23:42', '2021-03-16 16:23:42', 1, 0, 42, 3, -1, '00:00', 1),
(152, '2021-03-17 14:08:05', '2021-03-18 14:08:05', 1, 0, 49, 1, 710, '11:51', 0),
(153, '2021-03-18 14:23:18', '2021-03-19 14:23:18', 2, 45, 40, 2, 655, '10:56', 1),
(154, '2021-03-18 19:45:27', '2021-03-19 19:45:27', 2, 65, 41, 5, 1060, '17:41', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen_preguntas`
--

CREATE TABLE `examen_preguntas` (
  `IdPregunta` int(11) NOT NULL,
  `IdExamen` int(11) NOT NULL,
  `Preguntas` varchar(200) NOT NULL,
  `TipoExamen` varchar(200) NOT NULL,
  `Puntaje` double NOT NULL,
  `FotoPregunta` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `examen_preguntas`
--

INSERT INTO `examen_preguntas` (`IdPregunta`, `IdExamen`, `Preguntas`, `TipoExamen`, `Puntaje`, `FotoPregunta`) VALUES
(1, 1, '¿Qué es accidente de tránsito, según la ley 431? ', 'A', 5, NULL),
(2, 1, '¿Quiénes deben usar el Arcén?', 'A', 5, NULL),
(3, 1, '¿Cuál de las siguientes conductas se establece como Conducción temeraria? ', 'A', 5, NULL),
(4, 1, '¿Qué significa vía de doble sentido de circulación? ', 'A', 5, NULL),
(5, 1, '¿Qué significa vía de un sólo sentido de circulación? ', 'A', 5, NULL),
(6, 1, '¿Cuál es elemento determinante en la prevención del accidente?', 'A', 5, NULL),
(7, 1, '¿Qué es manejo defensivo?', 'A', 5, NULL),
(8, 1, '¿Cuáles pueden ser las etapas de respuesta para evitar un accidente de tránsito? ', 'A', 5, NULL),
(9, 1, '¿Cuáles son los factores en el ser humano que ayudan a desarrollar una conducción defensiva? ', 'A', 5, NULL),
(10, 1, '¿Por qué ocurre el choque con el vehículo que va adelante?', 'A', 5, NULL),
(11, 1, '¿Qué indica esta posición del agente? ', 'A', 5, '/admin/img/tests/QUESTION_PHOTO_11.jpg'),
(12, 1, '¿Qué indica esta posición del agente? ', 'A', 5, '/admin/img/tests/QUESTION_PHOTO_12.png'),
(13, 1, '¿Qué indica esta posición del agente? ', 'A', 5, '/admin/img/tests/QUESTION_PHOTO_13.jpg'),
(14, 1, '¿En qué lugares tengo permitido circular a esta velocidad?', 'A', 5, '/admin/img/tests/QUESTION_PHOTO_14.jpg'),
(15, 1, '¿En cuáles de estos lugares se establece esta prohibición?', 'A', 5, '/admin/img/tests/QUESTION_PHOTO_15.png'),
(16, 1, '¿Qué debe hacer usted si su automóvil, se desvía hacia un lado cuando frena? ', 'A', 5, NULL),
(17, 1, '¿A qué se debe que su camioneta se desvía hacia un lado cuando usted frena?', 'A', 5, NULL),
(18, 1, '¿Qué cosas debe revisar diario e su vehículo?', 'A', 5, NULL),
(19, 1, '¿En qué orden se realizan los ajustes previos que debe hacer al subir al vehículo?', 'A', 5, NULL),
(21, 2, '¿Cuáles son los principales indicadores (testigos) a los que debe prestar atención en el tablero del vehículo?', 'B', 5, NULL),
(22, 2, '¿Cuál es la forma correcta de comprobar que el vehículo se encuentra en neutro o punto muerto?', 'B', 5, NULL),
(23, 2, '¿Cuáles de las siguientes afirmaciones son verdaderas en el uso de los frenos, en los vehículos livianos?', 'B', 5, NULL),
(24, 2, '¿En qué circunstancias debe utilizar el freno de mano, en un vehículo liviano? ', 'B', 5, NULL),
(25, 2, '¿En qué lugares es prohibido utilizar la bocina (pito)?', 'B', 5, NULL),
(26, 2, '¿En cuáles de estos lugares se establece esta prohibición?', 'B', 5, '/admin/img/tests/QUESTION_PHOTO_26.png'),
(27, 2, '¿Qué tipo de señal es la se muestra?', 'B', 5, '/admin/img/tests/QUESTION_PHOTO_27.png'),
(28, 2, '¿Cuál es el significado correcto de esta señal? ', 'B', 5, '/admin/img/tests/QUESTION_PHOTO_28.png'),
(29, 2, '¿Qué debe hacer el conductor ante la presencia de esta señal?', 'B', 5, '/admin/img/tests/QUESTION_PHOTO_29.png'),
(30, 2, '¿Qué indica esta señal ensamblada junto al alto?', 'B', 5, '/admin/img/tests/QUESTION_PHOTO_30.png'),
(31, 2, '¿Qué es distancia de seguridad?', 'B', 5, NULL),
(32, 2, '¿Qué es distancia de Reacción?', 'B', 5, NULL),
(33, 2, '¿Qué es distancia de frenado?', 'B', 5, NULL),
(34, 2, '¿De qué factores depende la distancia de frenado?', 'B', 5, NULL),
(35, 2, '¿Qué método es fácil y seguro para guardar la distancia de seguridad entre vehículos?', 'B', 5, NULL),
(36, 2, '¿Cuándo debo revisar las condiciones técnicas y mecánicas del vehículo?', 'B', 5, NULL),
(37, 2, '¿Qué es el ángulo de visibilidad al conducir un vehículo?', 'B', 5, NULL),
(38, 2, '¿Qué es la Inspección técnica de vehículos?', 'B', 5, NULL),
(39, 2, '¿Qué es una Intersección?', 'B', 5, NULL),
(40, 2, '¿Quién es Peatón?', 'B', 5, NULL),
(41, 3, '¿Qué es Paso peatonal?', 'C', 5, NULL),
(42, 3, '¿Qué es conducción temeraria? ', 'C', 5, NULL),
(43, 3, '¿Cuáles son los vehículos de régimen preferentes?', 'C', 5, NULL),
(44, 3, '¿Qué es régimen preferente?', 'C', 5, NULL),
(45, 3, '¿Qué es infracción de tránsito? ', 'C', 5, NULL),
(46, 3, '¿Cómo se describe la regla del espacio o método de los dos segundos?', 'C', 5, NULL),
(47, 3, '¿Cómo evitar el choque con el vehículo que viene detrás del nuestro? ', 'C', 5, NULL),
(48, 3, '¿Qué debemos hacer si un auto o moto nos sigue muy de cerca?', 'C', 5, NULL),
(49, 3, '¿Cuáles son las medidas de seguridad para abordar con seguridad una intersección?', 'C', 5, NULL),
(50, 3, '¿Cuáles son las causas que ocasión accidentes en una intersección?', 'C', 5, NULL),
(51, 3, '¿Según la imagen, este conductor que indica?', 'C', 5, '/admin/img/tests/QUESTION_PHOTO_51.jpg'),
(52, 3, '¿Según la imagen, este conductor que indica? ', 'C', 5, '/admin/img/tests/QUESTION_PHOTO_52.png'),
(53, 3, 'Esta señal que se muestra, indica: ', 'C', 5, '/admin/img/tests/QUESTION_PHOTO_53.png'),
(54, 3, 'Esta señal que se muestra, indica: ', 'C', 5, '/admin/img/tests/QUESTION_PHOTO_54.png'),
(55, 3, 'Esta señal que se muestra, indica: ', 'C', 5, '/admin/img/tests/QUESTION_PHOTO_55.jpg'),
(56, 3, '¿Cuáles son las tres funciones básicas del aceite? ', 'C', 5, NULL),
(57, 3, '¿Qué es y Cuál es la función del cinturón de seguridad? ', 'C', 5, NULL),
(58, 3, '¿Cuál es la función de los espejos retrovisores externos y como deben ajustarse?', 'C', 5, NULL),
(59, 3, '¿Qué espejo retrovisor debo usar primero al cambiar de carril?', 'C', 5, NULL),
(60, 3, '¿Cuál es la posición de las manos que más se sugiere en el uso de las manos en el timón?', 'C', 5, NULL),
(61, 4, '¿Qué debe hacer si estaciona su vehículo en pendiente hacia abajo?', 'D', 5, NULL),
(62, 4, '¿Qué debe hacer si estaciono el vehículo en pendiente hacia arriba?', 'D', 5, NULL),
(63, 4, '¿A qué se le llama puntos ciegos o puntos muertos en el vehículo y cómo se deben cubrir al momento de conducir?', 'D', 5, NULL),
(64, 4, '¿Cuál es la forma más segura de frenar a alta velocidades?', 'D', 5, NULL),
(65, 4, '¿Qué conductas hacen a un buen conductor, de un vehículo liviano?', 'D', 5, NULL),
(66, 4, 'Esta señal indica que: ', 'D', 5, '/admin/img/tests/QUESTION_PHOTO_66.png'),
(67, 4, 'Esta señal que se le muestra, indica: ', 'D', 5, '/admin/img/tests/QUESTION_PHOTO_67.png'),
(68, 4, 'Vea este gráfico, se trata del:', 'D', 5, '/admin/img/tests/QUESTION_PHOTO_68.jpg'),
(69, 4, 'Esta señal que se le muestra, indica:', 'D', 5, '/admin/img/tests/QUESTION_PHOTO_69.png'),
(70, 4, 'Esta señal que se le muestra, indica:', 'D', 5, '/admin/img/tests/QUESTION_PHOTO_70.png'),
(71, 4, '¿Cuáles son las reglas básicas para realzar giros a la derecha?', 'D', 5, NULL),
(72, 4, '¿Qué carril debo usar si voy a girar a la izquierda desde una calle de dos carriles en el mismo sentido de circulación?', 'D', 5, NULL),
(73, 4, '¿Hacia qué carril debo dirigirme en un giro a la izquierda si la vía a la que me dirijo tiene dos o más carriles en el mismo sentido?', 'D', 5, NULL),
(74, 4, '¿Por qué el choque de frente es el más destructivo?', 'D', 5, NULL),
(75, 4, '¿Cuáles es las causa por las que produce un choque frontal?', 'D', 5, NULL),
(76, 4, '¿Qué es Suspensión de licencia?', 'D', 5, NULL),
(77, 4, '¿A que están obligados los medios de transporte de tracción humana o animal? ', 'D', 5, NULL),
(78, 4, '¿Cuándo se establece la reincidencia de infracciones ', 'D', 5, NULL),
(79, 4, '¿Qué dispositivos están obligados a portar los medios de transporte de tracción humana o animal? ', 'D', 5, NULL),
(80, 4, '¿Por cuánto tiempo se suspenderá la licencia de conducir cuando se determine la primera reincidencia?', 'D', 5, NULL),
(81, 5, '¿Qué otra sanción causa la reincidencia por infracciones? ', 'E', 5, '/admin/img/tests/QUESTION_PHOTO_81.jpeg'),
(82, 5, '¿Qué periodo de suspensión se aplica en los casos de las infracciones establecidas en los numerales 1), 2), 3), 4), 5) y 6) del artículo 26?', 'E', 5, NULL),
(83, 5, '¿Qué sanciones se aplican a los conductores temerarios?', 'E', 5, NULL),
(84, 5, '¿Cuántas infracciones puede aplicar el agente de tránsito a un conductor en un mismo momento?', 'E', 5, NULL),
(85, 5, '¿Qué es la prueba de concentración de alcohol en sangre?', 'E', 5, NULL),
(86, 5, '¿Qué causales pueden llevar a un conductor invadir el carril contrario?', 'E', 5, NULL),
(87, 5, '¿Cuáles son los pasos básicos para abordar con un vehículo, una curva a la derecha asfaltada?', 'E', 5, NULL),
(88, 5, '¿Cuáles son los pasos básicos para abordar una curva a la derecha de macadán?', 'E', 5, NULL),
(89, 5, '¿Cuáles son los pasos básicos para abordar una curva a la izquierda que esta pavimentada?', 'E', 5, NULL),
(90, 5, '¿Cuáles son los pasos básicos para abordar una curva a la izquierda que esta revestida de macadán?', 'E', 5, NULL),
(91, 5, 'Esta señal que se muestra, indica:', 'E', 5, '/admin/img/tests/QUESTION_PHOTO_91.jpg'),
(92, 5, 'Esta señal que se muestra, indica:', 'E', 5, '/admin/img/tests/QUESTION_PHOTO_92.jpg'),
(93, 5, 'Esta señal que se muestra, indica:', 'E', 5, '/admin/img/tests/QUESTION_PHOTO_93.png'),
(94, 5, 'Esta señal que se muestra, indica:', 'E', 5, '/admin/img/tests/QUESTION_PHOTO_94.jpg'),
(95, 5, 'Esta señal que se muestra, indica:', 'E', 5, '/admin/img/tests/QUESTION_PHOTO_95.jpg'),
(96, 5, '¿Qué medidas de seguridad se deben adoptar al momento que el vehículo liviano sufre desperfecto mecánico que lo imposibilite sacarlo de la vía?', 'E', 5, NULL),
(97, 5, '¿Qué acciones contribuyen a la seguridad vial de un conductor?', 'E', 5, NULL),
(98, 5, '¿Qué medidas de seguridad se deben adoptar al cambiar una llanta?', 'E', 5, NULL),
(99, 5, '¿Qué tipo de zapatos son adecuados para conducir, en el uso de los pedales?', 'E', 5, NULL),
(100, 5, '¿Qué debería hacer para ayudar a controlar la velocidad de su vehículo cuando desciende una pendiente prolongada?', 'E', 5, NULL),
(109, 1, '¿Cuáles son los elementos de seguridad de la conducción Activa?', 'A', 5, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen_respuestas`
--

CREATE TABLE `examen_respuestas` (
  `IdRespuestas` int(11) NOT NULL,
  `IdPregunta` int(11) NOT NULL,
  `Respuesta` varchar(500) NOT NULL,
  `Correcta` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `examen_respuestas`
--

INSERT INTO `examen_respuestas` (`IdRespuestas`, `IdPregunta`, `Respuesta`, `Correcta`) VALUES
(1, 1, 'La colisión entre dos vehículos o más. ', 'Un choque donde resultan personas lesionadas o muertas '),
(2, 1, 'Un choque donde resultan personas lesionadas o muertas ', 'Un choque donde resultan personas lesionadas o muertas '),
(3, 1, 'Acción u omisión culposa cometida por cualquier conductor, pasajero o peatón en la vía pública o privada causando daños materiales, lesiones o muerte de personas', 'Un choque donde resultan personas lesionadas o muertas '),
(4, 2, 'Vehículos de tracción animal, bicicletas, vehículos para discapacitados y carretones halados por personas', 'Vehículos de tracción animal, bicicletas, vehículos para discapacitados y carretones halados por personas'),
(5, 2, 'Los vehículos de transporte pesado', 'Vehículos de tracción animal, bicicletas, vehículos para discapacitados y carretones halados por personas'),
(6, 2, 'Cualquier tipo de vehículo', 'Vehículos de tracción animal, bicicletas, vehículos para discapacitados y carretones halados por personas'),
(7, 3, 'Aventajar en pendientes, curvas o puentes de forma indolente', 'Realizar maniobras acrobáticas con el vehículo en la vía publica '),
(8, 3, 'Realizar o participar en competencias de velocidad ilegales.', 'Realizar maniobras acrobáticas con el vehículo en la vía publica '),
(9, 3, 'Realizar maniobras acrobáticas con el vehículo en la vía publica ', 'Realizar maniobras acrobáticas con el vehículo en la vía publica '),
(10, 3, 'Todas las anteriores ', 'Realizar maniobras acrobáticas con el vehículo en la vía publica '),
(11, 3, 'Ninguna de las anteriores', 'Realizar maniobras acrobáticas con el vehículo en la vía publica '),
(12, 4, 'Que los vehículos están autorizados a circular en el mismo sentido de circulación', 'Que los vehículos están autorizados a circular en sentidos opuestos'),
(13, 4, 'Que los vehículos están autorizados a circular en sentidos opuestos', 'Que los vehículos están autorizados a circular en sentidos opuestos'),
(14, 4, 'Que solo se desplazan autobuses y transporte pesado', 'Que los vehículos están autorizados a circular en sentidos opuestos'),
(15, 5, 'Que los vehículos están autorizados a circular en el mismo sentido de circulación ', 'Que los vehículos están autorizados a circular en el mismo sentido de circulación '),
(16, 5, 'Que los vehículos se desplazan en sentidos opuestos', 'Que los vehículos están autorizados a circular en el mismo sentido de circulación '),
(17, 5, 'Que solo se desplazan autobuses y transporte pesado', 'Que los vehículos están autorizados a circular en el mismo sentido de circulación '),
(18, 6, 'El ser humano y su educación', 'El ser humano y su educación'),
(19, 6, 'La vía y su correcta construcción ', 'El ser humano y su educación'),
(20, 6, 'Las nuevas tecnologías en los vehículos', 'El ser humano y su educación'),
(21, 7, 'Es conducir evitando accidentes a pesar de las acciones incorrectas de los demás usuarios y las condiciones adversas ', 'Es conducir evitando accidentes a pesar de las acciones incorrectas de los demás usuarios y las condiciones adversas '),
(22, 7, 'Es salir a manejar confiando en nuestras destrezas sin importar el destino ', 'Es conducir evitando accidentes a pesar de las acciones incorrectas de los demás usuarios y las condiciones adversas '),
(23, 7, 'Es protegerse con dispositivos especiales electrónicos que nos ayudan a evitar accidentes', 'Es conducir evitando accidentes a pesar de las acciones incorrectas de los demás usuarios y las condiciones adversas '),
(24, 8, 'Valorar la situación, ir atento a lo que se presente y hacer uso de la bocina ', 'Reconocer el peligro, entender(organizar) la defensa, Actuar a tiempo '),
(25, 8, 'Reconocer el peligro, entender(organizar) la defensa, Actuar a tiempo ', 'Reconocer el peligro, entender(organizar) la defensa, Actuar a tiempo '),
(26, 8, 'Conservar la calma y decidir lo más pronto posible', 'Reconocer el peligro, entender(organizar) la defensa, Actuar a tiempo '),
(27, 9, 'Conocimiento, Alerta, Buen Juicio, Previsión, Agilidad', 'Conocimiento, Alerta, Buen Juicio, Previsión, Agilidad'),
(28, 9, 'Buena salud, buena educación, cortesía todo el tiempo ', 'Conocimiento, Alerta, Buen Juicio, Previsión, Agilidad.'),
(29, 9, 'Sentido común y un poco de suerte', 'Conocimiento, Alerta, Buen Juicio, Previsión, Agilidad.'),
(30, 10, 'Por andar los frenos bajos e ir de prisa ', 'Por no guardar la distancia, distraerse y no anticipar lo que pasa más adelante'),
(31, 10, 'Por no guardar la distancia, distraerse y no anticipar lo que pasa más adelante', 'Por no guardar la distancia, distraerse y no anticipar lo que pasa más adelante'),
(32, 10, 'Por el que el otro se detiene de pronto', 'Por no guardar la distancia, distraerse y no anticipar lo que pasa más adelante'),
(33, 11, 'Alto, detenga la marcha ', 'Alto, detenga la marcha '),
(34, 11, 'Continúe, siga a marcha', 'Alto, detenga la marcha '),
(35, 11, 'Pare al borde', 'Alto, detenga la marcha '),
(36, 12, 'Alto, detenga la marcha ', 'Pare al borde'),
(37, 12, 'Continúe, siga a marcha', 'Pare al borde'),
(38, 12, 'Pare al borde', 'Pare al borde'),
(39, 13, 'Alto, detenga la marcha', 'Continúe, siga a marcha '),
(40, 13, 'Continúe, siga a marcha ', 'Continúe, siga a marcha '),
(41, 13, 'Pare al borde', 'Continúe, siga a marcha '),
(42, 14, 'Calles y avenidas', 'Caminos y carreteras '),
(43, 14, 'Caminos y carreteras ', 'Caminos y carreteras '),
(44, 14, 'Zonas escolares y pistas', 'Caminos y carreteras '),
(45, 15, 'Cuestas, puentes y curvas', 'Cuestas, puentes y curvas'),
(46, 15, 'Bulevares, pistas, avenidas ', 'Cuestas, puentes y curvas'),
(47, 15, 'Carreteras de cuatro carriles', 'Cuestas, puentes y curvas'),
(48, 16, 'Revisar el sistema de dirección, presión de llantas y darlo alinear', 'Revisar el sistema de dirección, presión de llantas y darlo alinear'),
(49, 16, 'Bombear el pedal al frenar', 'Revisar el sistema de dirección, presión de llantas y darlo alinear'),
(50, 16, 'Frenar con más suavidad para evitar que se haga a un lado', 'Revisar el sistema de dirección, presión de llantas y darlo alinear'),
(51, 17, 'Severo desgaste de fricciones', 'Todas las anteriores '),
(52, 17, 'Desperfecto en el sistema de dirección', 'Todas las anteriores '),
(53, 17, 'Desgaste de llanta', 'Todas las anteriores '),
(54, 17, 'Todas las anteriores ', 'Todas las anteriores '),
(55, 17, 'Ninguna de las anteriores', 'Todas las anteriores '),
(56, 18, 'Nivel de aceite, nivel líquido de frenos, nivel hidráulico, batería, enfriamiento, correas', 'Nivel de aceite, nivel líquido de frenos, nivel hidráulico, batería, enfriamiento, correas'),
(57, 18, 'Los vehículos nuevos no se revisan diariamente', 'Nivel de aceite, nivel líquido de frenos, nivel hidráulico, batería, enfriamiento, correas'),
(58, 18, 'Los pistones, válvulas, líquido de frenos', 'Nivel de aceite, nivel líquido de frenos, nivel hidráulico, batería, enfriamiento, correas'),
(59, 19, 'Espejos retrovisores, cinturón de seguridad, Reposa cabezas, asiento', 'Asiento, reposa cabeza, espejos retrovisores cinturón de seguridad'),
(60, 19, 'Cinturón de seguridad, espejos retrovisores, asiento, reposa cabeza', 'Asiento, reposa cabeza, espejos retrovisores cinturón de seguridad'),
(61, 19, 'Asiento, reposa cabeza, espejos retrovisores cinturón de seguridad', 'Asiento, reposa cabeza, espejos retrovisores cinturón de seguridad'),
(65, 21, 'Tacómetro, velocímetro, combustible, temperatura, carga, aceite, frenos', 'Tacómetro, velocímetro, combustible, temperatura, carga, aceite, frenos'),
(66, 21, 'Aire acondicionado, temperatura, bolsa de aire, batería, odómetro ', 'Tacómetro, velocímetro, combustible, temperatura, carga, aceite, frenos'),
(67, 21, 'Manos libres, temperatura, GPS, control de volumen y frenos, odómetro', 'Tacómetro, velocímetro, combustible, temperatura, carga, aceite, frenos'),
(68, 22, 'Halar y empujar la palanca de velocidades, hacia atrás y adelante y posesionarla al centro del recorrido', 'Halar y empujar la palanca de velocidades, hacia atrás y adelante y posesionarla al centro del recorrido'),
(69, 22, 'Halar la palanca de velocidades, hacia izquierda y derecha y si recorre libre está en el lugar indicado', 'Halar y empujar la palanca de velocidades, hacia atrás y adelante y posesionarla al centro del recorrido'),
(70, 22, 'Cualquier forma es igual, la segunda es mejor', 'Halar y empujar la palanca de velocidades, hacia atrás y adelante y posesionarla al centro del recorrido'),
(71, 23, 'Los frenos antibloqueo tienen la ventaja de impedir que las ruedas queden bloqueadas al frenar fuertemente y aseguran una frenada más eficiente.', 'Los frenos antibloqueo tienen la ventaja de impedir que las ruedas queden bloqueadas al frenar fuertemente y aseguran una frenada más eficiente.'),
(72, 23, 'El consumo del líquido de frenos depende de la cantidad e intensidad de las frenadas. ', 'Los frenos antibloqueo tienen la ventaja de impedir que las ruedas queden bloqueadas al frenar fuertemente y aseguran una frenada más eficiente.'),
(73, 23, 'El freno hidráulico es más eficiente por que bloquea las llantas y permite detenerme en menos espacio.', 'Los frenos antibloqueo tienen la ventaja de impedir que las ruedas queden bloqueadas al frenar fuertemente y aseguran una frenada más eficiente.'),
(74, 24, 'Al estacionarse en pendiente, Al estacionarse, Al estacionarse en bajada ', 'Todas las anteriores'),
(75, 24, 'Al esperar en un semáforo, cuando fallan los frenos de servicio ', 'Todas las anteriores'),
(76, 24, 'Todas las anteriores', 'Todas las anteriores'),
(77, 25, 'En hospitales, escuelas, iglesias, servicios funerarios', 'En hospitales, escuelas, iglesias, servicios funerarios'),
(78, 25, 'En zonas comerciales, iglesias, cementerios', 'En hospitales, escuelas, iglesias, servicios funerarios'),
(79, 25, 'En los desfiles patrios, y caminos solitarios', 'En hospitales, escuelas, iglesias, servicios funerarios'),
(80, 26, 'En estacionamientos de discapacitados', 'Todas las anteriores'),
(81, 26, 'Entradas de clínicas, frente a garajes e hidrates', 'Todas las anteriores'),
(82, 26, 'En rotondas, sobre aceras y paradas de buses', 'Todas las anteriores'),
(83, 26, 'Todas las anteriores', 'Todas las anteriores'),
(84, 26, 'Ninguna de las anteriores', 'Todas las anteriores'),
(85, 27, 'Reglamentaria vertical', 'Preventiva vertical'),
(86, 27, 'Preventiva vertical', 'Preventiva vertical'),
(87, 27, 'Informativa horizontal', 'Preventiva vertical'),
(88, 28, 'Zona escolar', 'Peatones en la vía '),
(89, 28, 'Peatones en la vía ', 'Peatones en la vía '),
(90, 28, 'Zona comercial', 'Peatones en la vía '),
(91, 29, 'Reducir la velocidad y pitar', 'Reducir la velocidad y observar la presencia de semovientes'),
(92, 29, 'Reducir la velocidad y observar la presencia de semovientes ', 'Reducir la velocidad y observar la presencia de semovientes'),
(93, 29, 'Nada si no hay semovientes', 'Reducir la velocidad y observar la presencia de semovientes'),
(94, 30, 'Que la vía adyacente es de un solo sentido', 'Que la vía adyacente es de doble sentido'),
(95, 30, 'Que la vía adyacente es de doble sentido', 'Que la vía adyacente es de doble sentido'),
(96, 30, 'Que no puedo doblar en ningún sentido', 'Que la vía adyacente es de doble sentido'),
(97, 31, 'La que nos permite seguir un auto sin ser vistos ', 'La que se debe mantener entre nuestro auto y el que llevamos adelante y que nos permita realizar las maniobras de forma segura'),
(98, 31, 'La que se debe mantener entre nuestro auto y el que llevamos adelante y que nos permita realizar las maniobras de forma segura', 'La que se debe mantener entre nuestro auto y el que llevamos adelante y que nos permita realizar las maniobras de forma segura'),
(99, 31, 'La que recorre el vehículo desde que lo freno hasta que se detiene', 'La que se debe mantener entre nuestro auto y el que llevamos adelante y que nos permita realizar las maniobras de forma segura'),
(100, 32, 'La que se recorre sin que me dé cuenta mientras hablo por teléfono', 'La que el vehículo recorre mientras estoy buscando aplicar el freno'),
(101, 32, 'La que el vehículo recorre mientras estoy buscando aplicar el freno', 'La que el vehículo recorre mientras estoy buscando aplicar el freno'),
(102, 32, 'La que se recorre mientras me anticipo viendo hacia adelante', 'La que el vehículo recorre mientras estoy buscando aplicar el freno'),
(103, 33, 'Espacio que recorre el vehículo desde que aplico el freno hasta que se detiene totalmente', 'Espacio que recorre el vehículo desde que aplico el freno hasta que se detiene totalmente'),
(104, 33, 'Espacio determinado para detener el vehículo según la ley', 'Espacio que recorre el vehículo desde que aplico el freno hasta que se detiene totalmente'),
(105, 33, 'La cantidad de metros que recorre la llanta dejando la huella cuando freno', 'Espacio que recorre el vehículo desde que aplico el freno hasta que se detiene totalmente'),
(106, 34, 'De la destreza del conductor para aplicar el freno a tiempo', 'Del peso o carga del vehículo, de la velocidad y del estado de las llantas y la superficie sobre la que se frena'),
(107, 34, 'De la proporción relativa entre el estado de los frenos y las condiciones del transito', 'Del peso o carga del vehículo, de la velocidad y del estado de las llantas y la superficie sobre la que se frena'),
(108, 34, 'Del peso o carga del vehículo, de la velocidad y del estado de las llantas y la superficie sobre la que se frena', 'Del peso o carga del vehículo, de la velocidad y del estado de las llantas y la superficie sobre la que se frena'),
(109, 35, 'Calcular los metros entre vehículo y vehículo y acomodarnos según nuestra experiencia ', 'Aplicar la regla del espacio (o método de los dos segundos)'),
(110, 35, 'Dejar el espacio necesario para que el que viene atrás no le dé por aventajarnos', 'Aplicar la regla del espacio (o método de los dos segundos)'),
(111, 35, 'Aplicar la regla del espacio (o método de los dos segundos)', 'Aplicar la regla del espacio (o método de los dos segundos)'),
(112, 36, 'Cada seis meses ', 'Antes de ponerlo en marcha'),
(113, 36, 'Cada año', 'Antes de ponerlo en marcha'),
(114, 36, 'Antes de ponerlo en marcha', 'Antes de ponerlo en marcha'),
(115, 37, 'Es el área máxima de visión que debe de tener todo conductor al desplazarse sobre la vía', 'Es el área máxima de visión que debe de tener todo conductor al desplazarse sobre la vía'),
(116, 37, 'Área de amplia visibilidad en vía publica ', 'Es el área máxima de visión que debe de tener todo conductor al desplazarse sobre la vía'),
(117, 37, 'Área de desplazamiento de los automotores', 'Es el área máxima de visión que debe de tener todo conductor al desplazarse sobre la vía'),
(118, 38, 'Es el control, chequeo y revisión del vehículo', 'Todas las anteriores'),
(119, 38, 'Es la verificación de las características del vehículo.', 'Todas las anteriores'),
(120, 38, 'Es la que permite verificar las condiciones mínimas de seguridad para su funcionamiento y circulación. ', 'Todas las anteriores'),
(121, 38, 'Todas las anteriores', 'Todas las anteriores'),
(122, 38, 'Ninguna de las anteriores', 'Todas las anteriores'),
(123, 39, 'Punto de convergencia de dos a más vías públicas o privadas para su unión o cruce entre sí', 'Punto de convergencia de dos a más vías públicas o privadas para su unión o cruce entre sí'),
(124, 39, 'Una pista para automotores ', 'Punto de convergencia de dos a más vías públicas o privadas para su unión o cruce entre sí'),
(125, 39, 'Es una calle de una sola dirección', 'Punto de convergencia de dos a más vías públicas o privadas para su unión o cruce entre sí'),
(126, 40, 'El usuario de la vía que transita en carretones', 'Todo ser humano que transita por la vía pública y no conduce un vehículo automotor'),
(127, 40, 'Aquellos ciclistas que hacen uso de la vía', 'Todo ser humano que transita por la vía pública y no conduce un vehículo automotor'),
(128, 40, 'Todo ser humano que transita por la vía pública y no conduce un vehículo automotor', 'Todo ser humano que transita por la vía pública y no conduce un vehículo automotor'),
(129, 41, 'Es el área señalada y destinada para el paso exclusivo de peatones', 'Es el área señalada y destinada para el paso exclusivo de peatones'),
(130, 41, 'El área que el peatón selecciona para cruzar la vía ', 'Es el área señalada y destinada para el paso exclusivo de peatones'),
(131, 41, 'Es un área señalizada para esperar el autobús', 'Es el área señalada y destinada para el paso exclusivo de peatones'),
(132, 42, 'Realizar o participar en competencias de velocidad ilegales', 'Conducir con licencia vencida'),
(133, 42, 'Conducir con temor en la vía', 'Conducir con licencia vencida'),
(134, 42, 'Conducir con licencia vencida', 'Conducir con licencia vencida'),
(135, 43, 'Las pipas de gasolina, los recolectores de basura', 'Caravanas presidenciales, militares, de gobierno, cruz roja, auto patrullas de la Policía Nacional'),
(136, 43, 'Los de traslado de valores bancarios', 'Caravanas presidenciales, militares, de gobierno, cruz roja, auto patrullas de la Policía Nacional'),
(137, 43, 'Caravanas presidenciales, militares, de gobierno, cruz roja, auto patrullas de la Policía Nacional', 'Caravanas presidenciales, militares, de gobierno, cruz roja, auto patrullas de la Policía Nacional'),
(138, 44, 'Es el régimen de preferencia de circulación para los vehículos autorizados por la ley 431', 'Es el régimen de preferencia de circulación para los vehículos autorizados por la ley 431'),
(139, 44, 'Permiso que se solicita ante la autoridad de aplicación ', 'Es el régimen de preferencia de circulación para los vehículos autorizados por la ley 431'),
(140, 44, 'Los que usan dispositivos sonoros comerciales', 'Es el régimen de preferencia de circulación para los vehículos autorizados por la ley 431'),
(141, 45, 'La acción u omisión contraria a la ley 431 y su reglamento', 'La acción u omisión contraria a la ley 431 y su reglamento'),
(142, 45, 'La multa a pagar establecida en el arto 26', 'La acción u omisión contraria a la ley 431 y su reglamento'),
(143, 45, 'Desconocimiento de la ley 431', 'La acción u omisión contraria a la ley 431 y su reglamento'),
(144, 46, 'Conservar entre nuestro vehículo y el que va adelante un tiempo mínimo de dos segundos, apoyándonos en un punto de referencia para hacer el cálculo', 'Conservar entre nuestro vehículo y el que va adelante un tiempo mínimo de dos segundos, apoyándonos en un punto de referencia para hacer el cálculo'),
(145, 46, 'Contar dos segundos por cada vehículo que circula cercano al nuestro', 'Conservar entre nuestro vehículo y el que va adelante un tiempo mínimo de dos segundos, apoyándonos en un punto de referencia para hacer el cálculo'),
(146, 46, 'Aplicar un espacio delante de nuestro vehículo que lo podamos observar en dos segundos', 'Conservar entre nuestro vehículo y el que va adelante un tiempo mínimo de dos segundos, apoyándonos en un punto de referencia para hacer el cálculo'),
(147, 47, 'Guardando la distancia, haciendo las señales y no permitir se acerque mucho ', 'Guardando la distancia, haciendo las señales y no permitir se acerque mucho '),
(148, 47, 'Siempre le puedo culpar si anda las luces de freno en mal estado', 'Guardando la distancia, haciendo las señales y no permitir se acerque mucho '),
(149, 47, 'No distraerme hablando por celular', 'Guardando la distancia, haciendo las señales y no permitir se acerque mucho '),
(150, 48, 'Acelerar para alejarnos', 'Hacernos a un lado sin frenar para que pase '),
(151, 48, 'Hacernos a un lado sin frenar para que pase ', 'Hacernos a un lado sin frenar para que pase '),
(152, 48, 'Frenar para asustarlo y que guarde distancia', 'Hacernos a un lado sin frenar para que pase '),
(153, 49, 'Bajar la velocidad, señalizar con tiempo si va a girar, ubicar el carril correspondiente según el giro y la vía, observar y atender la señal que regula, no confiar en la preferencia', 'Bajar la velocidad, señalizar con tiempo si va a girar, ubicar el carril correspondiente según el giro y la vía, observar y atender la señal que regula, no confiar en la preferencia'),
(154, 49, 'Fijase en el semáforo y acelerar para pasar rápido antes que la luz cambie', 'Bajar la velocidad, señalizar con tiempo si va a girar, ubicar el carril correspondiente según el giro y la vía, observar y atender la señal que regula, no confiar en la preferencia'),
(155, 49, 'Bajar velocidad, darle pasada o cortesía al que va más rápido o necesita girar, en las intersecciones si tenemos preferencia no hay problema', 'Bajar la velocidad, señalizar con tiempo si va a girar, ubicar el carril correspondiente según el giro y la vía, observar y atender la señal que regula, no confiar en la preferencia'),
(156, 50, 'Desatender el alto, querer cruzar en amarillo, giros indebidos, invasión de carril, imprudencia peatonal, interceptar el paso', 'Desatender el alto, querer cruzar en amarillo, giros indebidos, invasión de carril, imprudencia peatonal, interceptar el paso'),
(157, 50, 'Cuando los autobuses obstruyen la pasada por estar estacionados, cuando el taxi para de pronto', 'Desatender el alto, querer cruzar en amarillo, giros indebidos, invasión de carril, imprudencia peatonal, interceptar el paso'),
(158, 50, 'No calcular la trayectoria de los oros ni la señal de las maniobras que ellos harán', 'Desatender el alto, querer cruzar en amarillo, giros indebidos, invasión de carril, imprudencia peatonal, interceptar el paso'),
(159, 51, 'Se dispone a salir de la vía', 'Va a girar a la izquierda'),
(160, 51, 'Va a gira ala derecha ', 'Va a girar a la izquierda'),
(161, 51, 'Va a girar a la izquierda', 'Va a girar a la izquierda'),
(162, 52, 'Se dispone a adelantar ', 'Va a girar hacia la derecha '),
(163, 52, 'Va a girar hacia la derecha ', 'Va a girar hacia la derecha '),
(164, 52, 'Va a girar hacia la izquierda', 'Va a girar hacia la derecha '),
(165, 53, 'Me aproximo a un semáforo ', 'Ninguna de las anteriores '),
(166, 53, 'Me aproximo a una curva a la derecha', 'Ninguna de las anteriores '),
(167, 53, 'Todo giro derecho, está prohibido', 'Ninguna de las anteriores '),
(168, 53, 'Ninguna de las anteriores ', 'Ninguna de las anteriores '),
(169, 53, 'Todas las anteriores', 'Ninguna de las anteriores '),
(170, 54, 'Me aproximo a un semáforo ', 'Me aproximo a una curva a la derecha '),
(171, 54, 'Me aproximo a una curva a la derecha ', 'Me aproximo a una curva a la derecha '),
(172, 54, 'Todo giro derecho, está prohibido', 'Me aproximo a una curva a la derecha '),
(173, 55, 'Dispositivo luminosos que regula la circulación vial', 'Dispositivo luminosos que regula la circulación vial'),
(174, 55, 'Me aproximo a un semáforo peatonal ', 'Dispositivo luminosos que regula la circulación vial'),
(175, 55, 'Cualquier giro, está prohibido', 'Dispositivo luminosos que regula la circulación vial'),
(176, 56, 'Limpia, lubrica y ayuda al enfriamiento ', 'Limpia, lubrica y ayuda al enfriamiento '),
(177, 56, 'Solamente lubrica las piezas del motor', 'Limpia, lubrica y ayuda al enfriamiento '),
(178, 56, 'Lubrica y auxilia la combustión', 'Limpia, lubrica y ayuda al enfriamiento '),
(179, 57, 'Un dispositivo de seguridad activa que se usa para evitar multas ', 'Un elemento de seguridad pasiva que evita que las personas se lesiones en una colisión '),
(180, 57, 'Un elemento de seguridad pasiva que evita que las personas se lesiones en una colisión ', 'Un elemento de seguridad pasiva que evita que las personas se lesiones en una colisión '),
(181, 57, 'Es un dispositivo de seguridad que se acciona solo cuando se conduce en carreteras', 'Un elemento de seguridad pasiva que evita que las personas se lesiones en una colisión '),
(182, 58, 'Le permiten mirar cuando se va a cambiar de carril, se deben poner lo más abiertos posible para ver mejor y se observan solo en caso necesario ', 'Son un elemento de seguridad activa, brindan una visión trasera lateral, se deben ajustar con un punto de referencia mínimo del vehículo para tener una referencia de la distancia y se deben revisar al'),
(183, 58, 'Son un elemento de seguridad activa, brindan una visión trasera lateral, se deben ajustar con un punto de referencia mínimo del vehículo para tener una referencia de la distancia y se deben revisar al', 'Son un elemento de seguridad activa, brindan una visión trasera lateral, se deben ajustar con un punto de referencia mínimo del vehículo para tener una referencia de la distancia y se deben revisar al'),
(184, 58, 'Sirven para observar a los lados y se deben regular cerrados para observar lo más cerca del vehículo, se deben observar solo que vengan vehículos a la par', 'Son un elemento de seguridad activa, brindan una visión trasera lateral, se deben ajustar con un punto de referencia mínimo del vehículo para tener una referencia de la distancia y se deben revisar al'),
(185, 59, 'Cualquiera, no es importante usar uno u otro ', 'Los externos, proporcionan la presencia más cercana a nuestro vehículo y después se confirma con el interno si se puede hacer la maniobra o no'),
(186, 59, 'El interno, es más preciso, los otros son opcionales', 'Los externos, proporcionan la presencia más cercana a nuestro vehículo y después se confirma con el interno si se puede hacer la maniobra o no'),
(187, 59, 'Los externos, proporcionan la presencia más cercana a nuestro vehículo y después se confirma con el interno si se puede hacer la maniobra o no', 'Los externos, proporcionan la presencia más cercana a nuestro vehículo y después se confirma con el interno si se puede hacer la maniobra o no'),
(188, 60, 'La posición 10- 10 con el método de hale y empuje para evitar cruzar las manos ', 'La posición 10- 10 con el método de hale y empuje para evitar cruzar las manos '),
(189, 60, 'La posición 09 y 15 sobre el eje del timón sobre todo si tiene bolsa de aire', 'La posición 10- 10 con el método de hale y empuje para evitar cruzar las manos '),
(190, 60, 'Cada quien lo toma como se siente más cómodo eso garantiza pericia en el uso del timón', 'La posición 10- 10 con el método de hale y empuje para evitar cruzar las manos '),
(191, 61, 'Girar las ruedas delanteras al borde de la acera o cuneta ', 'Todas las anteriores'),
(192, 61, 'Apagar el motor y ubicar el cambio en retroceso', 'Todas las anteriores'),
(193, 61, 'Dejar puesto el freno de mano o emergencia', 'Todas las anteriores'),
(194, 61, 'Todas las anteriores', 'Todas las anteriores'),
(195, 61, 'Ninguna de las anteriores', 'Todas las anteriores'),
(196, 62, 'Girar las ruedas delanteras hacia la izquierda', 'Todas las anteriores'),
(197, 62, 'Apagar motor y ubicar cambio en primera', 'Todas las anteriores'),
(198, 62, 'Dejar puesto el freno de mano o emergencia ', 'Todas las anteriores'),
(199, 62, 'Todas las anteriores', 'Todas las anteriores'),
(200, 62, 'Ninguna de las anteriores', 'Todas las anteriores'),
(201, 63, 'Puntos ciegos son los que genera la velocidad y se refiere a los detalles que se nos escapan, por eso hay que ir despacio', 'Son áreas a los lados, y atrás del vehículo que no logramos ver con los retrovisores, se debe girar la vista y en el caso de los puntos ciegos traseros verificar antes de retroceder'),
(202, 63, 'Son áreas a los lados, y atrás del vehículo que no logramos ver con los retrovisores, se debe girar la vista y en el caso de los puntos ciegos traseros verificar antes de retroceder', 'Son áreas a los lados, y atrás del vehículo que no logramos ver con los retrovisores, se debe girar la vista y en el caso de los puntos ciegos traseros verificar antes de retroceder'),
(203, 63, 'Son los defectos que generan los espejos convencionales, por eso se deben usar espejos panorámicos y cámaras de retroceso', 'Son áreas a los lados, y atrás del vehículo que no logramos ver con los retrovisores, se debe girar la vista y en el caso de los puntos ciegos traseros verificar antes de retroceder'),
(204, 64, 'Siempre para frenar y evitar que el vehículo se apague se debe presionar el clucht y después el freno ', 'Aplico el freno suavemente, al percibir reducción de velocidad se presiona el clucht y se aprovecha \r\npara bajar un cambio a la vez'),
(205, 64, 'Cuando se va rápido se debe presionar el clucht bajar un cambio y después presionar el freno', 'Aplico el freno suavemente, al percibir reducción de velocidad se presiona el clucht y se aprovecha \r\npara bajar un cambio a la vez'),
(206, 64, 'Aplico el freno suavemente, al percibir reducción de velocidad se presiona el clucht y se aprovecha \r\npara bajar un cambio a la vez', 'Aplico el freno suavemente, al percibir reducción de velocidad se presiona el clucht y se aprovecha \r\npara bajar un cambio a la vez'),
(207, 65, 'Conduce con prudencia y hace todo lo posible por evitar accidentes', 'Todas las anteriores '),
(208, 65, 'Es considerado y amable con los demás conductores y con los peatones', 'Todas las anteriores '),
(209, 65, 'Respeta la Ley de tránsito, es cortes', 'Todas las anteriores '),
(210, 65, 'Todas las anteriores ', 'Todas las anteriores '),
(211, 65, 'Ninguna de las anteriores', 'Todas las anteriores '),
(212, 66, 'Podía girar en “U” tomando las medidas de precaución', 'No podía bajo ninguna circunstancia hacer giro en “U”'),
(213, 66, 'No podía bajo ninguna circunstancia hacer giro en “U”', 'No podía bajo ninguna circunstancia hacer giro en “U”'),
(214, 66, 'La señal indica que si se puede girar en \"U\"', 'No podía bajo ninguna circunstancia hacer giro en “U”'),
(215, 67, 'Me aproximo a un semáforo', 'Todo giro izquierdo está prohibido'),
(216, 67, 'Me aproximo a una curva a la derecha', 'Todo giro izquierdo está prohibido'),
(217, 67, 'Todo giro izquierdo está prohibido', 'Todo giro izquierdo está prohibido'),
(218, 68, 'Un vehículo de régimen preferente', 'Un vehículo de régimen preferente'),
(219, 68, 'Un vehículo de circulación normal', 'Un vehículo de régimen preferente'),
(220, 68, 'Un vehículo que no es de ningún régimen', 'Un vehículo de régimen preferente'),
(221, 69, 'Use la bocina', 'Zona de silencio'),
(222, 69, 'Use luces bajas', 'Zona de silencio'),
(223, 69, 'Zona de silencio', 'Zona de silencio'),
(224, 70, 'Prohibido girar izquierdo ', 'Prohibido girar izquierdo '),
(225, 70, 'Me aproximo a una curva a la izquierda ', 'Prohibido girar izquierdo '),
(226, 70, 'Todo giro derecho, está prohibido', 'Prohibido girar izquierdo '),
(227, 71, 'Pongo la señal, observo y ejecuto', 'Señalizo, tomo con antelación mi carril (se gira del carril derecho hacia el carril derecho), atiendo la señal que regula la pasada, observo el área de la intersección y ejecuto'),
(228, 71, 'Señalizo, tomo con antelación mi carril (se gira del carril derecho hacia el carril derecho), atiendo la señal que regula la pasada, observo el área de la intersección y ejecuto', 'Señalizo, tomo con antelación mi carril (se gira del carril derecho hacia el carril derecho), atiendo la señal que regula la pasada, observo el área de la intersección y ejecuto'),
(229, 71, 'Pongo la señal, me ubico para doblar y doblo hacia donde haya espacio', 'Señalizo, tomo con antelación mi carril (se gira del carril derecho hacia el carril derecho), atiendo la señal que regula la pasada, observo el área de la intersección y ejecuto'),
(230, 72, 'El carril derecho o el carril izquierdo da lo mismo', 'Debo ubicar el carril izquierdo con anticipación y desde allí realizar la maniobra'),
(231, 72, 'Debo ubicar el carril izquierdo con anticipación y desde allí realizar la maniobra', 'Debo ubicar el carril izquierdo con anticipación y desde allí realizar la maniobra'),
(232, 72, 'No debo seguir ninguna regla solo debo fijarme y ejecutar el giro', 'Debo ubicar el carril izquierdo con anticipación y desde allí realizar la maniobra'),
(233, 73, 'Hacia el carril izquierdo siempre', 'Hacia el carril izquierdo siempre'),
(234, 73, 'Hacia el carril del centro', 'Hacia el carril izquierdo siempre'),
(235, 73, 'Hacia el carril derecho', 'Hacia el carril izquierdo siempre'),
(236, 74, 'Porque los vehículos van a mayor velocidad', 'Porque las fuerzas de ambos vehículos se encuentran y se convierten en fuerzas destructivas de A hacia B y viceversa'),
(237, 74, 'Porque las fuerzas de ambos vehículos se encuentran y se convierten en fuerzas destructivas de A hacia B y viceversa', 'Porque las fuerzas de ambos vehículos se encuentran y se convierten en fuerzas destructivas de A hacia B y viceversa'),
(238, 74, 'Porque generalmente uno de los vehículos es más grande que el otro', 'Porque las fuerzas de ambos vehículos se encuentran y se convierten en fuerzas destructivas de A hacia B y viceversa'),
(239, 75, 'El exceso de velocidad o el estado del conductor, que no permite controlar el vehículo cuando el espacio es estrecho', 'La invasión del carril contrario de parte de uno de los involucrados, independiente de la causa que originó la invasión de carril'),
(240, 75, 'La falta de pericia para llevarla dirección cuando se va rápido', 'La invasión del carril contrario de parte de uno de los involucrados, independiente de la causa que originó la invasión de carril'),
(241, 75, 'La invasión del carril contrario de parte de uno de los involucrados, independiente de la causa que originó la invasión de carril', 'La invasión del carril contrario de parte de uno de los involucrados, independiente de la causa que originó la invasión de carril\r\n'),
(242, 76, 'Las multas que se aplica a conductores que violan o infringen la ley', 'Es la acción administrativa que ejerce Seguridad de Tránsito de la Policía Nacional por infracciones de\r\nmayor peligrosidad y peligrosas'),
(243, 76, 'Es la acción administrativa que ejerce Seguridad de Tránsito de la Policía Nacional por infracciones de\r\nmayor peligrosidad y peligrosas', 'Es la acción administrativa que ejerce Seguridad de Tránsito de la Policía Nacional por infracciones de\r\nmayor peligrosidad y peligrosas'),
(244, 76, 'La retención del vehículo', 'Es la acción administrativa que ejerce Seguridad de Tránsito de la Policía Nacional por infracciones de\r\nmayor peligrosidad y peligrosas'),
(245, 77, 'Tramitar licencia de circulación y placas ante las instancias de los gobiernos municipales', 'Tramitar licencia de circulación y placas ante las instancias de los gobiernos municipales'),
(246, 77, 'En caso de no portar sus placas se retendrán y se les aplicará la infracción establecida en el artículo 26 de la presente Ley\r\n', 'Tramitar licencia de circulación y placas ante las instancias de los gobiernos municipales'),
(247, 77, 'La multa se pagará en un plazo no mayor de sesenta días, caso contrario estos medios se declararán \r\nen abandono', 'Tramitar licencia de circulación y placas ante las instancias de los gobiernos municipales'),
(248, 78, 'Al acumular en un año, tres infracciones de mayor peligrosidad, seis peligrosas o una combinación de \r\ncuatro de los dos tipos de infracciones', 'Al acumular en un año, tres infracciones de mayor peligrosidad, seis peligrosas o una combinación de \r\ncuatro de los dos tipos de infracciones'),
(249, 78, 'Al no respetar las señales e invadir carril al mismo tiempo', 'Al acumular en un año, tres infracciones de mayor peligrosidad, seis peligrosas o una combinación de \r\ncuatro de los dos tipos de infracciones'),
(250, 78, 'Cuando el agente así lo considere', 'Al acumular en un año, tres infracciones de mayor peligrosidad, seis peligrosas o una combinación de \r\ncuatro de los dos tipos de infracciones'),
(251, 79, 'Señales lumínicas de dinamo, cintas adhesivas reflectivas o de otro tipo similar', 'Todas las anteriores'),
(252, 79, 'Cintas reflexivas en la parte delantera y trasera del medio de transporte', 'Todas las anteriores'),
(253, 79, 'Sobre todo, cuando circulen entre las seis de la tarde y las cinco de la mañana, o cuando la condición \r\nde visibilidad así lo exija\r\n', 'Todas las anteriores'),
(254, 79, 'Todas las anteriores', 'Todas las anteriores'),
(255, 79, 'Ninguna de las anteriores', 'Todas las anteriores'),
(256, 80, 'Tres meses', 'Tres meses'),
(257, 80, 'Seis meses', 'Tres meses'),
(258, 80, 'Un año', 'Tres meses'),
(259, 81, 'Curso de Adiestramiento vial', 'Curso de Adiestramiento vial'),
(260, 81, 'Seminario para conductores ebrios ', 'Curso de Adiestramiento vial'),
(261, 81, 'Solo se pagará las multas', 'Curso de Adiestramiento vial'),
(262, 82, 'De tres meses hasta un a hasta un año', 'De tres meses hasta un a hasta un año'),
(263, 82, 'Segunda ocasión 6 meses', 'De tres meses hasta un a hasta un año'),
(264, 82, 'tercera ocasión 1 año', 'De tres meses hasta un a hasta un año'),
(265, 83, 'Serán responsables de infracción de conducción temeraria y se les aplicará la multa correspondiente', 'Todas las anteriores'),
(266, 83, 'Responderán por la responsabilidad penal y civil que corresponda', 'Todas las anteriores'),
(267, 83, 'Responderán por la deliberada transgresión a las normas de tránsito', 'Todas las anteriores'),
(268, 83, 'Todas las anteriores', 'Todas las anteriores'),
(269, 83, 'Ninguna de las anteriores', 'Todas las anteriores'),
(270, 84, 'Solamente una infracción', 'La o las infracciones cometidas'),
(271, 84, 'La o las infracciones cometidas', 'La o las infracciones cometidas'),
(272, 84, 'No más de tres', 'La o las infracciones cometidas'),
(273, 85, 'Es el examen al que están obligados los conductores de vehículos automotores, cuando se vean involucrados en accidentes de tránsito', 'Es el examen al que están obligados los conductores de vehículos automotores, cuando se vean involucrados en accidentes de tránsito'),
(274, 85, 'Los pasajeros, peatones pueden hacerse la prueba en la cruz roja ', 'Es el examen al que están obligados los conductores de vehículos automotores, cuando se vean involucrados en accidentes de tránsito'),
(275, 85, 'Es la prueba de sangre para saber el tipo de sangre', 'Es el examen al que están obligados los conductores de vehículos automotores, cuando se vean involucrados en accidentes de tránsito'),
(276, 86, 'Ebriedad, somnolencia, aventajar sin visibilidad, estallido de llanta, abordar mal una curva, adelantamientos prohibidos, defectuosos, o sin visibilidad, etc.', 'Todas las anteriores '),
(277, 86, 'Comportamientos temerarios, falta de control emocional.', 'Todas las anteriores '),
(278, 86, 'abordar mal una curva, adelantamientos prohibidos, defectuosos, o sin visibilidad.', 'Todas las anteriores '),
(279, 86, 'Todas las anteriores ', 'Todas las anteriores '),
(280, 86, 'Ninguna de las anteriores', 'Todas las anteriores '),
(281, 87, 'Todas las curvas se abordan a baja velocidad y con cautela', 'Antes de llegar bajar la velocidad por debajo del máximo permitido, colocarse cerca de la línea de borde derecha, al romper el arco acelerar para estabilizar'),
(282, 87, 'Antes de llegar bajar la velocidad por debajo del máximo permitido, colocarse cerca de la línea de borde derecha, al romper el arco acelerar para estabilizar', 'Antes de llegar bajar la velocidad por debajo del máximo permitido, colocarse cerca de la línea de borde derecha, al romper el arco acelerar para estabilizar'),
(283, 87, 'Antes de la curva bajar la velocidad, ubicarse al centro de la carretera y romper hacia el centro del carril para salir acelerando.', 'Antes de llegar bajar la velocidad por debajo del máximo permitido, colocarse cerca de la línea de borde derecha, al romper el arco acelerar para estabilizar'),
(284, 88, 'Todas las curvas se abordan a baja velocidad y con cautela ', 'Antes de la curva bajar la velocidad, ubicarse al centro de la carretera y romper hacia el centro del carril para salir acelerando al romper la curva'),
(285, 88, 'Antes de llegar bajar la velocidad por debajo del máximo permitido, colocarse cerca de la línea de borde derecha, al romper el arco acelerar para estabilizar', 'Antes de la curva bajar la velocidad, ubicarse al centro de la carretera y romper hacia el centro del carril para salir acelerando al romper la curva'),
(286, 88, 'Antes de la curva bajar la velocidad, ubicarse al centro de la carretera y romper hacia el centro del carril para salir acelerando al romper la curva', 'Antes de la curva bajar la velocidad, ubicarse al centro de la carretera y romper hacia el centro del carril para salir acelerando al romper la curva'),
(287, 89, 'Todas las curvas se abordan a baja velocidad y con cautela ', 'Antes de llegar bajar la velocidad por debajo del máximo permitido, colocarse al centro del carril, al romper el arco acelerar para estabilizar'),
(288, 89, 'Antes de llegar bajar la velocidad por debajo del máximo permitido, colocarse al centro del carril, al romper el arco acelerar para estabilizar', 'Antes de llegar bajar la velocidad por debajo del máximo permitido, colocarse al centro del carril, al romper el arco acelerar para estabilizar'),
(289, 89, 'Antes de la curva bajar la velocidad, ubicarse al centro de la carretera y romper hacia el centro del carril para salir acelerando', 'Antes de llegar bajar la velocidad por debajo del máximo permitido, colocarse al centro del carril, al romper el arco acelerar para estabilizar'),
(290, 90, 'Todas las curvas se abordan a baja velocidad y con cautela', 'Antes de llegar bajar la velocidad por debajo del máximo permitido, colocarse al borde derecho del carril, salir hacia el centro del carril y al romper el arco acelerar para estabilizar'),
(291, 90, 'Antes de llegar bajar la velocidad por debajo del máximo permitido, colocarse al borde derecho del carril, salir hacia el centro del carril y al romper el arco acelerar para estabilizar', 'Antes de llegar bajar la velocidad por debajo del máximo permitido, colocarse al borde derecho del carril, salir hacia el centro del carril y al romper el arco acelerar para estabilizar'),
(292, 90, 'Antes de la curva bajar la velocidad, ubicarse al centro de la carretera y romper hacia el centro del carril para salir acelerando', 'Antes de llegar bajar la velocidad por debajo del máximo permitido, colocarse al borde derecho del carril, salir hacia el centro del carril y al romper el arco acelerar para estabilizar'),
(293, 91, 'Se trata de una vía de doble sentido', 'Se trata de una vía de doble sentido'),
(294, 91, 'Me aproximo a un paso peatonal ', 'Se trata de una vía de doble sentido'),
(295, 91, 'Me aproximo a una curva a la izquierda', 'Se trata de una vía de doble sentido'),
(296, 92, 'Siga de frente', 'Siga de frente'),
(297, 92, 'No hay paso', 'Siga de frente'),
(298, 92, 'Una sola vía', 'Siga de frente'),
(299, 93, 'Cuidado, poblado próximo', 'Zona escolar'),
(300, 93, 'Zona escolar', 'Zona escolar'),
(301, 93, 'Todo giro izquierdo, está permitido', 'Zona escolar'),
(302, 94, 'Vía es de doble sentido', 'Vía es de doble sentido'),
(303, 94, 'Se puede aventajar', 'Vía es de doble sentido'),
(304, 94, 'Vía es de un solo sentido', 'Vía es de doble sentido'),
(305, 95, 'Debo detenerme y ceder el paso al que circula en vía preferencial', 'Debo detenerme y ceder el paso al que circula en vía preferencial'),
(306, 95, 'Debo pasar con cuidado sonando el pito para advertir', 'Debo detenerme y ceder el paso al que circula en vía preferencial'),
(307, 95, 'Todo giro izquierdo, está permitido', 'Debo detenerme y ceder el paso al que circula en vía preferencial'),
(308, 96, 'Activar luces laterales ', 'Colocar conos o triángulos detrás y delante del vehículo a 10 metros en la ciudad y luces de emergencia'),
(309, 96, 'Colocar conos o triángulos detrás y delante del vehículo a 10 metros en la ciudad y luces de emergencia', 'Colocar conos o triángulos detrás y delante del vehículo a 10 metros en la ciudad y luces de emergencia'),
(310, 96, 'Activar luces delanteras', 'Colocar conos o triángulos detrás y delante del vehículo a 10 metros en la ciudad y luces de emergencia '),
(311, 97, 'Respetar el derecho de pase de los peatones', 'Todas las anteriores '),
(312, 97, 'Respetar las señales de transito', 'Todas las anteriores '),
(313, 97, 'No conducir utilizando manualmente teléfonos móviles ', 'Todas las anteriores '),
(314, 97, 'Todas las anteriores ', 'Todas las anteriores '),
(315, 97, 'Ninguna de las anteriores', 'Todas las anteriores '),
(316, 98, 'Motor apagado, vehículo con cambio, freno de mano activado, llantas aseguradas ', 'Todas las anteriores'),
(317, 98, 'Poner la señalización, ciudad 10 mts al lado de la circulación, carretera 30-50 mts', 'Todas las anteriores'),
(318, 98, 'Trabajar frente a la circulación vehicular', 'Todas las anteriores'),
(319, 98, 'Todas las anteriores', 'Todas las anteriores'),
(320, 98, 'Ninguna de las anteriores', 'Todas las anteriores'),
(321, 99, 'Chínelas, sandalias, evitar tacones', 'No existe un zapato especifico, todo depende de las habilidades de la persona'),
(322, 99, 'Zapatos de tacones altos, zapatos de vaquetas, tenis', 'No existe un zapato especifico, todo depende de las habilidades de la persona'),
(323, 99, 'No existe un zapato especifico, todo depende de las habilidades de la persona', 'No existe un zapato especifico, todo depende de las habilidades de la persona'),
(324, 100, 'Sujetar el timón firmemente', 'Utilizar freno y cambio bajo'),
(325, 100, 'Utilizar freno y cambio bajo', 'Utilizar freno y cambio bajo'),
(326, 100, 'Seleccionar neutro', 'Utilizar freno y cambio bajo'),
(338, 109, 'Bolsa de aire, Cinturón de seguridad, espejos retrovisores parabrisas', NULL),
(339, 109, 'Llantas en buen estado, parabrisas, sistema de luces', NULL),
(340, 109, 'Un asiento apoya-cabeza ajustada en forma apropiada', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `IdHorario` int(11) NOT NULL,
  `Color` varchar(50) DEFAULT NULL,
  `FechaCreacion` datetime NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL,
  `FechaFinForm` date DEFAULT NULL,
  `HoraInicio` time NOT NULL,
  `HoraFin` time NOT NULL,
  `IdEstudiante` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `IdInstructor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`IdHorario`, `Color`, `FechaCreacion`, `FechaInicio`, `FechaFin`, `FechaFinForm`, `HoraInicio`, `HoraFin`, `IdEstudiante`, `IdUsuario`, `IdInstructor`) VALUES
(41, '', '2021-03-16 18:05:18', '2021-03-10', '2021-03-11', '2021-03-10', '08:00:00', '09:00:00', 41, 1, 1),
(54, '#0071c5', '2021-03-16 21:06:39', '2021-03-13', '2021-03-14', '2021-03-13', '06:00:00', '08:00:00', 41, 1, 1),
(55, '', '2021-03-16 21:09:35', '2021-03-11', '2021-03-12', '2021-03-11', '16:30:00', '17:30:00', 41, 1, 1),
(56, '', '2021-03-16 21:15:03', '2021-03-12', '2021-03-13', '2021-03-12', '06:00:00', '08:00:00', 41, 1, 1),
(60, '', '2021-03-18 22:58:41', '2021-03-18', '2021-03-19', '2021-03-18', '15:00:00', '16:00:00', 148, 1, 2),
(69, '', '2021-03-20 17:54:11', '2021-03-27', '2021-03-28', '2021-03-27', '10:00:00', '12:00:00', 42, 1, 2),
(70, '', '2021-03-20 17:54:50', '2021-03-29', '2021-03-30', '2021-03-29', '10:30:00', '12:00:00', 43, 1, 2),
(72, '', '2021-03-20 17:58:20', '2021-03-27', '2021-03-28', '2021-03-27', '13:00:00', '14:00:00', 44, 1, 2),
(73, '', '2021-03-20 17:58:34', '2021-03-31', '2021-04-01', '2021-03-31', '10:00:00', '12:00:00', 45, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `IdInscripcion` int(11) NOT NULL,
  `FechaInscripcion` datetime DEFAULT NULL,
  `Principiante` varchar(20) DEFAULT NULL,
  `LicenciadeConducir` varchar(20) DEFAULT NULL,
  `Categoria` varchar(50) DEFAULT NULL,
  `LugardeTrabajo` varchar(50) DEFAULT NULL,
  `DireccionLT` varchar(80) DEFAULT NULL,
  `TelefonoLT` varchar(10) DEFAULT NULL,
  `EmailLT` varchar(80) DEFAULT NULL,
  `NombreCE` varchar(50) DEFAULT NULL,
  `ApellidoCE` varchar(50) DEFAULT NULL,
  `DireccionCE` varchar(50) DEFAULT NULL,
  `TelefonoCE` varchar(50) DEFAULT NULL,
  `EmailCE` varchar(80) DEFAULT NULL,
  `Observaciones` varchar(200) CHARACTER SET armscii8 DEFAULT NULL,
  `IdEstudiante` int(11) NOT NULL,
  `IdTurno` int(11) DEFAULT NULL,
  `IdNivel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`IdInscripcion`, `FechaInscripcion`, `Principiante`, `LicenciadeConducir`, `Categoria`, `LugardeTrabajo`, `DireccionLT`, `TelefonoLT`, `EmailLT`, `NombreCE`, `ApellidoCE`, `DireccionCE`, `TelefonoCE`, `EmailCE`, `Observaciones`, `IdEstudiante`, `IdTurno`, `IdNivel`) VALUES
(1, '2021-02-16 13:25:02', 'Si', 'No', '1', 'RL', 'RL', '22803754', 'paula1970@gmail.com', 'Gloria', 'Lisset', 'RL', '82771526', 'lisseth@gmail.com', 'Prueba', 40, 1, 1),
(2, '2021-02-16 13:25:02', 'Si', 'No', '1', 'century', 'CCM', '12345678', 'admin@gmail.com', 'xochilt', 'Piche', 'lolos', '78578947', 'xochilt@gmail', 'ninguna', 41, 4, 1),
(3, '2021-02-16 13:25:02', 'Si', 'No', '1', 'century', 'CCM', '12345678', 'admin@gmail.com', 'xochilt', 'Piche', 'lolos', '78578947', 'xochilt@gmail', 'ninguna', 43, 4, 1),
(4, '2021-02-16 13:25:02', 'Si', 'No', '1', 'century', 'CCM', '12345678', 'admin@gmail.com', 'xochilt', 'Piche', 'lolos', '78578947', 'xochilt@gmail', 'ninguna', 45, 4, 1),
(5, '2021-02-16 13:25:02', 'Si', 'No', '1', 'century', 'CCM', '12345678', 'admin@gmail.com', 'xochilt', 'Piche', 'lolos', '78578947', 'xochilt@gmail', 'ninguna', 48, 4, 2),
(7, '2021-02-16 13:25:02', 'Si', 'No', '1', 'century', 'CCM', '12345678', 'admin@gmail.com', 'xochilt', 'Piche', 'lolos', '78578947', 'xochilt@gmail', 'ninguna', 42, 4, 1),
(13, '2021-02-16 13:25:02', 'Si', 'No', '1', 'century', 'CCM', '12345678', 'admin@gmail.com', 'xochilt', 'Piche', 'lolos', '78578947', 'xochilt@gmail', 'ninguna', 44, 4, 2),
(14, '2021-02-16 13:25:02', 'Si', 'No', '1', 'century', 'CCM', '12345678', 'admin@gmail.com', 'xochilt', 'Piche', 'lolos', '78578947', 'xochilt@gmail', 'ninguna', 54, 2, 1),
(19, '2021-02-16 13:25:02', 'Si', 'No', '1', 'century', 'CCM', '12345678', 'admin@gmail.com', 'Oscar', 'Piche', 'lolos', '78578947', 'xochilt@gmail', 'ninguna', 145, 1, 1),
(20, '2021-02-25 13:32:32', 'Si', 'No', '1', '', '', '', '', 'donald', 'madriz', 'reparto lopez', '78578947', 'xochilt@gmail', '', 147, 5, 2),
(21, '2021-03-17 18:31:54', 'Si', 'No', '1', '', '', '', '', 'Oscar', 'Piche', 'Ciudad Sandino', '884886608', 'oscarpiche021@gmail.com', '', 46, 1, 1),
(22, '2021-03-17 19:01:41', 'Si', 'No', '2', '', '', '', '', 'sadsa', 'fdsfadsf', 'Managua', '32451234', 'argeri@gmail.com', '', 47, 2, 2),
(23, '2021-03-17 19:04:32', 'Si', 'No', '2', '', '', '', '', 'pruebaInscripcion', 'Prueba', 'Managua', '52803366', 'pruebaInscripcion@gmail.com', '', 49, 2, 2),
(24, '2021-03-17 20:30:47', 'Si', 'No', '3', '', '', '', '', 'prueba de inscripcion', 'inscripcion', 'Pruebas', '55668899', 'pruebaInscripcion@gmail.com', '', 50, 4, 1),
(25, '2021-03-18 09:42:35', 'Si', 'No', '1', '', '', '', '', 'xochilt', 'Piche', 'lolos', '78578947', 'xochilt@gmail', '', 51, 1, 2),
(26, '2021-03-18 09:50:10', 'Si', 'No', '1', 'century', 'los robles', '12345678', '', 'xochilt', 'Piche', 'reparto lopez', '56489712', 'prueba@gmail.com', '', 52, 4, 1),
(27, '2021-03-18 09:58:39', 'Si', 'No', '2', '', '', '', '', 'xochilt', 'Piche', 'reparto lopez', '56489712', 'elida@gmail.com', 'probando la validaci?n de 2 estudiantes en el mismo turno', 53, 2, 1),
(28, '2021-03-18 15:14:43', 'Si', 'No', '2', 'Distribuidora Reyes', 'Masaya', '57801789', 'djreyes@distribuidorajreyes.com', 'xochilt', 'Piche', 'lolos', '78578947', 'xochilt@gmail', 'Ninguna', 148, 9, 2),
(29, '2021-03-20 10:36:13', 'Si', 'Si', '1', 'century', 'los robles', '12345678', 'admin@gmail.com', 'xochilt', 'Piche', 'batahola sur', '45789562', 'elida@gmail.com', '', 149, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instructor`
--

CREATE TABLE `instructor` (
  `IdInstructor` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `instructor`
--

INSERT INTO `instructor` (`IdInstructor`, `Nombre`, `Apellido`) VALUES
(1, 'Jorge', 'Gutierrez'),
(2, 'Enrique', 'Medano');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_curso`
--

CREATE TABLE `nivel_curso` (
  `IdNivel` int(11) NOT NULL,
  `Nivel` varchar(200) DEFAULT NULL,
  `HorasPracticas` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `nivel_curso`
--

INSERT INTO `nivel_curso` (`IdNivel`, `Nivel`, `HorasPracticas`) VALUES
(1, 'Básico', '10hrs'),
(2, 'Plus', '15hrs');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno`
--

CREATE TABLE `turno` (
  `IdTurno` int(11) NOT NULL,
  `Codigo` varchar(15) DEFAULT NULL,
  `Tipo` varchar(80) DEFAULT NULL,
  `Descripcion` varchar(200) DEFAULT NULL,
  `Disponibilidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `turno`
--

INSERT INTO `turno` (`IdTurno`, `Codigo`, `Tipo`, `Descripcion`, `Disponibilidad`) VALUES
(1, 'M_LUNES', 'Matutino', 'Lunes 9:00 am a 12:00 pm', 1),
(2, 'V_LUNES', 'Vespertino', 'Lunes 1:30 am a 4:00 pm', 0),
(3, 'M_MARTES', 'Matutino', 'Martes 9:00 am a 12:00 pm', 2),
(4, 'V_MARTES', 'Vespertino', 'Martes 1:30 am a 4:00 pm', 1),
(5, 'M_MIERCOLES', 'Matutino', 'Miércoles 9:00 am a 12:00 pm', 2),
(6, 'V_MIERCOLES', 'Vespertino', 'Miércoles 1:30 am a 4:00 pm', 2),
(7, 'M_JUEVES', 'Matutino', 'Jueves 9:00 am a 12:00 pm', 2),
(8, 'V_JUEVES', 'Vespertino', 'Jueves 1:30 am a 4:00 pm', 2),
(9, 'M_VIERNES', 'Matutino', 'Viernes 9:00 am a 12:00 pm', 2),
(10, 'V_VIERNES', 'Vespertino', 'Viernes 1:30 am a 4:00 pm', 2),
(11, 'M_SABADO', 'Matutino', 'Sábado 9:00 am a 12:00 pm', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `IdUsuario` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Estado` bit(1) NOT NULL DEFAULT b'0',
  `FechaCreacion` datetime NOT NULL,
  `FechaModificacion` datetime NOT NULL,
  `Foto` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `Nombre`, `Apellido`, `Email`, `Password`, `Estado`, `FechaCreacion`, `FechaModificacion`, `Foto`) VALUES
(1, 'Argeri', 'Argeri', 'admin@gmail.com', 'cjYA8AeD402jAPYZNUqw4w==', b'1', '2020-12-18 10:29:39', '2020-12-18 10:29:50', '/admin/img/profile/PROFILE_PHOTO_1.jpeg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalleexamenestudiante`
--
ALTER TABLE `detalleexamenestudiante`
  ADD PRIMARY KEY (`IdDetalleExamenEstudiante`),
  ADD KEY `fk_DetalleExamenEstudiante_Examen_Estudiante1_idx` (`IdExamenEstudiante`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`IdEstudiante`),
  ADD UNIQUE KEY `const_cedula` (`Cedula`);

--
-- Indices de la tabla `examen`
--
ALTER TABLE `examen`
  ADD PRIMARY KEY (`IdExamen`);

--
-- Indices de la tabla `examen_estudiante`
--
ALTER TABLE `examen_estudiante`
  ADD PRIMARY KEY (`IdExamenEstudiante`),
  ADD KEY `fk_Examen_Estudiante_Examen1_idx` (`IdExamen`),
  ADD KEY `fk_Examen_Estudiante_Examen_idx` (`IdEstudiante`);

--
-- Indices de la tabla `examen_preguntas`
--
ALTER TABLE `examen_preguntas`
  ADD PRIMARY KEY (`IdPregunta`),
  ADD KEY `fk_Examen_Preguntas_Examen1_idx` (`IdExamen`);

--
-- Indices de la tabla `examen_respuestas`
--
ALTER TABLE `examen_respuestas`
  ADD PRIMARY KEY (`IdRespuestas`),
  ADD KEY `fk_Examen_Respuestas_Examen_Preguntas1_idx` (`IdPregunta`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`IdHorario`),
  ADD KEY `fk_Horario_Usuario1_idx` (`IdUsuario`),
  ADD KEY `FK_IdEstudiante_idx` (`IdEstudiante`),
  ADD KEY `fk_Horario_Instructor_idx` (`IdInstructor`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`IdInscripcion`,`IdEstudiante`),
  ADD KEY `FK_idEstudiante_idx` (`IdEstudiante`),
  ADD KEY `FK_idTurno` (`IdTurno`),
  ADD KEY `FK_idNivel` (`IdNivel`);

--
-- Indices de la tabla `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`IdInstructor`);

--
-- Indices de la tabla `nivel_curso`
--
ALTER TABLE `nivel_curso`
  ADD PRIMARY KEY (`IdNivel`);

--
-- Indices de la tabla `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`IdTurno`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalleexamenestudiante`
--
ALTER TABLE `detalleexamenestudiante`
  MODIFY `IdDetalleExamenEstudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3229;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `IdEstudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT de la tabla `examen`
--
ALTER TABLE `examen`
  MODIFY `IdExamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `examen_estudiante`
--
ALTER TABLE `examen_estudiante`
  MODIFY `IdExamenEstudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT de la tabla `examen_preguntas`
--
ALTER TABLE `examen_preguntas`
  MODIFY `IdPregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT de la tabla `examen_respuestas`
--
ALTER TABLE `examen_respuestas`
  MODIFY `IdRespuestas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=341;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `IdHorario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `IdInscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `instructor`
--
ALTER TABLE `instructor`
  MODIFY `IdInstructor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `nivel_curso`
--
ALTER TABLE `nivel_curso`
  MODIFY `IdNivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `turno`
--
ALTER TABLE `turno`
  MODIFY `IdTurno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalleexamenestudiante`
--
ALTER TABLE `detalleexamenestudiante`
  ADD CONSTRAINT `fk_DetalleExamenEstudiante_Examen_Estudiante1` FOREIGN KEY (`IdExamenEstudiante`) REFERENCES `examen_estudiante` (`IdExamenEstudiante`);

--
-- Filtros para la tabla `examen_estudiante`
--
ALTER TABLE `examen_estudiante`
  ADD CONSTRAINT `fk_Examen_Estudiante_Examen` FOREIGN KEY (`IdEstudiante`) REFERENCES `estudiante` (`IdEstudiante`),
  ADD CONSTRAINT `fk_Examen_Estudiante_Examen1` FOREIGN KEY (`IdExamen`) REFERENCES `examen` (`IdExamen`);

--
-- Filtros para la tabla `examen_preguntas`
--
ALTER TABLE `examen_preguntas`
  ADD CONSTRAINT `fk_Examen_Preguntas_Examen1` FOREIGN KEY (`IdExamen`) REFERENCES `examen` (`IdExamen`);

--
-- Filtros para la tabla `examen_respuestas`
--
ALTER TABLE `examen_respuestas`
  ADD CONSTRAINT `fk_Examen_Respuestas_Examen_Preguntas1` FOREIGN KEY (`IdPregunta`) REFERENCES `examen_preguntas` (`IdPregunta`);

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `fk_Horario_Instructor` FOREIGN KEY (`IdInstructor`) REFERENCES `instructor` (`IdInstructor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Horario_Usuario1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`),
  ADD CONSTRAINT `fk_Horario_estudiante` FOREIGN KEY (`IdEstudiante`) REFERENCES `estudiante` (`IdEstudiante`);

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `FK_idEstudiante` FOREIGN KEY (`IdEstudiante`) REFERENCES `estudiante` (`IdEstudiante`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_idNivel` FOREIGN KEY (`IdNivel`) REFERENCES `nivel_curso` (`IdNivel`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_idTurno` FOREIGN KEY (`IdTurno`) REFERENCES `turno` (`IdTurno`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
