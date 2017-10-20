/*
Created		11.04.2017
Modified		20.10.2017
Project		
Model		
Company		
Author		
Version		
Database		mySQL 5 
*/


drop table IF EXISTS lekarz_urlopy;
drop table IF EXISTS lekarz_godz_przyj;
drop table IF EXISTS godz_przyj;
drop table IF EXISTS lekarz_specjalizacja;
drop table IF EXISTS specializacja;
drop table IF EXISTS wizyta_leki;
drop table IF EXISTS wizyta;
drop table IF EXISTS leki;
drop table IF EXISTS pacjent;
drop table IF EXISTS lekarz;


Create table lekarz (
	id_lekarz Int NOT NULL,
	imie Char(50) NOT NULL,
	nazwisko Char(50) NOT NULL,
	tytul Char(50),
	UNIQUE (id_lekarz),
 Primary Key (id_lekarz)) ENGINE = MyISAM;

Create table pacjent (
	id_pacjent Int NOT NULL,
	PESEL Bigint NOT NULL,
	imie Char(50) NOT NULL,
	nazwisko Char(50) NOT NULL,
	miasto Char(50),
	ulica Char(50),
	numer Char(50),
	UNIQUE (id_pacjent),
	UNIQUE (PESEL),
 Primary Key (id_pacjent)) ENGINE = MyISAM;

Create table leki (
	id_lek Int NOT NULL,
	nazwa Char(50) NOT NULL,
	producent Char(50) NOT NULL,
	zastosowanie Text,
	UNIQUE (id_lek),
 Primary Key (id_lek)) ENGINE = MyISAM;

Create table wizyta (
	id_wizyta Int NOT NULL,
	indeks Char(20) NOT NULL,
	id_pacjent Int NOT NULL,
	id_godz Int NOT NULL,
	data_wizyty Date NOT NULL,
	diagnoza Text,
	UNIQUE (id_wizyta),
 Primary Key (id_wizyta)) ENGINE = MyISAM;

Create table wizyta_leki (
	id_wizyta Int NOT NULL,
	id_lek Int NOT NULL,
 Primary Key (id_wizyta,id_lek)) ENGINE = MyISAM;

Create table specializacja (
	id_specjalizacja Int NOT NULL,
	nazwa Char(50) NOT NULL,
	UNIQUE (id_specjalizacja),
 Primary Key (id_specjalizacja)) ENGINE = MyISAM;

Create table lekarz_specjalizacja (
	id_lekarz Int NOT NULL,
	id_specjalizacja Int NOT NULL,
 Primary Key (id_lekarz,id_specjalizacja)) ENGINE = MyISAM;

Create table godz_przyj (
	id_godz_przyj Int NOT NULL,
	godz_pocz Time NOT NULL,
	godz_koniec Time NOT NULL,
	UNIQUE (id_godz_przyj),
 Primary Key (id_godz_przyj)) ENGINE = MyISAM;

Create table lekarz_godz_przyj (
	id_godz Int NOT NULL,
	id_godz_przyj Int NOT NULL,
	id_lekarz Int NOT NULL,
	UNIQUE (id_godz),
 Primary Key (id_godz)) ENGINE = MyISAM;

Create table lekarz_urlopy (
	id_data Int NOT NULL,
	data_urlop Date NOT NULL,
	id_lekarz Int NOT NULL,
	UNIQUE (id_data),
 Primary Key (id_data)) ENGINE = MyISAM;


ALTER TABLE wizyta ADD CONSTRAINT dataNieUrlop CHECK ((SELECT data_urlop FROM lekarz_urlopy WHERE (wizyta.id_lekarz=lekarz_urlopy.id_lekarz AND wizyta.data_wizyty=lekarz_urlopy.data_urlop)) IS NULL);
ALTER TABLE lekarz_urlopy ADD CONSTRAINT dataNieUrlopTwo CHECK ((SELECT data_wizyty FROM wizyta WHERE (wizyta.id_lekarz=lekarz_urlopy.id_lekarz AND wizyta.data_wizyty=lekarz_urlopy.data_urlop)) IS NULL);
ALTER TABLE godz_przyj ADD CONSTRAINT sprawdzGodz CHECK (godz_pocz < godz_koniec);
ALTER TABLE godz_przyj ADD CONSTRAINT chkGodz CHECK (godz_pocz < godz_koniec);


Alter table lekarz_specjalizacja add Foreign Key (id_lekarz) references lekarz (id_lekarz) on delete  restrict on update  restrict;
Alter table lekarz_godz_przyj add Foreign Key (id_lekarz) references lekarz (id_lekarz) on delete  restrict on update  restrict;
Alter table lekarz_urlopy add Foreign Key (id_lekarz) references lekarz (id_lekarz) on delete  restrict on update  restrict;
Alter table wizyta add Foreign Key (id_pacjent) references pacjent (id_pacjent) on delete  restrict on update  restrict;
Alter table wizyta_leki add Foreign Key (id_lek) references leki (id_lek) on delete  restrict on update  restrict;
Alter table wizyta_leki add Foreign Key (id_wizyta) references wizyta (id_wizyta) on delete  restrict on update  restrict;
Alter table lekarz_specjalizacja add Foreign Key (id_specjalizacja) references specializacja (id_specjalizacja) on delete  restrict on update  restrict;
Alter table lekarz_godz_przyj add Foreign Key (id_godz_przyj) references godz_przyj (id_godz_przyj) on delete  restrict on update  restrict;
Alter table wizyta add Foreign Key (id_godz) references lekarz_godz_przyj (id_godz) on delete  restrict on update  restrict;


/* Users permissions */


