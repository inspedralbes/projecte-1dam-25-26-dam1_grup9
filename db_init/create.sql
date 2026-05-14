
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
    id INT PRIMARY KEY,
    departament_nom VARCHAR(100) NOT NULL
);

CREATE TABLE tecnics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);


CREATE TABLE incidencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    departament_id INT NOT NULL,
    data_obertura DATETIME NOT NULL,
    descripcio TEXT NOT NULL,
    tecnic_id INT NULL,
    prioritat ENUM('Alta','Mitja','Baixa') NULL,
    resolta TINYINT(1) DEFAULT 0,
    data_tancament DATETIME NULL,
    tipus ENUM('Software','Hardware','Xarxa', 'Altres') NULL,

    FOREIGN KEY (tecnic_id) REFERENCES tecnics(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    
    FOREIGN KEY (departament_id) REFERENCES departament(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
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



INSERT INTO departament (id, departament_nom)
VALUES(1, 'Matematiques');
INSERT INTO departament (id, departament_nom)
VALUES(2, 'Informatica');
INSERT INTO departament (id, departament_nom)
VALUES(3, 'Historia');
INSERT INTO departament (id, departament_nom)
VALUES(4, 'Llengua');
INSERT INTO departament (id, departament_nom)
VALUES(5, 'Ciencies');


INSERT INTO tecnics (nom) VALUES ('Tècnic 1');
INSERT INTO tecnics (nom) VALUES ('Tècnic 2');
INSERT INTO tecnics (nom) VALUES ('Tècnic 3');
INSERT INTO tecnics (nom) VALUES ('Tècnic 4');
INSERT INTO tecnics (nom) VALUES ('Tècnic 5');




    insert into incidencies (departament_id, data_obertura, descripcio, tecnic_id, prioritat, resolta, data_tancament, tipus)
    values (1, '2024-01-15 10:00:00', 'Problema amb el projector de la sala de conferències', 1, 'Alta', 0, NULL, 'Hardware');
    insert into incidencies (departament_id, data_obertura, descripcio, tecnic_id, prioritat, resolta, data_tancament, tipus)
    values (2, '2024-01-16 14:30:00', 'El programari de gestió de notes no funciona correctament', 2, 'Mitja', 0, NULL, 'Software');
    insert into incidencies (departament_id, data_obertura, descripcio, tecnic_id, prioritat, resolta, data_tancament, tipus)
    values (3, '2024-01-17 09:15:00', 'Problema de connexió a la xarxa Wi-Fi del departament', 3, 'Baixa', 0, NULL, 'Xarxa');
    insert into incidencies (departament_id, data_obertura, descripcio, tecnic_id, prioritat, resolta, data_tancament, tipus)
    values (4, '2024-01-18 11:45:00', 'El sistema de videoconferència no funciona', 4, 'Alta', 0, NULL, 'Hardware');
    insert into incidencies (departament_id, data_obertura, descripcio, tecnic_id, prioritat, resolta, data_tancament, tipus)
    values (5, '2024-01-19 13:20:00', 'Problema amb el sistema de correu electrònic del departament', 5, 'Mitja', 0, NULL, 'Software');