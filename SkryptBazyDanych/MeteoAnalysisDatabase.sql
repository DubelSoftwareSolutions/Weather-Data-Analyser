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
KomentarzAnalityka TEXT);

create table Polozenie
(PRIMARY KEY(LocationID),
LocationID INT,
SzerokoscGeograficzna VARCHAR(8),
DlugoscGeograficzna VARCHAR(8),
Wysokosc VARCHAR(4),
StationID INT,
foreign key (StationID) references StacjePogodowe(StationID) ON UPDATE CASCADE ON DELETE RESTRICT);

create table PomiaryPodstawowe
(PRIMARY KEY(MeasurementID),
MeasurementID INT,
DataPomiaru DATE,
GodzinaPomiaru TIME,
Wilgotnosc FLOAT(3,1),
Cisnienie FLOAT(5,1),
Opady FLOAT(3,1),
Widocznosc FLOAT(3,1),
StationID INT,
foreign key (StationID) references StacjePogodowe(StationID) ON UPDATE CASCADE ON DELETE RESTRICT);

create table Zachmurzenie
(PRIMARY KEY(CloudID),
CloudID INT,
Calkowite FLOAT(2,1),
Dolne FLOAT(2,1),
MeaserementID INT,
StationID INT,
foreign key (MeaserementID) references PomiaryPodstawowe(MeasurementID) ON UPDATE CASCADE ON DELETE RESTRICT,
foreign key (StationID) references StacjePogodowe(StationID) ON UPDATE CASCADE ON DELETE RESTRICT);

create table Wiatr
(PRIMARY KEY(WindID),
WindID INT,
Kierunek VARCHAR(4),
Predkosc FLOAT(3,1),
Porywy FLOAT(3,1),
MeaserementID INT,
StationID INT,
foreign key (MeaserementID) references PomiaryPodstawowe(MeasurementID) ON UPDATE CASCADE ON DELETE RESTRICT,
foreign key (StationID) references StacjePogodowe(StationID) ON UPDATE CASCADE ON DELETE RESTRICT);

create table Tempteratura
(PRIMARY KEY(TemperatureID),
TemperatureID INT,
minimalna FLOAT(3,1),
srednia FLOAT(3,1),
maksymalna FLOAT(3,1),
MeaserementID INT,
StationID INT,
foreign key (MeaserementID) references PomiaryPodstawowe(MeasurementID) ON UPDATE CASCADE ON DELETE RESTRICT,
foreign key (StationID) references StacjePogodowe(StationID) ON UPDATE CASCADE ON DELETE RESTRICT);