DROP DATABASE IF EXISTS [MeteoAnalysisDatabase];
CREATE DATABASE IF NOT EXISTS [MeteoAnalysisDatabase];
USE [MeteoAnalysisDatabase];
DROP TABLE IF EXISTS [MeteoAnalysisDatabase];

create table Administratorzy
(PRIMARY KEY(AdminID),
login TINYTEXT,
haslo TINYTEXT,
imie TINYTEXT,
nazwisko TINYTEXT,
e_mail TINYTEXT);

create table Analitycy
(PRIMARY KEY(AnalystID),
login TINYTEXT,
haslo TINYTEXT,
imie TINYTEXT,
nazwisko TINYTEXT,
e_mail TINYTEXT);

create table StacjePogodowe
(PRIMARY KEY(StationsID),
NazwaStacjiPogodowej VARCHAR(15), #FK
PolozenieStacji INT, #FK
AutomatycznyKomentarz TEXT,
KomentarzAnalityka TEXT);

create table Polozenie
(PRIMARY KEY(LocationID),
SzerokoscGeograficzna VARCHAR(8),
DlugoscGeograficzna VARCHAR(8),
Wysokosc VARCHAR(4));

create table StacjaPogodowa
(PRIMARY KEY(MeteoStationID),
DataPomiaru DATE,
GodzinaPomiaru TIME,
TemperaturaSrednia FLOAT(3,1),
Wilgotnosc FLOAT(3,1),
WiatrPredkosc FLOAT(3,1),
Cisnienie FLOAT(5,1),
Opady FLOAT(3,1),
ZachmurzenieCalkowite FLOAT(2,1),
Widocznosc FLOAT(3,1));

create table Zachmurzenie
(PRIMARY KEY(CloudsID),
Calkowite FLOAT(2,1),
Dolne FLOAT(2,1));

create table Wiatr
(PRIMARY KEY(WindID),
Kierunek VARCHAR(4),
Predkosc FLOAT(3,1),
Porywy FLOAT(3,1));

create table Tempteratura
(PRIMARY KEY(TemperatureID),
minimalna FLOAT(3,1),
srednia FLOAT(3,1),
maksymalna FLOAT(3,1));