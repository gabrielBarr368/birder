SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `birder` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `birder` ;

-- -----------------------------------------------------
-- Table `birder`.`Bird`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `birder`.`Bird` (
  `BirdID` VARCHAR(200) NOT NULL ,
  `Genus` VARCHAR(45) NOT NULL ,
  `Species` VARCHAR(45) NOT NULL ,
  `BirdOrder` VARCHAR(45) NULL ,
  `Family` VARCHAR(45) NULL ,
  `Common_Name` VARCHAR(45) NULL ,
  PRIMARY KEY (`BirdID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `birder`.`Location`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `birder`.`Location` (
  `LocationID` VARCHAR(200) NOT NULL ,
  `City` VARCHAR(45) NOT NULL ,
  `Country` VARCHAR(45) NOT NULL ,
  `State` VARCHAR(45) NOT NULL ,
  `Latitude` VARCHAR(12) NULL ,
  `Longitude` VARCHAR(12) NULL ,
  `Neighborhood` VARCHAR(45) NULL ,
  `Yard` TINYINT NULL ,
  `Continent` VARCHAR(45) NULL ,
  `Lower48` TINYINT NULL ,
  PRIMARY KEY (`LocationID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `birder`.`Users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `birder`.`Users` (
  `UserID` VARCHAR(100) NOT NULL ,
  `Last_Name` TEXT NOT NULL ,
  `First_Name` TEXT NOT NULL ,
  `Password` VARCHAR(200) NOT NULL ,
  `LevelUser` INT NULL ,
  `Photo` VARCHAR(200) NULL ,
  PRIMARY KEY (`UserID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `birder`.`Notes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `birder`.`Notes` (
  `Notes` LONGTEXT NOT NULL ,
  `Date` DATE NOT NULL ,
  `Weather` MEDIUMTEXT NOT NULL ,
  `Habitat` MEDIUMTEXT NOT NULL ,
  `Photo` VARCHAR(200) NULL ,
  `UserID` VARCHAR(45) NOT NULL ,
  `BirdID` VARCHAR(45) NOT NULL ,
  `LocationID` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`UserID`, `BirdID`, `LocationID`) ,
  INDEX `UserID` (`UserID` ASC) ,
  INDEX `LocationID` (`LocationID` ASC) ,
  INDEX `BirdID` (`BirdID` ASC) ,
  CONSTRAINT `UserID`
    FOREIGN KEY (`UserID` )
    REFERENCES `birder`.`Users` (`UserID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `LocationID`
    FOREIGN KEY (`LocationID` )
    REFERENCES `birder`.`Location` (`LocationID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `BirdID`
    FOREIGN KEY (`BirdID` )
    REFERENCES `birder`.`Bird` (`BirdID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `birder`.`Messages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `birder`.`Messages` (
  `MessageID` VARCHAR(200) NOT NULL ,
  `Message` VARCHAR(1000) NOT NULL ,
  `From` VARCHAR(200) NOT NULL ,
  `To` VARCHAR(200) NOT NULL ,
  PRIMARY KEY (`MessageID`,`From`, `To`)
  INDEX `From` (`From` ASC) ,
  INDEX `To` (`To` ASC)
  CONSTRAINT `From`
    FOREIGN KEY (`From` )
    REFERENCES `birder`.`Users` (`UserID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `To`
    FOREIGN KEY (`To` )
    REFERENCES `birder`.`Users` (`UserID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE )
ENGINE = InnoDB;

CREATE  TABLE Messages (
  MessageID VARCHAR(200) NOT NULL ,
  Message VARCHAR(1000) NOT NULL ,
  From VARCHAR(200) NOT NULL ,
  To VARCHAR(200) NOT NULL ,
  PRIMARY KEY (MessageID, From, To) 
  CONSTRAINT From
    FOREIGN KEY (From, To)
    REFERENCES (UserID, UserID)
    ON DELETE CASCADE
    ON UPDATE CASCADE )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
