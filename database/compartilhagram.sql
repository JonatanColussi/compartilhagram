SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `compartilhagram` ;
CREATE SCHEMA IF NOT EXISTS `compartilhagram` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `compartilhagram` ;

-- -----------------------------------------------------
-- Table `compartilhagram`.`Users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `compartilhagram`.`Users` ;

CREATE TABLE IF NOT EXISTS `compartilhagram`.`Users` (
  `idUser` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `username` VARCHAR(20) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `image` VARCHAR(16) NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compartilhagram`.`Posts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `compartilhagram`.`Posts` ;

CREATE TABLE IF NOT EXISTS `compartilhagram`.`Posts` (
  `idPost` INT NOT NULL AUTO_INCREMENT,
  `image` VARCHAR(16) NOT NULL,
  `date` DATETIME NOT NULL,
  `description` TINYTEXT NULL,
  `idUser` INT NOT NULL,
  PRIMARY KEY (`idPost`),
  INDEX `fk_Posts_Users_idx` (`idUser` ASC),
  CONSTRAINT `fk_Posts_Users`
    FOREIGN KEY (`idUser`)
    REFERENCES `compartilhagram`.`Users` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compartilhagram`.`Comments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `compartilhagram`.`Comments` ;

CREATE TABLE IF NOT EXISTS `compartilhagram`.`Comments` (
  `idComment` INT NOT NULL AUTO_INCREMENT,
  `comment` TINYTEXT NULL,
  `date` DATETIME NOT NULL,
  `idUser` INT NOT NULL,
  `idPost` INT NOT NULL,
  PRIMARY KEY (`idComment`),
  INDEX `fk_Comments_Users1_idx` (`idUser` ASC),
  INDEX `fk_Comments_Posts1_idx` (`idPost` ASC),
  CONSTRAINT `fk_Comments_Users1`
    FOREIGN KEY (`idUser`)
    REFERENCES `compartilhagram`.`Users` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Comments_Posts1`
    FOREIGN KEY (`idPost`)
    REFERENCES `compartilhagram`.`Posts` (`idPost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compartilhagram`.`Likes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `compartilhagram`.`Likes` ;

CREATE TABLE IF NOT EXISTS `compartilhagram`.`Likes` (
  `idUser` INT NOT NULL,
  `idPost` INT NOT NULL,
  PRIMARY KEY (`idUser`, `idPost`),
  INDEX `fk_Users_has_Posts_Posts1_idx` (`idPost` ASC),
  INDEX `fk_Users_has_Posts_Users1_idx` (`idUser` ASC),
  CONSTRAINT `fk_Users_has_Posts_Users1`
    FOREIGN KEY (`idUser`)
    REFERENCES `compartilhagram`.`Users` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Users_has_Posts_Posts1`
    FOREIGN KEY (`idPost`)
    REFERENCES `compartilhagram`.`Posts` (`idPost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
