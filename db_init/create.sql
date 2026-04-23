SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS persones
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Donem permisos a l'usuari 'usuari' per accedir a la base de dades 'persones'
-- sinó, aquest usuari no podrà veure la base de dades i no podrà accedir a les taules
GRANT ALL PRIVILEGES ON persones.* TO 'usuari'@'%';
FLUSH PRIVILEGES;


-- Després de crear la base de dades, cal seleccionar-la per treballar-hi
USE persones;



CREATE TABLE incidencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    departament_nom VARCHAR2(50) NOT NULL,
    data_incidencia SYSDATE,
    prioritat VARCHAR2(10),
    descripcio VARCHAR2(255)
);

CREATE TABLE actuacio (
    actuacio_id INT AUTO_INCREMENT PRIMARY KEY,
    descripcio VARCHAR2(25)
);

CREATE TABLE departament(
    departament_id INT PRIMARY KEY,
    departament_nom VARCHAR2(20)
);

-- Afegim algunes dades inicials a la taula cases
INSERT INTO cases (name) VALUES ('Casa Milà');
INSERT INTO cases (name) VALUES ('Casa Batlló');
INSERT INTO cases (name) VALUES ('Casa Gaudí');