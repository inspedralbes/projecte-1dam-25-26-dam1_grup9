SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS Incidencies
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Donem permisos a l'usuari 'usuari' per accedir a la base de dades 'persones'
-- sinó, aquest usuari no podrà veure la base de dades i no podrà accedir a les taules
GRANT ALL PRIVILEGES ON Incidencies.* TO 'admin'@'%';
FLUSH PRIVILEGES;


-- Després de crear la base de dades, cal seleccionar-la per treballar-hi
USE Incidencies;





CREATE TABLE actuacio (
    actuacio_id INT AUTO_INCREMENT PRIMARY KEY,
    descripcio VARCHAR(25),
    visible BOOLEAN
);

CREATE TABLE departament(
    departament_id INT PRIMARY KEY,
    departament_nom VARCHAR(50)
);

CREATE TABLE incidencies (
     id INT AUTO_INCREMENT PRIMARY KEY,
     departament_id INT,
     data_incidencia TIMESTAMP,
     prioritat VARCHAR(10),
     descripcio VARCHAR(255),
     FOREIGN KEY(departament_id)REFERENCES departament(departament_id)
);

CREATE TABLE tecnics(
    dni INT PRIMARY KEY,
    nom VARCHAR(25),
    cognom VARCHAR(25)
);

CREATE TABLE acces(
    acces_id INT AUTO_INCREMENT PRIMARY KEY
);