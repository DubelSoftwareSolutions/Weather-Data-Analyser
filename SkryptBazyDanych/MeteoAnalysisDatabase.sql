SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

DROP DATABASE if exists AnalizaDanychPogodowych;
CREATE DATABASE AnalizaDanychPogodowych;
use AnalizaDanychPogodowych;

create table if not exists `Administratorzy`
(PRIMARY KEY(`AdminID`),
`AdminID` INT AUTO_INCREMENT,
`login` TINYTEXT,
`haslo` TINYTEXT,
`imie` TINYTEXT,
`nazwisko` TINYTEXT,
`e_mail` TINYTEXT);

create table if not exists `Analitycy`
(PRIMARY KEY(`AnalystID`),
`AnalystID` INT AUTO_INCREMENT,
`login` TINYTEXT,
`haslo` TINYTEXT,
`imie` TINYTEXT,
`nazwisko` TINYTEXT,
`e_mail` TINYTEXT);

create table if not exists `StacjePogodowe`
(PRIMARY KEY(`StationID`),
`StationID` INT AUTO_INCREMENT,
`NazwaStacjiPogodowej` VARCHAR(15),
`AutomatycznyKomentarz` TEXT,
`KomentarzAnalityka` TEXT,
`AnalystID` INT,
foreign key (`AnalystID`) references `Analitycy`(`AnalystID`) ON UPDATE CASCADE ON DELETE RESTRICT);

create table if not exists `Polozenie`
(PRIMARY KEY(`LocationID`),
`LocationID` INT AUTO_INCREMENT,
`SzerokoscGeograficzna` VARCHAR(8),
`DlugoscGeograficzna` VARCHAR(8),
`Wysokosc` VARCHAR(4),
`StationID` INT,
foreign key (`StationID`) references `StacjePogodowe`(`StationID`) ON UPDATE CASCADE ON DELETE RESTRICT);

create table if not exists `Pomiary`
(PRIMARY KEY(`MeasurementID`),
`MeasurementID` INT AUTO_INCREMENT,
`DateStationID` INT,
`DataPomiaru` DATE,
`GodzinaPomiaru` TIME,
`KodPomiaru` VARCHAR(5),
`WartoscPomiaru` FLOAT(5,1),
`StationID` INT,
foreign key (`StationID`) references `StacjePogodowe`(`StationID`) ON UPDATE CASCADE ON DELETE RESTRICT);

insert into `Administratorzy` (`AdminID`,`login`,`haslo`,`imie`,`nazwisko`,`e_mail`) values
(0,'piernik','piernik1','Dymitr','Choroszczak','218627@student.pwr.edu.pl'),
(1,'bulek','bulek1','Krzysztof','Dabek','218549@student.pwr.edu.pl');

insert into `Analitycy` (`AnalystID`,`login`,`haslo`,`imie`,`nazwisko`,`e_mail`) values
(0,'analityk0','password0','Jozef','Pilsudski','dyktator@gmail.com'),
(1,'analityk1','password1','Boleslaw','Prus','lalkaftw@gmail.com');

DELIMITER ;;
CREATE PROCEDURE GetAdminInfo(in p_login TINYTEXT, IN p_password TINYTEXT)
BEGIN
SELECT * FROM Administratorzy WHERE login=p_login AND haslo=p_password;
END ;;

DELIMITER ;;
CREATE PROCEDURE GetAnalystInfo(in p_login TINYTEXT, IN p_password TINYTEXT)
BEGIN
SELECT * FROM Analitycy WHERE login=p_login AND haslo=p_password;
END ;;

DELIMITER ;;
CREATE PROCEDURE GetAnalystInfoID(in p_analystID INT)
BEGIN
SELECT * FROM Analitycy WHERE login=p_login AND haslo=p_password;
END ;;

DELIMITER ;;
CREATE PROCEDURE DeleteStation(in p_stationID INT)
BEGIN
    DELETE FROM `Pomiary` WHERE `StationID`=p_stationID; 
    DELETE FROM `Polozenie` WHERE `StationID`=p_stationID;
	DELETE FROM `StacjePogodowe` WHERE `StationID`=p_stationID;
END ;;

DELIMITER ;;
CREATE PROCEDURE GetAllStations()
BEGIN
    SELECT * FROM stacjepogodowe where 1;
END ;;

DELIMITER ;;
CREATE PROCEDURE GetStationName(p_stationID int)
BEGIN
    SELECT `NazwaStacjiPogodowej` FROM `stacjepogodowe` WHERE `StationID`=p_stationID;
END ;;

DELIMITER ;;
CREATE PROCEDURE GetStationLocation(p_stationID int)
BEGIN
    SELECT * FROM `polozenie` WHERE `StationID`=p_stationID;
END ;;

DELIMITER ;;
CREATE PROCEDURE AddMeteoStation(p_name VARCHAR(15), p_latitude VARCHAR(8), p_longitude VARCHAR(8), p_altitude VARCHAR(4)) 
BEGIN
    DEClARE thisStationID INT;
    if (select count(*) from stacjepogodowe where `NazwaStacjiPogodowej`=p_name) then
    SELECT `StationID` INTO thisStationID FROM `StacjePogodowe` WHERE `NazwaStacjiPogodowej`=p_name;
    else
    INSERT INTO `StacjePogodowe` (`NazwaStacjiPogodowej`) VALUES (p_name);
    SELECT `StationID` INTO thisStationID FROM `StacjePogodowe` WHERE `NazwaStacjiPogodowej`=p_name;
    INSERT INTO `Polozenie` (`SzerokoscGeograficzna`,`DlugoscGeograficzna`,`Wysokosc`,`StationID`) VALUES (p_latitude,p_longitude,p_altitude,thisStationID);
    end if;
