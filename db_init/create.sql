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


CREATE TABLE cases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE incidencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    departament_nom VARCHAR2(20) NOT NULL,
    data_incidencia SYSDATE,
    descripcio VARCHAR2(50)
);

CREATE TABLE actuacio (
    descripcio VARCHAR2(25)
);

-- Afegim algunes dades inicials a la taula cases
INSERT INTO cases (name) VALUES ('Casa Milà');
INSERT INTO cases (name) VALUES ('Casa Batlló');
INSERT INTO cases (name) VALUES ('Casa Gaudí');