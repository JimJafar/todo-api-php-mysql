-- Production version (to be used on the live site hosted by hostnet.nl
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE DATABASE IF NOT EXISTS todo_db;

GRANT ALL ON todo_db.* to 'todo_user'@'localhost' IDENTIFIED BY 'letmein!';

-- -----------------------------------------------------
-- Table `todo_db`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `todo_db`.`todos` ;

CREATE  TABLE IF NOT EXISTS `todo_db`.`todos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL UNIQUE ,
  `status` VARCHAR(10) NULL ,
  PRIMARY KEY (`id`) )
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = latin1;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
