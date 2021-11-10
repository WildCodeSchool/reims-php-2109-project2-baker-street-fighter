
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
--
-- Base de données :  `baker street fighter`
--

-- --------------------------------------------------------
DROP DATABASE IF EXISTS baker_street_fighter;

CREATE DATABASE baker_street_fighter;
USE baker_street_fighter;

CREATE TABLE fighter (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(80) NOT NULL,
    attack INT NOT NULL,
    defense INT NOT NULL,
    image VARCHAR(80),
    PRIMARY KEY (id)
);
CREATE TABLE fight(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    winner INT UNSIGNED NOT NULL,
    PRIMARY KEY (id)
);
CREATE TABLE participation (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    fight_id INT UNSIGNED,
    CONSTRAINT fk_fight_id
        FOREIGN KEY (fight_id) 
        REFERENCES fight(id),
    fighter_id INT UNSIGNED,
    PRIMARY KEY (id),
    CONSTRAINT fk_fighter_id
        FOREIGN KEY (fighter_id) 
        REFERENCES fighter(id)
);

INSERT INTO fighter (name, attack, defense, image)
VALUES ('Sherlock', 20, 20, "");

INSERT INTO fighter (name, attack, defense, image)
VALUES ('Moriarty', 35, 5, "");

INSERT INTO fighter (name, attack, defense, image)
VALUES ('Enola', 30, 10, "");
