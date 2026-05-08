
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


CREATE TABLE departament (
    departament_id INT PRIMARY KEY,
    departament_nom VARCHAR(100) NOT NULL
);

CREATE TABLE tecnics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);


CREATE TABLE incidencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    departament_nom VARCHAR(100) NOT NULL,
    data_obertura DATETIME NOT NULL,
    descripcio TEXT NOT NULL,
    tecnic_id INT NULL,
    prioritat ENUM('Alta','Mitja','Baixa') NULL,
    resolta TINYINT(1) DEFAULT 0,
    data_tancament DATETIME NULL,
    tipus ENUM('Software','Hardware','Xarxa', 'Altres') NULL,

    FOREIGN KEY (tecnic_id) REFERENCES tecnics(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

CREATE TABLE actuacions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    incidencia_id INT NOT NULL,
    data_actuacio DATETIME NOT NULL,
    descripcio TEXT NOT NULL,
    temps INT NOT NULL,
    visible TINYINT(1) DEFAULT 1,
    resolta TINYINT(1) DEFAULT 0,

    FOREIGN KEY (incidencia_id) REFERENCES incidencies(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE accessos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuari VARCHAR(50),
    pagina VARCHAR(50),
    data DATE
);



INSERT INTO departament (departament_id, departament_nom)
VALUES(1, 'Matematiques');
INSERT INTO departament (departament_id, departament_nom)
VALUES(2, 'Informatica');
INSERT INTO departament (departament_id, departament_nom)
VALUES(3, 'Historia');
INSERT INTO departament (departament_id, departament_nom)
VALUES(4, 'Llengua');
INSERT INTO departament (departament_id, departament_nom)
VALUES(5, 'Ciencies');


INSERT INTO tecnics (nom) VALUES ('Tècnic 1');
INSERT INTO tecnics (nom) VALUES ('Tècnic 2');
INSERT INTO tecnics (nom) VALUES ('Tècnic 3');
INSERT INTO tecnics (nom) VALUES ('Tècnic 4');
INSERT INTO tecnics (nom) VALUES ('Tècnic 5');