END ;;

DELIMITER ;;
CREATE PROCEDURE AddAnalyst(p_login tinytext,p_haslo tinytext,p_imie tinytext,p_nazwisko tinytext,p_e_mail tinytext)
BEGIN
	if (select count(*) from administratorzy where `login`=p_login) then
		SELECT * FROM `Analitycy`;
    else
		INSERT INTO `Analitycy` (`login`,`haslo`,`imie`,`nazwisko`,`e_mail`) VALUES (p_login,p_haslo,p_imie,p_nazwisko,p_e_mail);
	end if;
END ;;

DELIMITER ;;
CREATE PROCEDURE AddAdmin(p_login tinytext,p_haslo tinytext,p_imie tinytext,p_nazwisko tinytext,p_e_mail tinytext)
BEGIN
	if (select count(*) from administratorzy where `login`=p_login) then
		SELECT * FROM `Administratorzy`;
    else
		INSERT INTO `Administratorzy` (`login`,`haslo`,`imie`,`nazwisko`,`e_mail`) VALUES (p_login,p_haslo,p_imie,p_nazwisko,p_e_mail);
	end if;
END ;;

DELIMITER ;;
CREATE PROCEDURE DeleteAnalyst(in p_login INT)
BEGIN
    DELETE FROM `Analitycy` WHERE `login`=p_login; 
END ;;

DELIMITER ;;
CREATE PROCEDURE DeleteAdmin(in p_login INT)
BEGIN
    DELETE FROM `Administratorzy` WHERE `login`=p_login; 
END ;;

DROP VIEW IF EXISTS widok_pomiaru;
CREATE VIEW widok_pomiaru AS (
  SELECT
    DateStationID, DataPomiaru, StationID,
    case when KodPomiaru = "TMIN" then WartoscPomiaru end as TMIN,
    case when KodPomiaru = "TMAX" then WartoscPomiaru end as TMAX,
    case when KodPomiaru = "TMID" then WartoscPomiaru end as TMID,
    case when KodPomiaru = "TAVG" then WartoscPomiaru end as TAVG,
    case when KodPomiaru = "HAVG" then WartoscPomiaru end as HAVG,
    case when KodPomiaru = "WINT" then WartoscPomiaru end as WINT,
    case when KodPomiaru = "WGUS" then WartoscPomiaru end as WGUS,
    case when KodPomiaru = "PRES" then WartoscPomiaru end as PRES,
    case when KodPomiaru = "PREC" then WartoscPomiaru end as PREC,
    case when KodPomiaru = "TCLD" then WartoscPomiaru end as TCLD,
    case when KodPomiaru = "LCLD" then WartoscPomiaru end as LCLD,
	case when KodPomiaru = "SUNH" then WartoscPomiaru end as SUNH,
    case when KodPomiaru = "SVIS" then WartoscPomiaru end as SVIS
  FROM pomiary
);

DROP VIEW IF EXISTS widok_pomiaru_pivot;
CREATE VIEW widok_pomiaru_pivot AS (
  SELECT
    DateStationID, DataPomiaru, StationID,
    sum(TMIN) as TMIN,
    sum(TMAX) as TMAX,
    sum(TMID) as TMID,
    sum(HAVG) as HAVG,
    sum(TAVG) as TAVG,
    sum(WINT) as WINT,
    sum(WGUS) as WGUS,
    sum(PRES) as PRES,
    sum(PREC) as PREC,
    sum(TCLD) as TCLD,
    sum(LCLD) as LCLD,
    sum(SUNH) as SUNH,
    sum(SVIS) as SVIS

  from widok_pomiaru
  group by DateStationID
);

DROP VIEW IF EXISTS widok_pomiaru_pivot_collaps;
CREATE VIEW widok_pomiaru_pivot_collaps as (
  SELECT
    DateStationID, DataPomiaru, StationID,
    COALESCE(TMIN, 0) as TMIN, 
    COALESCE(TMAX, 0) as TMAX, 
    COALESCE(TMID, 0) as TMID,
    COALESCE(TAVG, 0) as TAVG,
    COALESCE(HAVG, 0) as HAVG,
    COALESCE(WINT, 0) as WINT,
    COALESCE(WGUS, 0) as WGUS,
    COALESCE(PRES, 0) as PRES,
    COALESCE(PREC, 0) as PREC,
    COALESCE(TCLD, 0) as TCLD,
    COALESCE(LCLD, 0) as LCLD,
    COALESCE(SUNH, 0) as SUNH,
    COALESCE(SVIS, 0) as SVIS
    
  FROM widok_pomiaru_pivot
);

DELIMITER ;;
DROP PROCEDURE IF EXISTS `GetStationMeteoData`;;
CREATE PROCEDURE `GetStationMeteoData`(IN `p_stationID` INT(11))
BEGIN

SELECT * FROM widok_pomiaru_pivot_collaps WHERE StationID = p_stationID;
END;;

DELIMITER ;;
CREATE PROCEDURE UpdateAutoComment()
BEGIN
/*TODO*/
END;;

DELIMITER ;;
CREATE PROCEDURE GetDataAnalysis(p_stationID int)
BEGIN
/*TODO*/
END ;;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;