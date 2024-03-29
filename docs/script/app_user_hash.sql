-- 01/25/20 11:33:59
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';
-- -----------------------------------------------------
-- Schema oshop
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Table `app_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `app_user` ;
CREATE TABLE IF NOT EXISTS `app_user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(128) NOT NULL,
  `password` VARCHAR(60) NOT NULL,
  `firstname` VARCHAR(64) NULL,
  `lastname` VARCHAR(64) NULL,
  `role` ENUM('admin', 'catalog-manager') NOT NULL,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '1 => actif\n2 => désactivé/bloqué',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
-- -----------------------------------------------------
-- Data for table `app_user`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `app_user` (`id`, `email`, `password`, `firstname`, `lastname`, `role`, `status`, `created_at`, `updated_at`) VALUES (1, 'philippe@oclock.io', '$2y$10$BrKFYYY.cDSp.yFFCESMAue1qMS7PJUleNCKQBDFjTkju9RMT5rX6', 'Philippe', 'Candille', 'admin', 1, DEFAULT, NULL);
INSERT INTO `app_user` (`id`, `email`, `password`, `firstname`, `lastname`, `role`, `status`, `created_at`, `updated_at`) VALUES (2, 'lucie@oclock.io', '$2y$10$6yyeDFEPbFirpEsakKjW8ejCOnaF5Rhr5jb/NkKkjSq8oeCPhusgO', 'Lucie', 'Copin', 'admin', 1, DEFAULT, NULL);
INSERT INTO `app_user` (`id`, `email`, `password`, `firstname`, `lastname`, `role`, `status`, `created_at`, `updated_at`) VALUES (3, 'nicole@oclock.io', '$2y$10$wGXcVrxifpzqjVh9MTS4CefTU7E3tq0ZMlgscEou0A8zQ22GkTFZG', 'Nicole', 'Café', 'catalog-manager', 1, DEFAULT, NULL);
COMMIT;