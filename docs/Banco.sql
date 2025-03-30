
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema projeto
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema projeto
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `projeto` DEFAULT CHARACTER SET utf8mb4 ;
USE `projeto` ;

-- -----------------------------------------------------
-- Table `projeto`.`escolas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projeto`.`escolas` (
  `idEscola` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `nomeEscola` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idEscola`),
  UNIQUE INDEX `id_escola_UNIQUE` (`idEscola` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `projeto`.`professores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projeto`.`professores` (
  `idProfessor` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomeProfessor` VARCHAR(255) NOT NULL,
  `telefone` VARCHAR(15) NOT NULL,
  `cpf` VARCHAR(14) NOT NULL,
  `especialidade` VARCHAR(255) NOT NULL,
  `escolas_idEscola` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`idProfessor`),
  UNIQUE INDEX `id_prof_UNIQUE` (`idProfessor` ASC),
  INDEX `fk_professores_escolas1_idx` (`escolas_idEscola` ASC),
  CONSTRAINT `fk_professores_escolas1`
    FOREIGN KEY (`escolas_idEscola`)
    REFERENCES `projeto`.`escolas` (`idEscola`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `projeto`.`turmas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projeto`.`turmas` (
  `idTurma` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `série` VARCHAR(64) NOT NULL,
  `quantiaAlunos` INT(3) NOT NULL,
  `cursoTécnico` VARCHAR(64) NOT NULL,
  `professores_idProf` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`idTurma`),
  UNIQUE INDEX `id_turma_UNIQUE` (`idTurma` ASC),
  INDEX `fk_turmas_professores_idx` (`professores_idProf` ASC),
  CONSTRAINT `fk_turmas_professores`
    FOREIGN KEY (`professores_idProf`)
    REFERENCES `projeto`.`professores` (`idProfessor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;