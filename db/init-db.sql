-- Carga de data para la plataforma
-- De preferencia se ejecuta, consulta por consulta, igual en las variables set, primero se ejecuta el set
-- y luego la consulta siguiente
-- Inserta las áreas matemáticas básicas
INSERT INTO tbl_area_matematica
    (descripcion)
VALUES
    ('Suma'),
    ('Resta'),
    ('Multiplicación'),
    ('División');

-- Temas/Módulos dinámicos
INSERT INTO tbl_tema_modulo
    (id_area_matematica, descripcion_tema_modulo, estado)
SELECT id_area_matematica, 'Operaciones básicas', 1
FROM tbl_area_matematica
WHERE descripcion IN ('Suma', 'Resta', 'División');

-- Para multiplicación: Tablas del 1 al 10
SET @id_mult :=
(SELECT id_area_matematica
FROM tbl_area_matematica
WHERE descripcion = 'Multiplicación')

INSERT INTO tbl_tema_modulo
    (id_area_matematica, descripcion_tema_modulo, estado)
SELECT
    @id_mult, CONCAT('Tabla del ', n), 1
FROM (
                                                                                                                                                                  SELECT 1 AS n
    UNION
        SELECT 2
    UNION
        SELECT 3
    UNION
        SELECT 4
    UNION
        SELECT 5
    UNION
        SELECT 6
    UNION
        SELECT 7
    UNION
        SELECT 8
    UNION
        SELECT 9
    UNION
        SELECT 10
) AS nums;

-- Generar enunciados para las tablas de multiplicar (1 al 10)
SET @id_mult :=
(SELECT id_area_matematica
FROM tbl_area_matematica
WHERE descripcion = 'Multiplicación');
-- Recorremos los temas de multiplicación
INSERT INTO tbl_enunciado_ejercicio
    (id_tema_modulo, enunciado, respuesta_esperada)
SELECT tm.id_tema_modulo,
    CONCAT(SUBSTRING_INDEX(tm.descripcion_tema_modulo, ' ', -1), ' x ', n) AS enunciado,
    CAST(SUBSTRING_INDEX(tm.descripcion_tema_modulo, ' ', -1) AS UNSIGNED) * n AS respuesta_esperada
FROM tbl_tema_modulo tm
    JOIN (
                                                                                                                                                                  SELECT 1 AS n
    UNION
        SELECT 2
    UNION
        SELECT 3
    UNION
        SELECT 4
    UNION
        SELECT 5
    UNION
        SELECT 6
    UNION
        SELECT 7
    UNION
        SELECT 8
    UNION
        SELECT 9
    UNION
        SELECT 10
) AS numeros 
WHERE tm.id_area_matematica = @id_mult;

-- Enunciados básicos para Suma
INSERT INTO tbl_enunciado_ejercicio
    (id_tema_modulo, enunciado, respuesta_esperada)
SELECT tm.id_tema_modulo, '5 + 3', 8
FROM tbl_tema_modulo tm
    JOIN tbl_area_matematica a ON tm.id_area_matematica = a.id_area_matematica
WHERE a.descripcion = 'Suma';

-- Enunciados básicos para Resta
INSERT INTO tbl_enunciado_ejercicio
    (id_tema_modulo, enunciado, respuesta_esperada)
SELECT tm.id_tema_modulo, '9 - 4', 5
FROM tbl_tema_modulo tm
    JOIN tbl_area_matematica a ON tm.id_area_matematica = a.id_area_matematica
WHERE a.descripcion = 'Resta';

-- Enunciados básicos para División
INSERT INTO tbl_enunciado_ejercicio
    (id_tema_modulo, enunciado, respuesta_esperada)
SELECT tm.id_tema_modulo, '8 / 2', 4
FROM tbl_tema_modulo tm
    JOIN tbl_area_matematica a ON tm.id_area_matematica = a.id_area_matematica
WHERE a.descripcion = 'División';
