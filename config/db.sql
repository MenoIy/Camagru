DROP DATABASE IF EXISTS `db_camagru`;
CREATE DATABASE IF NOT EXISTS `db_camagru`;

USE `db_camagru`;

CREATE TABLE `likes`
(
    `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `user` varchar(24) NOT NULL,
    `filename` varchar(255) NOT NULL
);

CREATE TABLE camagru_users
(
    `user_id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `user_login` varchar(24),
    `user_mail` varchar(255),
    `user_password` varchar(255),
    `notification` varchar(10),
    `account_status` varchar(15)
);

CREATE TABLE camagru_account
(
    `user_id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `account_login` varchar(24),
    `account_mail` varchar(255),
    `account_token` varchar(255)
);
/* FOREIGN KEY REFERENCES `camagru_users`(`user_id`) ON DELETE CASCADE*/
CREATE TABLE images
(
    `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `user` varchar(24) NOT NULL,
    `filename` varchar(255) NOT NULL
);
CREATE TABLE comments
(
    `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `comment` varchar(500) NOT NULL,
    `user` varchar(24) NOT NULL,
    `filename` varchar(255) NOT NULL
);
