DROP DATABASE IF EXISTS MeteoAnalysisDatabase;
CREATE DATABASE IF NOT EXISTS MeteoAnalysisDatabase;
USE MeteoAnalysisDatabase;
DROP TABLE IF EXISTS MeteoAnalysisDatabase;

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
(PRIMARY KEY(StationID),
NazwaStacjiPogodowej VARCHAR(15),
AutomatycznyKomentarz TEXT,
KomentarzAnalityka TEXT);

create table Polozenie
(PRIMARY KEY(LocationID),
SzerokoscGeograficzna VARCHAR(8),
DlugoscGeograficzna VARCHAR(8),
Wysokosc VARCHAR(4),
foreign key (StationID) references StacjePogodowe(StationID));

create table PomiaryPodstawowe
(PRIMARY KEY(MeasurementID),
DataPomiaru DATE,
GodzinaPomiaru TIME,
Wilgotnosc FLOAT(3,1),
Cisnienie FLOAT(5,1),
Opady FLOAT(3,1),
Widocznosc FLOAT(3,1),
foreign key (TemperaturaSrednia) references Temperatura(srednia),
foreign key (WiatrPredkosc) references Wiatr(Predkosc),
foreign key (ZachmurzenieCalkowite) references Zachmurzenie(Calkowite),
foreign key (StationID) references StacjePogodowe(StationID));

create table Zachmurzenie
(PRIMARY KEY(CloudID),
Calkowite FLOAT(2,1),
Dolne FLOAT(2,1),
foreign key (MeaserementID) references PomiaryPodstawowe(MeasurementID),
foreign key (StationID) references StacjePogodowe(StationID));

create table Wiatr
(PRIMARY KEY(WindID),
Kierunek VARCHAR(4),
Predkosc FLOAT(3,1),
Porywy FLOAT(3,1),
foreign key (MeaserementID) references PomiaryPodstawowe(MeasurementID),
foreign key (StationID) references StacjePogodowe(StationID));

create table Tempteratura
(PRIMARY KEY(TemperatureID),
minimalna FLOAT(3,1),
srednia FLOAT(3,1),
maksymalna FLOAT(3,1),
foreign key (MeaserementID) references PomiaryPodstawowe(MeasurementID),
foreign key (StationID) references StacjePogodowe(StationID));