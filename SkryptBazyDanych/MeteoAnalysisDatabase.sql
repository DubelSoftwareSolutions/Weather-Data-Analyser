DROP DATABASE IF EXISTS MeteoAnalysisDatabase;
CREATE DATABASE IF NOT EXISTS MeteoAnalysisDatabase;
USE MeteoAnalysisDatabase;
DROP TABLE IF EXISTS MeteoAnalysisDatabase;

create table Administratorzy
(PRIMARY KEY(AdminID),
AdminID INT,
login TINYTEXT,
haslo TINYTEXT,
imie TINYTEXT,
nazwisko TINYTEXT,
e_mail TINYTEXT);

create table Analitycy
(PRIMARY KEY(AnalystID),
AnalystID INT,
login TINYTEXT,
haslo TINYTEXT,
imie TINYTEXT,
nazwisko TINYTEXT,
e_mail TINYTEXT);

create table StacjePogodowe
(PRIMARY KEY(StationID),
StationID INT,
NazwaStacjiPogodowej VARCHAR(15),
AutomatycznyKomentarz TEXT,
KomentarzAnalityka TEXT,
AnalystID INT,
foreign key (AnalystID) references Analitycy(AnalystID) ON UPDATE CASCADE ON DELETE RESTRICT);

create table Polozenie
(PRIMARY KEY(LocationID),
LocationID INT,
SzerokoscGeograficzna VARCHAR(8),
DlugoscGeograficzna VARCHAR(8),
Wysokosc VARCHAR(4),
StationID INT,
foreign key (StationID) references StacjePogodowe(StationID) ON UPDATE CASCADE ON DELETE RESTRICT);

create table Pomiary
(PRIMARY KEY(MeasurementID),
MeasurementID INT,
DataPomiaru DATE,
GodzinaPomiaru TIME,
KodPomiaru VARCHAR(5),
WartoscPomiaru FLOAT(5,1),
StationID INT,
foreign key (StationID) references StacjePogodowe(StationID) ON UPDATE CASCADE ON DELETE RESTRICT);