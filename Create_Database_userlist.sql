#DROP DATABASE userlist;

### Createfile for the userlist database ###
### Last Updated 2022.06 by Nico Braun ###

#Create Database
CREATE DATABASE userlist CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE userlist;

#Create User
CREATE USER "userlister"@"localhost";
GRANT SELECT, INSERT, UPDATE, DELETE ON userlist.* TO "userlister"@"localhost";

#Create Backup User
CREATE USER 'backuptyp'@'localhost' IDENTIFIED BY 'sehrsicherundso1';
GRANT SELECT, LOCK TABLES, SHOW VIEW, RELOAD, PROCESS ON *.* TO 'backuptyp'@'localhost';

#Create Table 'CreateUser'
CREATE TABLE createuser (
	idUser bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
	shorty VARCHAR(45),
	name VARCHAR(40) NOT NULL,
	surname VARCHAR(40) NOT NULL,
	number VARCHAR(20) UNIQUE,
	workfunction VARCHAR(80) NOT NULL,
	example VARCHAR(45) NOT NULL,
	location VARCHAR(25) NOT NULL,
	workstart VARCHAR(20) NOT NULL,
	needswinuser VARCHAR(3),
	winexample VARCHAR(45),
	winextra TEXT,
	needsmailuser VARCHAR(3),
	email VARCHAR(60),
	mailgroups TEXT,
	needssap VARCHAR(3),
	sapprinter VARCHAR(25),
	needscrm VARCHAR(3),
	needsfsm VARCHAR(3),
	needstelintern VARCHAR(3),
	telintern VARCHAR(35),
	needstelmobile VARCHAR(3),
	telmobile VARCHAR(35),
	newhardware VARCHAR(3),
	oldhardwarename VARCHAR(40),
	oldhardwareserial VARCHAR(50),
	comment TEXT,
	sappassword VARCHAR(70),
	employment VARCHAR(50) NOT NULL
);
#Create Table 'AdminUsers'
CREATE TABLE adminusers (
	idAdminUser BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(25) NOT NULL UNIQUE,
  password VARCHAR(50) NOT NULL,
  name VARCHAR(40) NOT NULL,
  level TINYINT NOT NULL
);

#Create initial adminuser
INSERT INTO adminusers (username, name, password, level) VALUES ('admin', 'Administrierender Administrator', MD5('banana!'), 10);

#Create Table 'CreateCheck'
CREATE TABLE createcheck (
  idCreate bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
  createdate VARCHAR(20) NOT NULL,
  finishdate VARCHAR(20),
  checkADCreate VARCHAR(3),
  checkADMod VARCHAR(3),
  checkNotesCreate VARCHAR(3),
  checkNotesMod VARCHAR(3),
  checkTelCreate VARCHAR(3),
  checkIQSCreate VARCHAR(3),
  checkWACreate VARCHAR(3),
  checkHWSWCreate VARCHAR(3),
  checkWelcomeCreate VARCHAR(3),
  comment TEXT,
	fkIdUser BIGINT NOT NULL UNIQUE,
  fkIdAdminusers BIGINT NOT NULL,
	FOREIGN KEY (fkIdUser) REFERENCES createuser(idUser),
  FOREIGN KEY (fkIdAdminusers) REFERENCES adminusers(idAdminUser)
  ON DELETE NO ACTION ON UPDATE NO ACTION
);

#Create Table 'DeleteCheck'
CREATE TABLE deletecheck (
	idDelete bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
	createdate VARCHAR(20) NOT NULL,
  finishdate VARCHAR(20),
  checkADDelete VARCHAR(3),
  checkNotesDelete VARCHAR(3),
  checkTelDelete VARCHAR(3),
  checkIQSDelete VARCHAR(3),
  checkWADelete VARCHAR(3),
  checkHWSWDelete VARCHAR(3),
  comment TEXT,
  fkIdUser BIGINT NOT NULL UNIQUE,
  fkIdAdminusers BIGINT NOT NULL,
	FOREIGN KEY (fkIdUser) REFERENCES createuser(idUser),
  FOREIGN KEY (fkIdAdminusers) REFERENCES adminusers(idAdminUser)
	ON DELETE NO ACTION ON UPDATE NO ACTION
);

#Create Table 'history'
CREATE TABLE history (
	idHistory BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(40) NOT NULL,
	surname VARCHAR(30),
	username VARCHAR(30),
	moddate VARCHAR(20),
	comment TEXT,
	typeEntry INT NOT NULL,
	idEntry BIGINT NOT NULL
);

#Create Table 'maillist'
CREATE TABLE maillist (
	idMaillist bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(60) NOT NULL,
  mailgroup TINYINT NOT NULL
);
