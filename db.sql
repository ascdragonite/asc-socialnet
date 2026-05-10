CREATE DATABASE IF NOT EXISTS socialnet;
USE socialnet;

CREATE TABLE IF NOT EXISTS account ( 
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(50) UNIQUE,
	fullname VARCHAR(100),
	password VARCHAR(255),
	description TEXT 
);

CREATE USER IF NOT EXISTS 'socialadmin'@'localhost' IDENTIFIED BY 'password149';
GRANT ALL PRIVILEGES ON socialnet.* TO 'socialadmin'@'localhost';
FLUSH PRIVILEGES;

