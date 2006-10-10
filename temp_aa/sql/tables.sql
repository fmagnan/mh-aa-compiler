CREATE TABLE mountyhall_troll (
	numero INT(5) NOT NULL,
	nom VARCHAR(50) NOT NULL,
	race ENUM('Inconnue', 'Durakuir', 'Kastar', 'Skrim', 'Tomawak') NOT NULL,
	numero_guilde INT(5) NOT NULL,
	guilde VARCHAR(50) NOT NULL,
	niveau int NOT NULL,
	vie VARCHAR(20) NOT NULL,
	attaque VARCHAR(20) NOT NULL,
	esquive VARCHAR(20) NOT NULL,
	degats VARCHAR(20) NOT NULL,
	regeneration VARCHAR(20) NOT NULL,
	armure VARCHAR(20) NOT NULL,
	vue VARCHAR(20) NOT NULL,
	date_compilation DATETIME NOT NULL,
	sortileges TINYTEXT DEFAULT '',
	PRIMARY KEY (numero, nom, race)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;