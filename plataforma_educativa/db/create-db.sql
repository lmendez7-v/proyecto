CREATE DATABASE db_plataforma_educativa_umg;

use db_plataforma_educativa_umg;

create table tbl_area_matematica(
	id_area_matematica int not null auto_increment,
	descripcion nvarchar(100) not null,
	primary key (id_area_matematica)
);
create table tbl_tema_modulo(
	id_tema_modulo int not null auto_increment, 
	id_area_matematica int not null,
	descripcion_tema_modulo varchar(200),
	estado binary ,
	primary key (id_tema_modulo),
	foreign key (id_area_matematica) references tbl_area_matematica(id_area_matematica)
);
create table tbl_enunciado_ejercicio(
	id_enunciado_ejercicio int not null auto_increment,
	id_tema_modulo int not null,
	enunciado nvarchar(100),
	respuesta_esperada decimal(12,2),
	primary key (id_enunciado_ejercicio),
	foreign key (id_tema_modulo) references tbl_tema_modulo(id_tema_modulo)
);
create table tbl_usuario(
	id_usuario int not null auto_increment,
	nombres_usuario nvarchar(100) not null,
	apellidos_usuario nvarchar(100),
	usuario nvarchar(40) not null, 
	clave nvarchar(256) not null,
	fecha_registro timestamp default CURRENT_TIMESTAMP(),
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    primary key (id_usuario)
)

create table tbl_enunciado_usuario_nota(
	id_enunciado_usuario_nota int not null auto_increment, 
	id_usuario int not null,
	id_enunciado_ejercicio int not null,
	no_intentos int not null,
	punteo decimal(12,2),
	fecha_registro timestamp default CURRENT_TIMESTAMP(),
	primary key (id_enunciado_usuario_nota),
	foreign key (id_usuario) references tbl_usuario(id_usuario),
	foreign key (id_enunciado_ejercicio) references tbl_enunciado_ejercicio(id_enunciado_ejercicio)
);
create table tbl_respuesta_enunciado(
	id_respuesta_enunciado int not null auto_increment, 
	id_enunciado_usuario_nota int not null,
	respuesta_ingresada decimal(12,2) not null,
	primary key (id_respuesta_enunciado),
	foreign key (id_enunciado_usuario_nota)references tbl_enunciado_usuario_nota(id_enunciado_usuario_nota)
);

