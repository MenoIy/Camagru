DROP DATABASE IF EXISTS `db_camagru`;
CREATE DATABASE IF NOT EXISTS `db_camagru`;

USE `db_camagru`;

CREATE TABLE `likes`
(
    `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `user` varchar(24) NOT NULL,
    `filename` varchar(255) NOT NULL
);

CREATE TABLE `users`
(
    `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `user` varchar(24),
    `mail` varchar(255),
    `password` varchar(255),
    `notification` varchar(10),
    `status` varchar(10)
);

CREATE TABLE `accounts`
(
    `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `user` varchar(24),
    `mail` varchar(255),
    `token` varchar(255)
);

CREATE TABLE `images`
(
    `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `user` varchar(24) NOT NULL,
    `filename` varchar(255) NOT NULL,
    `time` INT NOT NULL
);

CREATE TABLE `comments`
(
    `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `comment` varchar(500) NOT NULL,
    `user` varchar(24) NOT NULL,
    `filename` varchar(255) NOT NULL
);
