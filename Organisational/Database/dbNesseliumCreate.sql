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
-- Table `db_nesselium`.`tblLanguage`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_nesselium`.`tblLanguage` ;

CREATE TABLE IF NOT EXISTS `db_nesselium`.`tblLanguage` (
  `PK_language` INT NOT NULL AUTO_INCREMENT,
  `locale` VARCHAR(5) NULL,
  `languageName` VARCHAR(25) NULL,
  PRIMARY KEY (`PK_language`))
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
  `FK_language` INT NOT NULL,
  PRIMARY KEY (`PK_user`),
  INDEX `fk_tbl_user_tbl_userType1_idx` (`FK_usertype` ASC),
  INDEX `fk_tblUser_tblLanguage1_idx` (`FK_language` ASC),
  CONSTRAINT `fk_tbl_user_tbl_userType1`
    FOREIGN KEY (`FK_usertype`)
    REFERENCES `db_nesselium`.`tblUserType` (`PK_userType`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblUser_tblLanguage1`
    FOREIGN KEY (`FK_language`)
    REFERENCES `db_nesselium`.`tblLanguage` (`PK_language`)
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
-- Table `db_nesselium`.`tblCategory`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_nesselium`.`tblCategory` ;

CREATE TABLE IF NOT EXISTS `db_nesselium`.`tblCategory` (
  `PK_category` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(65) NULL,
  PRIMARY KEY (`PK_category`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_nesselium`.`tblArticle`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_nesselium`.`tblArticle` ;

CREATE TABLE IF NOT EXISTS `db_nesselium`.`tblArticle` (
  `PK_article` INT NOT NULL AUTO_INCREMENT,
  `text` LONGTEXT NULL,
  `FK_category` INT NOT NULL,
  `internalComment` MEDIUMTEXT NULL,
  `releaseDate` DATETIME NULL,
  `createDate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `FK_user` INT NOT NULL,
  `tblLanguage_PK_language` INT NOT NULL,
  `FK_userType_viewableBy` INT NOT NULL DEFAULT 6,
  PRIMARY KEY (`PK_article`),
  INDEX `fk_tblArticle_tblCategory1_idx` (`FK_category` ASC),
  INDEX `fk_tblArticle_tblUser1_idx` (`FK_user` ASC),
  INDEX `fk_tblArticle_tblLanguage1_idx` (`tblLanguage_PK_language` ASC),
  INDEX `fk_tblArticle_tblUserType1_idx` (`FK_userType_viewableBy` ASC),
  CONSTRAINT `fk_tblArticle_tblCategory1`
    FOREIGN KEY (`FK_category`)
    REFERENCES `db_nesselium`.`tblCategory` (`PK_category`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblArticle_tblUser1`
    FOREIGN KEY (`FK_user`)
    REFERENCES `db_nesselium`.`tblUser` (`PK_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblArticle_tblLanguage1`
    FOREIGN KEY (`tblLanguage_PK_language`)
    REFERENCES `db_nesselium`.`tblLanguage` (`PK_language`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblArticle_tblUserType1`
    FOREIGN KEY (`FK_userType_viewableBy`)
    REFERENCES `db_nesselium`.`tblUserType` (`PK_userType`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_nesselium`.`tblErrorlog`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_nesselium`.`tblErrorlog` ;

CREATE TABLE IF NOT EXISTS `db_nesselium`.`tblErrorlog` (
  `PK_errorlog` INT NOT NULL AUTO_INCREMENT,
  `time` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `type` INT NULL,
  `errormsg` MEDIUMTEXT NULL,
  `file` VARCHAR(255) NULL,
  `row` INT NULL,
  PRIMARY KEY (`PK_errorlog`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_nesselium`.`tblTags`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_nesselium`.`tblTags` ;

CREATE TABLE IF NOT EXISTS `db_nesselium`.`tblTags` (
  `PK_Tag` INT NOT NULL AUTO_INCREMENT,
  `tagName` VARCHAR(45) NULL,
  PRIMARY KEY (`PK_Tag`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_nesselium`.`tblArticle_has_tblTags`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_nesselium`.`tblArticle_has_tblTags` ;

CREATE TABLE IF NOT EXISTS `db_nesselium`.`tblArticle_has_tblTags` (
  `tblArticle_PK_article` INT NOT NULL,
  `tblTags_PK_Tag` INT NOT NULL,
  PRIMARY KEY (`tblArticle_PK_article`, `tblTags_PK_Tag`),
  INDEX `fk_tblArticle_has_tblTags_tblTags1_idx` (`tblTags_PK_Tag` ASC),
  INDEX `fk_tblArticle_has_tblTags_tblArticle1_idx` (`tblArticle_PK_article` ASC),
  CONSTRAINT `fk_tblArticle_has_tblTags_tblArticle1`
    FOREIGN KEY (`tblArticle_PK_article`)
    REFERENCES `db_nesselium`.`tblArticle` (`PK_article`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblArticle_has_tblTags_tblTags1`
    FOREIGN KEY (`tblTags_PK_Tag`)
    REFERENCES `db_nesselium`.`tblTags` (`PK_Tag`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_nesselium`.`tblEditLog`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_nesselium`.`tblEditLog` ;

CREATE TABLE IF NOT EXISTS `db_nesselium`.`tblEditLog` (
  `PK_edit` INT NOT NULL AUTO_INCREMENT,
  `time` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `FK_user` INT NOT NULL,
  `FK_article` INT NOT NULL,
  PRIMARY KEY (`PK_edit`),
  INDEX `fk_editLog_tblUser1_idx` (`FK_user` ASC),
  INDEX `fk_editLog_tblArticle1_idx` (`FK_article` ASC),
  CONSTRAINT `fk_editLog_tblUser1`
    FOREIGN KEY (`FK_user`)
    REFERENCES `db_nesselium`.`tblUser` (`PK_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_editLog_tblArticle1`
    FOREIGN KEY (`FK_article`)
    REFERENCES `db_nesselium`.`tblArticle` (`PK_article`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
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
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (8, '\'Guest\'');

COMMIT;


-- -----------------------------------------------------
-- Data for table `db_nesselium`.`tblLanguage`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_nesselium`;
INSERT INTO `db_nesselium`.`tblLanguage` (`PK_language`, `locale`, `languageName`) VALUES (1, '\'en_US\'', '\'English - English\'');
INSERT INTO `db_nesselium`.`tblLanguage` (`PK_language`, `locale`, `languageName`) VALUES (2, '\'de_DE\'', '\'German - German\'');

COMMIT;

