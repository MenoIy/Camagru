DROP DATABASE IF EXISTS `db_camagru`;
CREATE DATABASE IF NOT EXISTS `db_camagru`;
use db_camagru;
CREATE TABLE camagru_users (user_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, user_login varchar(24), user_mail varchar(255), user_password varchar(255), account_status varchar(255));
CREATE TABLE camagru_account (user_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, account_login varchar(24), account_mail varchar(255), account_token varchar(255));