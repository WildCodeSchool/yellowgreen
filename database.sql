CREATE DATABASE IF NOT EXISTS bonheur_et_paillettes;

USE bonheur_et_paillettes;

CREATE TABLE
    IF NOT EXISTS user (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(45) NOT NULL UNIQUE,
        email VARCHAR(45),
        avatar VARCHAR(100),
        description VARCHAR(100),
        score INT,
        PRIMARY KEY(id)
    );

CREATE TABLE
    IF NOT EXISTS unicorne(
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(45) NOT NULL UNIQUE,
        email VARCHAR(45),
        avatar VARCHAR(100),
        score INT,
        fights INT,
        won_fights INT,
        lost_fights INT,
        ko_fights INT,
        PRIMARY KEY(id)
    );

CREATE TABLE
    IF NOT EXISTS attack (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(45) NOT NULL UNIQUE,
        avatar VARCHAR(100),
        cost INT,
        gain INT,
        succes_rate FLOAT,
        PRIMARY KEY(id)
    );

CREATE TABLE
    IF NOT EXISTS unicorne_attack(
        unicorne_id INT NOT NULL,
        attack_id INT NOT NULL,
        INDEX uni_att (unicorne_id, attack_id),
        FOREIGN KEY (unicorne_Id) REFERENCES unicorne(id) ON DELETE CASCADE,
        FOREIGN KEY (attack_Id) REFERENCES attack(id) ON DELETE CASCADE
    );