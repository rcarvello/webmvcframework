-- MySQL Script for mvc_wiki database

-- Disabling DB constraints checking
SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0;
SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0;
SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Create the schema for a simple database named mvc_wiki
-- -----------------------------------------------------
CREATE DATABASE IF NOT EXISTS `mvc_wiki` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mvc_wiki`;

-- -----------------------------------------------------
-- Create table `user`
-- Stores users information
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user`
(
    `user_id`    INT          NOT NULL AUTO_INCREMENT,
    `user_name`  VARCHAR(45)  NULL,
    `user_email` VARCHAR(100) NULL,
    PRIMARY KEY (`user_id`)
)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Create table `application_role`
-- Stores all available application roles 
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `application_role`
(
    `role_id`   INT         NOT NULL AUTO_INCREMENT,
    `role_name` VARCHAR(45) NULL,
    PRIMARY KEY (`role_id`)
)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Create table `users_roles`
-- Stores users roles 
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users_roles`
(
    `user_id` INT NOT NULL,
    `role_id` INT NOT NULL,
    PRIMARY KEY (`user_id`, `role_id`),
    INDEX `fk_user_has_application_role_application_role1_idx` (`role_id` ASC),
    INDEX `fk_user_has_application_role_user_idx` (`user_id` ASC),
    CONSTRAINT `fk_user_has_application_role_user`
        FOREIGN KEY (`user_id`)
            REFERENCES `user` (`user_id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
    CONSTRAINT `fk_user_has_application_role_application_role1`
        FOREIGN KEY (`role_id`)
            REFERENCES `application_role` (`role_id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
)
    ENGINE = InnoDB;


SET SQL_MODE = @OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Sample data for table `user`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `user` (`user_id`, `user_name`, `user_email`)
VALUES (1, 'Mark', 'mark@email.com');
INSERT INTO `user` (`user_id`, `user_name`, `user_email`)
VALUES (2, 'Elen', 'elen@email.com');
INSERT INTO `user` (`user_id`, `user_name`, `user_email`)
VALUES (3, 'John', 'john@email.com');

COMMIT;


-- -----------------------------------------------------
-- Sample data data for table `application_role`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `application_role` (`role_id`, `role_name`)
VALUES (5, 'admin');
INSERT INTO `application_role` (`role_id`, `role_name`)
VALUES (4, 'webmaster');
INSERT INTO `application_role` (`role_id`, `role_name`)
VALUES (3, 'moderator');
INSERT INTO `application_role` (`role_id`, `role_name`)
VALUES (2, 'editor');
INSERT INTO `application_role` (`role_id`, `role_name`)
VALUES (1, 'user');

COMMIT;


-- -----------------------------------------------------
-- Data for table `users_roles`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `users_roles` (`user_id`, `role_id`)
VALUES (1, 5);
INSERT INTO `users_roles` (`user_id`, `role_id`)
VALUES (1, 4);
INSERT INTO `users_roles` (`user_id`, `role_id`)
VALUES (1, 3);
INSERT INTO `users_roles` (`user_id`, `role_id`)
VALUES (2, 3);
INSERT INTO `users_roles` (`user_id`, `role_id`)
VALUES (2, 2);
INSERT INTO `users_roles` (`user_id`, `role_id`)
VALUES (2, 1);
INSERT INTO `users_roles` (`user_id`, `role_id`)
VALUES (3, 2);
INSERT INTO `users_roles` (`user_id`, `role_id`)
VALUES (3, 1);

COMMIT;

