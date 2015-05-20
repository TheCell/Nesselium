-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema db_nesselium
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `db_nesselium` ;

-- -----------------------------------------------------
-- Schema db_nesselium
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_nesselium` DEFAULT CHARACTER SET utf8 ;
USE `db_nesselium` ;

-- -----------------------------------------------------
-- Table `db_nesselium`.`tblUserType`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_nesselium`.`tblUserType` ;

CREATE TABLE IF NOT EXISTS `db_nesselium`.`tblUserType` (
  `PK_userType` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) NULL,
  PRIMARY KEY (`PK_userType`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_nesselium`.`tblUser`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_nesselium`.`tblUser` ;

CREATE TABLE IF NOT EXISTS `db_nesselium`.`tblUser` (
  `PK_user` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(64) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(128) NOT NULL,
  `salt` VARCHAR(128) NOT NULL,
  `create_time` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `firstname` VARCHAR(120) NULL,
  `lastname` VARCHAR(120) NULL,
  `birthday` DATE NULL,
  `lastLogin` DATETIME NULL,
  `ipAddressV4` INT UNSIGNED NULL DEFAULT 0,
  `ipAddressV6` VARBINARY(39) NULL DEFAULT 0,
  `FK_usertype` INT NOT NULL DEFAULT 7,
  PRIMARY KEY (`PK_user`),
  INDEX `fk_tbl_user_tbl_userType1_idx` (`FK_usertype` ASC),
  CONSTRAINT `fk_tbl_user_tbl_userType1`
    FOREIGN KEY (`FK_usertype`)
    REFERENCES `db_nesselium`.`tblUserType` (`PK_userType`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_nesselium`.`tblLoginAttempt`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_nesselium`.`tblLoginAttempt` ;

CREATE TABLE IF NOT EXISTS `db_nesselium`.`tblLoginAttempt` (
  `PK_loginDate` INT NOT NULL AUTO_INCREMENT,
  `isSuccessfull` TINYINT(1) NULL,
  `loginTime` DATETIME NULL,
  `ipAddressV4` INT NULL DEFAULT 0,
  `ipAddressV6` VARBINARY(39) NULL DEFAULT 0,
  `FK_user` INT NOT NULL,
  PRIMARY KEY (`PK_loginDate`),
  INDEX `fk_tbl_loginAttempt_tbl_user_idx` (`FK_user` ASC),
  CONSTRAINT `fk_tbl_loginAttempt_tbl_user`
    FOREIGN KEY (`FK_user`)
    REFERENCES `db_nesselium`.`tblUser` (`PK_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_nesselium`.`tblArticle`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_nesselium`.`tblArticle` ;

CREATE TABLE IF NOT EXISTS `db_nesselium`.`tblArticle` (
  `PK_article` INT NOT NULL AUTO_INCREMENT,
  `text` BLOB NULL,
  PRIMARY KEY (`PK_article`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `db_nesselium`.`tblUserType`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_nesselium`;
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (1, '\'Globaladmin\'');
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (2, '\'Administrator\'');
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (3, '\'Webmaster\'');
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (4, '\'Author\'');
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (5, '\'Writer\'');
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (6, '\'Translator\'');
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (7, '\'User');

COMMIT;

