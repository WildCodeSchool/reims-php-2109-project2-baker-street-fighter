-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 26 Octobre 2017 à 13:53
-- Version du serveur :  5.7.19-0ubuntu0.16.04.1
-- Version de PHP :  7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `simple-mvc`
--

-- --------------------------------------------------------

CREATE DATABASE baker_street_fighter;

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
    date TIMESTAMP,
    winner INT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE participation (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    fight_id INT,
    fighter_id INT,
    PRIMARY KEY (id)
);

ALTER TABLE participation
ADD CONSTRAINT fight_id
FOREIGN KEY (fight_id) 
REFERENCES fight(id);

ALTER TABLE participation
ADD CONSTRAINT fighter_id
FOREIGN KEY (fighter_id) 
REFERENCES fighter(id);
