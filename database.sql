CREATE DATABASE IF NOT EXISTS bonheur_et_paillettes;

USE bonheur_et_paillettes;

CREATE TABLE
    IF NOT EXISTS user (
        id INT NOT NULL AUTO_INCREMENT,
        firstName VARCHAR(45) NOT NULL,
        lastName VARCHAR(45) NOT NULL,
        nickName VARCHAR(45) NOT NULL UNIQUE,
        passWord VARCHAR(255) NOT NULL,
        email VARCHAR(45) NOT NULL UNIQUE,
        avatar VARCHAR(100) DEFAULT 'avatar.png',
        description VARCHAR(255),
        score INT DEFAULT 0,
        PRIMARY KEY(id)
    );

CREATE TABLE
    IF NOT EXISTS unicorn(
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(45) NOT NULL UNIQUE,
        avatar VARCHAR(100),
        score INT,
        fights INT,
        wonFights INT,
        lostFights INT,
        koFights INT,
        PRIMARY KEY(id)
    );

CREATE TABLE
    IF NOT EXISTS attack(
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(45) NOT NULL UNIQUE,
        avatar VARCHAR(100),
        cost INT,
        gain INT,
        successRate INT,
        PRIMARY KEY(id)
    );

CREATE TABLE
    IF NOT EXISTS unicorn_attack(
        unicorn_id INT NOT NULL,
        attack_id INT NOT NULL,
        INDEX uni_att (unicorn_id, attack_id),
        FOREIGN KEY (unicorn_Id) REFERENCES unicorn(id) ON DELETE CASCADE,
        FOREIGN KEY (attack_Id) REFERENCES attack(id) ON DELETE CASCADE
    );

INSERT INTO
    unicorn (
        name,
        avatar,
        score,
        fights,
        wonFights,
        lostFights,
        koFights
    )
VALUES (
        'Allena',
        'allena.png',
        100,
        0,
        0,
        0,
        0
    ), (
        'Larissa',
        'larissa.png',
        100,
        0,
        0,
        0,
        0
    ), (
        'Suki',
        'suki.png',
        100,
        0,
        0,
        0,
        0
    );

INSERT INTO
    attack (
        name,
        avatar,
        cost,
        gain,
        successRate
    )
VALUES (
        'Etoiles filantes',
        'star.png',
        2,
        4,
        90
    ), (
        'Cabrage',
        'cabrage.png',
        4,
        10,
        70
    ), ('Bisou', 'kiss.png', 8, 24, 30), (
        'Clin d\'oeil',
        'wink.png',
        3,
        6,
        75
    ), (
        'Malice',
        'malice.png',
        5,
        15,
        60
    ), ('Câlin', 'hug.png', 7, 20, 40);

INSERT INTO
    unicorn_attack (unicorn_id, attack_id)
VALUES (1, 1), (1, 2), (1, 3), (2, 4), (2, 5), (2, 3), (3, 1), (3, 6), (3, 3);

DROP TABLE unicorn;

DROP TABLE unicorn_attack;

DROP TABLE attack;