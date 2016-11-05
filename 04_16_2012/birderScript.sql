SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`Bird`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`Bird` (
  `BirdID` VARCHAR(45) NOT NULL ,
  `Genus` VARCHAR(45) NOT NULL ,
  `Species` VARCHAR(45) NOT NULL ,
  `Order` VARCHAR(45) NULL ,
  `Family` VARCHAR(45) NULL ,
  `Common_Name` VARCHAR(45) NULL ,
  PRIMARY KEY (`BirdID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Location`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`Location` (
  `LocationID` VARCHAR(45) NOT NULL ,
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
-- Table `mydb`.`Users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`Users` (
  `UserID` VARCHAR(45) NOT NULL ,
  `Last_Name` TEXT NOT NULL ,
  `First_Name` TEXT NOT NULL ,
  `Password` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`UserID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Notes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`Notes` (
  `Notes` LONGTEXT NOT NULL ,
  `Date` DATE NOT NULL ,
  `Weather` MEDIUMTEXT NOT NULL ,
  `Habitat` MEDIUMTEXT NOT NULL ,
  `UserID` VARCHAR(45) NOT NULL ,
  `BirdID` VARCHAR(45) NOT NULL ,
  `LocationID` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`UserID`, `BirdID`, `LocationID`) ,
  INDEX `UserID` (`UserID` ASC) ,
  INDEX `LocationID` (`LocationID` ASC) ,
  INDEX `BirdID` (`BirdID` ASC) ,
  CONSTRAINT `UserID`
    FOREIGN KEY (`UserID` )
    REFERENCES `mydb`.`Users` (`UserID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `LocationID`
    FOREIGN KEY (`LocationID` )
    REFERENCES `mydb`.`Location` (`LocationID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `BirdID`
    FOREIGN KEY (`BirdID` )
    REFERENCES `mydb`.`Bird` (`BirdID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
