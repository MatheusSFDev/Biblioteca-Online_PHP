CREATE DATABASE bibliotecaOnline;
USE bibliotecaOnline;

CREATE TABLE usuarios (
    email varchar(255) primary key,
    nombre varchar(100) not null,
    passwd varchar(255) not null,
    foto varchar(255) not null
);

CREATE TABLE juegos (
    id int primary key auto_increment,
    titulo varchar(200) not null,
    descripcion text,
    autor varchar(100),
    caratula varchar(255),
    categoria varchar(50),
    enlace varchar(500),
    ano smallint,
    visualizaciones bigint default 0,
    propietario varchar(255),

    CONSTRAINT jue_pro_fk FOREIGN KEY (propietario) REFERENCES usuarios(email)
);

CREATE TABLE votos (
    voto boolean,
    email varchar(255),
    id int,

    CONSTRAINT vot_pk  PRIMARY KEY (email, id),
    CONSTRAINT vot_em_fk FOREIGN KEY (email) REFERENCES usuarios(email),
    CONSTRAINT vot_id_fk FOREIGN KEY (id) REFERENCES juegos(id)
);

CREATE USER 'adminPHP'@'localhost' identified by 'qwerty-1234';
GRANT all ON bibliotecaOnline.* TO 'adminPHP'@'localhost'; 