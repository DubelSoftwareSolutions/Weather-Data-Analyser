DROP DATABASE IF EXISTS [MeteoAnalysisDatabase];
CREATE DATABASE IF NOT EXISTS [MeteoAnalysisDatabase];
USE [MeteoAnalysisDatabase];
DROP TABLE IF EXISTS [MeteoAnalysisDatabase];

create table StacjePogodowe
(StationsID INT,
AutomatycznyKomentarz TEXT,
KomentarzAnalityka TEXT);

create table StacjaPogodowa
(MeteoStationID VARCHAR(15),
DataPomiaru DATE(),
GodzinaPomiaru TIME(),
Wilgotnosc FLOAT(3,1),
Cisnienie FLOAT(5,1),
Opady FLOAT(3,1),
Widocznosc FLOAT(3,1));

create table Administratorzy
(AdminID INT,
login TINYTEXT,
haslo TINYTEXT,
imie TINYTEXT,
nazwisko TINYTEXT,
e_mail TINYTEXT);

create table Analitycy
(AnalystID INT,
login TINYTEXT,
haslo TINYTEXT,
imie TINYTEXT,
nazwisko TINYTEXT,
e_mail TINYTEXT);

create table