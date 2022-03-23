
CREATE DATABASE IF NOT EXISTS task_force
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;

USE task_force;

--
-- Структурная таблица "Города и локации"
--

CREATE TABLE city (
	id INT NOT NULL AUTO_INCREMENT,
	name varchar(168) NOT NULL,
	latitude FLOAT NOT NULL,
	longitude FLOAT NOT NULL,
	PRIMARY KEY (id)
);

--
-- Структурная таблица "Личный кабинет"
--

CREATE TABLE user (
	id INT NOT NULL AUTO_INCREMENT,
	date_add TIMESTAMP NOT NULL,
	name varchar(128) NOT NULL,
	email varchar(128) NOT NULL,
	password varchar(255) NOT NULL,
	city_id INT NOT NULL,
	role_employee BOOLEAN NOT NULL,
	phone varchar(64) NOT NULL UNIQUE,
	telegram varchar(64) NOT NULL UNIQUE,
	info varchar NOT NULL,
	date_birth DATE NOT NULL,
	avatar_path varchar(255) NOT NULL UNIQUE,
	last_time_online DATETIME NOT NULL,
	PRIMARY KEY (id),
    FOREIGN KEY (city_id) REFERENCES city(id)
);

--
-- Структурная таблица "Категории работ"
--

CREATE TABLE categories (
	id INT NOT NULL AUTO_INCREMENT,
	title varchar(128) NOT NULL,
	PRIMARY KEY (id)
);

--
-- Структурная таблица "Категории работ исполнителя"
--

CREATE TABLE categories_user (
	id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	category_id INT NOT NULL,
	PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

--
-- Структурная таблица "Портфолио работ исполнителя"
--

CREATE TABLE portfolio (
	id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	path varchar(255) NOT NULL UNIQUE,
	PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES user(id)
);

--
-- Структурная таблица "Отзывы"
--

CREATE TABLE reviews (
	id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	task_id INT NOT NULL,
	date_add TIMESTAMP NOT NULL,
	customer_id INT NOT NULL,
	rating INT(1) NOT NULL,
	comment varchar(255) NOT NULL,
	PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (task_id) REFERENCES task(id)
);

--
-- Структурная таблица "Задание"
--

CREATE TABLE task (
	id INT NOT NULL AUTO_INCREMENT,
	date_add TIMESTAMP NOT NULL,
	title varchar(128) NOT NULL UNIQUE,
	price INT(10) NOT NULL,
	category_id INT(10) NOT NULL,
	city_id INT(10) NOT NULL,
	comment varchar(255) NOT NULL,
	term DATETIME NOT NULL,
	status_id INT NOT NULL,
	PRIMARY KEY (id),
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (city_id) REFERENCES city(id),
    FOREIGN KEY (status_id) REFERENCES task_status(id)
);

--
-- Структурная таблица "Статус задания"
--

CREATE TABLE task_status (
	id INT NOT NULL AUTO_INCREMENT,
	title varchar(64) NOT NULL,
	code varchar(64) NOT NULL,
	PRIMARY KEY (id)
);

--
-- Структурная таблица "Отклик на задание"
--

CREATE TABLE response (
	id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	sender_id INT NOT NULL,
	date_add TIMESTAMP NOT NULL,
	task_id INT NOT NULL,
	price INT NOT NULL,
	message varchar(255) NOT NULL,
	read_status BOOLEAN NOT NULL DEFAULT '0',
	PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (task_id) REFERENCES task(id),
    FOREIGN KEY (task_id) REFERENCES task(id)
);

--
-- Структурная таблица "Файлы к заданию"
--

CREATE TABLE task_files (
	id INT NOT NULL AUTO_INCREMENT,
	task_id INT NOT NULL,
	PRIMARY KEY (id)
);
