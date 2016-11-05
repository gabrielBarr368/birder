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
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


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
  `UserID` VARCHAR(300) NOT NULL ,
  `Last_Name` TEXT NOT NULL ,
  `First_Name` TEXT NOT NULL ,
  `Password` VARCHAR(200) NOT NULL ,
  `LevelUser` INT NOT NULL ,
  `Photo` VARCHAR(300) NULL ,
  `City` VARCHAR(45) NOT NULL ,
  `State` VARCHAR(45) NOT NULL ,
  `Country` VARCHAR(45) NOT NULL ,
  `About` VARCHAR(1000) NULL ,
  PRIMARY KEY (`UserID`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


-- -----------------------------------------------------
-- Table `birder`.`Notes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `birder`.`Notes` (
  `Notes` VARCHAR(1000) NOT NULL ,
  `Date` DATE NOT NULL ,
  `Weather` TEXT NOT NULL ,
  `Habitat` TEXT NOT NULL ,
  `Photo` VARCHAR(300) NULL ,
  `UserID` VARCHAR(300) NOT NULL ,
  `BirdID` VARCHAR(200) NOT NULL ,
  `LocationID` VARCHAR(200) NOT NULL ,
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
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


-- -----------------------------------------------------
-- Table `birder`.`Messages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `birder`.`Messages` (
  `MessagesID` VARCHAR(200) NULL ,
  `Message` VARCHAR(1000) NULL ,
  `FromUser` VARCHAR(300) NOT NULL ,
  `ToUser` VARCHAR(300) NOT NULL ,
  `Total` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`MessagesID`, `To`, `From`) ,
  INDEX `From` (`FromUser` ASC) ,
  INDEX `ToUser` (`ToUser` ASC) ,
  CONSTRAINT `FromUser`
    FOREIGN KEY (`FromUser` )
    REFERENCES `birder`.`Users` (`UserID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `ToUser`
    FOREIGN KEY (`ToUser` )
    REFERENCES `birder`.`Users` (`UserID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
