CREATE DATABASE bibliotecaOnline;
USE bibliotecaOnline;

CREATE TABLE usuarios (
    email varchar(255) primary key,
    nombre varchar(100) not null,
    passwd varchar(255) not null
);

CREATE TABLE juegos (
    id int primary key auto_increment,
    titulo varchar(200) not null,
    descripcion text,
    autor varchar(100),
    caratula varchar(255),
    categoria varchar(50),
    url varchar(500),
    año smallint,
    propietario varchar(255),

    constraint jue_pro_fk foreign key (propietario) references usuarios(email)
);

CREATE USER 'adminPHP'@'localhost' identified by 'qwerty-1234';
GRANT all ON bibliotecaOnline.* TO 'adminPHP'@'localhost'; 