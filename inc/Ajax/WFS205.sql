-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2023 at 02:50 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wfs205`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_Stagiaire_From_Group` (IN `CEFIN` VARCHAR(50))   BEGIN
	IF EXISTS ( SELECT CEF FROM stagiaire WHERE stagiaire.CEF = CEFIN ) THEN
        UPDATE stagiaire SET stagiaire.idGroupe = NULL WHERE stagiaire.CEF = CEFIN;
        IF EXISTS ( SELECT * FROM compte WHERE compte.user = CEFIN ) THEN
            DELETE FROM `compte` WHERE compte.user = CEFIN;
            END IF;
     END IF;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `check_formatuer` (`datain` VARCHAR(50)) RETURNS INT(11) DETERMINISTIC BEGIN
	DECLARE state int ;
    if exists (select formateur.Matricule from formateur where formateur.Matricule = datain) then
		set state = 1;
	else
        set state = -1;
	end if ;
    RETURN  state;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Get_CountAbs_Date` (`datein` DATE, `typein` VARCHAR(20)) RETURNS INT(11) READS SQL DATA BEGIN
	DECLARE nbr int ;
    if exists (select dateAbsence from absence where absence.dateAbsence = datein) then
		set nbr =(SELECT COUNT(idAbsence) FROM absence where dateAbsence = datein and type = typein and justifier = "no");
	else
        set nbr = 0;
	end if ;
    RETURN  nbr;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `absence`
--

CREATE TABLE `absence` (
  `idAbsence` int(11) NOT NULL,
  `dateAbsence` date DEFAULT NULL,
  `heureDebutAbsence` time DEFAULT NULL,
  `heureFinAbsence` time DEFAULT NULL,
  `Duree` float NOT NULL,
  `moduleAbsence` varchar(45) DEFAULT NULL,
  `matricule` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `idAnnee` int(11) DEFAULT NULL,
  `idFiliere` int(11) DEFAULT NULL,
  `idGroupe` int(11) DEFAULT NULL,
  `idAnneeScolaire` int(11) DEFAULT NULL,
  `CEF` varchar(50) DEFAULT NULL,
  `justifier` varchar(20) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `absence`
--
DELIMITER $$
CREATE TRIGGER `Calc_Duration` BEFORE INSERT ON `absence` FOR EACH ROW BEGIN
SET New.Duree = TIMESTAMPDIFF(MINUTE,New.heureDebutAbsence,New.heureFinAbsence);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Calc_Duration_On_Update` BEFORE UPDATE ON `absence` FOR EACH ROW BEGIN
IF (New.heureDebutAbsence <> OLD.heureDebutAbsence || New.heureFinAbsence <> OLD.heureFinAbsence) THEN
SET New.Duree = TIMESTAMPDIFF(MINUTE,New.heureDebutAbsence,New.heureFinAbsence);
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `annee`
--

CREATE TABLE `annee` (
  `idAnnee` int(11) NOT NULL,
  `nomAnnee` varchar(40) NOT NULL,
  `idAnneeScolaire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `annee`
--

INSERT INTO `annee` (`idAnnee`, `nomAnnee`, `idAnneeScolaire`) VALUES
(1, '1ere Annee', 1),
(2, '2eme Annee', 1),
(3, '3eme  Annee', 1),
(4, '1ere Annee', 2),
(5, '2eme Annee', 2),
(6, '1ere Annee', 3);

-- --------------------------------------------------------

--
-- Table structure for table `anneescolaire`
--

CREATE TABLE `anneescolaire` (
  `idAnneeScolaire` int(11) NOT NULL,
  `nomAnneeScolaire` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `anneescolaire`
--

INSERT INTO `anneescolaire` (`idAnneeScolaire`, `nomAnneeScolaire`) VALUES
(1, '2021-2023'),
(2, '2023-2024'),
(3, '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `compte`
--

CREATE TABLE `compte` (
  `user` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `compteType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `compte`
--

INSERT INTO `compte` (`user`, `password`, `compteType`) VALUES
('1997071300186', '$2y$15$cjMMBaoYpwUnY/NLI7r9DOIdlQy.FEa/JAdK2I/OJ9Wa83owoU7SK', 'stagiaire'),
('1998121700398', '$2y$15$vxrU1LqtQX0UVGa5fxZq1uai1qL4e1Yva5.5LMribfPWOAIMIpUoO', 'stagiaire'),
('directrice', '$2y$10$ZiQuGSofMCqvMIQYtEivF.7sLpAaTtCfzjV4WLa10wtB1ntWcgllS', 'directrice'),
('sg', '$2y$10$rm4kFr4f1SHg4MTcItJX4eHqbLuuMW8rVr.GmfTNF9meOXR1JoFnK', 'serveillant'),
('sp', '$2y$10$sJ7B7vaqbcyvEbPID3T2OebUT7hhQo9iNuJ76QT8r.bIX1Qieb5Gq', 'superAdmin');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_stagiaire`
--

CREATE TABLE `deleted_stagiaire` (
  `CEF` varchar(50) NOT NULL,
  `nomStagiaire` varchar(60) NOT NULL,
  `prenomStagiaire` varchar(60) NOT NULL,
  `idGroupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deleted_stagiaire`
--

INSERT INTO `deleted_stagiaire` (`CEF`, `nomStagiaire`, `prenomStagiaire`, `idGroupe`) VALUES
('1', 'Holako', 'Holako', 47),


--
-- Triggers `deleted_stagiaire`
--
DELIMITER $$
CREATE TRIGGER `Restore_Stagiaiare` AFTER DELETE ON `deleted_stagiaire` FOR EACH ROW BEGIN  
   UPDATE `stagiaire` SET `idGroupe`= OLD.idGroupe WHERE `CEF` = OLD.CEF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `filiere`
--

CREATE TABLE `filiere` (
  `idFiliere` int(11) NOT NULL,
  `nomFiliere` varchar(150) NOT NULL,
  `idAnnee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `filiere`
--

INSERT INTO `filiere` (`idFiliere`, `nomFiliere`, `idAnnee`) VALUES
(11, 'developpeur d\'applications python', 1),
(12, 'Developpement digital', 1),
(13, 'Infrastructure digitale', 1),
(14, 'Developpement des applications web et mobiles', 1),
(15, 'Developpement digital option Web full stack', 2),
(16, 'Infrastructure Digitale option Systemes et Re', 2),
(17, 'Infrastructure Digitale option Cyber securite', 2),
(18, 'Infrastructure Digitale option Cloud Computin', 2),
(19, 'Developpement Digital option Applications Mob', 2),
(20, 'Maintenance Informatique et Reseaux', 3),
(28, 'lol', 6),
(29, 'ol', 4);

-- --------------------------------------------------------

--
-- Table structure for table `formateur`
--

CREATE TABLE `formateur` (
  `Matricule` varchar(50) NOT NULL,
  `nomFormateur` varchar(50) NOT NULL,
  `prenomFormateur` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groupe`
--

CREATE TABLE `groupe` (
  `idGroupe` int(11) NOT NULL,
  `nomGroupe` varchar(40) NOT NULL,
  `idFiliere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groupe`
--

INSERT INTO `groupe` (`idGroupe`, `nomGroupe`, `idFiliere`) VALUES
(22, 'DAP101', 11),
(23, 'DAP102', 11),
(24, 'DEV101', 12),
(25, 'DEV102', 12),
(26, 'DEV103', 12),
(27, 'DEV104', 12),
(28, 'DEV105', 12),
(29, 'DEV106', 12),
(30, 'DEV107', 12),
(31, 'DEV108', 12),
(32, 'DEV109', 12),
(34, 'DEV110', 12),
(35, 'ID101', 13),
(36, 'ID102', 13),
(37, 'ID103', 13),
(38, 'ID104', 13),
(39, 'ID105', 13),
(40, 'ID106', 13),
(41, 'ID107', 13),
(42, 'DAWM101', 14),
(43, 'DEVOWFS201', 15),
(44, 'DEVOWFS202', 15),
(45, 'DEVOWFS203', 15),
(46, 'DEVOWFS204', 15),
(47, 'DEVOWFS205', 15),
(48, 'DEVOWFS206', 15),
(49, 'DEVOWFS207', 15),
(50, 'DEVOWFS208', 15),
(51, 'DEVOWFS209', 15),
(52, 'IDOSR201', 16),
(53, 'IDOSR202', 16),
(54, 'IDOSR203', 16),
(55, 'IDOSR204', 16),
(56, 'IDOSR205', 16),
(57, 'IDOSR206', 15),
(58, 'IDOCS201', 17),
(59, 'IDOCC201', 18),
(60, 'IDOCC202', 18),
(61, 'DEVOAM201', 19),
(62, 'MIR301', 20),
(72, 'DEV101', 12);

-- --------------------------------------------------------

--
-- Table structure for table `justifierabsence`
--

CREATE TABLE `justifierabsence` (
  `idAbsence` int(11) NOT NULL,
  `Justifie_motif` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `justifierabsence`
--
DELIMITER $$
CREATE TRIGGER `Affter_delete_Justification` AFTER DELETE ON `justifierabsence` FOR EACH ROW BEGIN
    UPDATE
        absence
    SET
        absence.justifier = "no"
    WHERE
        absence.idAbsence = old.idAbsence;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trigger_justifier_after` AFTER INSERT ON `justifierabsence` FOR EACH ROW BEGIN
    UPDATE
        absence
    SET
        absence.justifier = "oui"
    WHERE
        absence.idAbsence = NEW.idAbsence;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `idModule` int(11) NOT NULL,
  `nomModule` varchar(255) NOT NULL,
  `idFiliere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`idModule`, `nomModule`, `idFiliere`) VALUES
(104, 'Module1', 11),
(105, 'Module2', 12),
(106, 'Module3', 11),
(107, 'Module4', 15),
(108, 'Module5', 13),
(109, 'Module1', 15);

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `CEF` varchar(50) NOT NULL,
  `comportement` int(10) NOT NULL DEFAULT 0,
  `note` int(11) NOT NULL
) ;


-- Triggers `stagiaire`
--
DELIMITER $$
CREATE TRIGGER `After_Delete_Stagiaire` AFTER UPDATE ON `stagiaire` FOR EACH ROW BEGIN  
        IF (NEW.idGroupe IS NULL) THEN
    INSERT INTO deleted_stagiaire(
        CEF,
        nomStagiaire,
        prenomStagiaire,
        idGroupe
    )
VALUES(
    OLD.CEF,
    OLD.nomStagiaire,
    OLD.prenomStagiaire,
    OLD.idGroupe
);
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absence`
--
ALTER TABLE `absence`
  ADD PRIMARY KEY (`idAbsence`),
  ADD KEY `absence_annee` (`idAnnee`),
  ADD KEY `absence_anneescolaire` (`idAnneeScolaire`),
  ADD KEY `absence_filiere` (`idFiliere`),
  ADD KEY `absence_groupe` (`idGroupe`),
  ADD KEY `absence_stagiaire` (`CEF`),
  ADD KEY `absence_formatuer` (`matricule`);

--
-- Indexes for table `annee`
--
ALTER TABLE `annee`
  ADD PRIMARY KEY (`idAnnee`),
  ADD KEY `annee_anneescolaire` (`idAnneeScolaire`);

--
-- Indexes for table `anneescolaire`
--
ALTER TABLE `anneescolaire`
  ADD PRIMARY KEY (`idAnneeScolaire`);

--
-- Indexes for table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`user`);

--
-- Indexes for table `deleted_stagiaire`
--
ALTER TABLE `deleted_stagiaire`
  ADD PRIMARY KEY (`CEF`),
  ADD KEY `deletedstg_group` (`idGroupe`);

--
-- Indexes for table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`idFiliere`),
  ADD KEY `filiere_annee` (`idAnnee`);

--
-- Indexes for table `formateur`
--
ALTER TABLE `formateur`
  ADD PRIMARY KEY (`Matricule`);

--
-- Indexes for table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`idGroupe`),
  ADD KEY `group_filiere` (`idFiliere`);

--
-- Indexes for table `justifierabsence`
--
ALTER TABLE `justifierabsence`
  ADD PRIMARY KEY (`idAbsence`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`idModule`),
  ADD KEY `fk_module_filiere` (`idFiliere`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`CEF`),
  ADD KEY `note_stagiaire` (`CEF`);

--
-- Indexes for table `stagiaire`
--
ALTER TABLE `stagiaire`
  ADD PRIMARY KEY (`CEF`),
  ADD KEY `satagiaire_groupe` (`idGroupe`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absence`
--
ALTER TABLE `absence`
  MODIFY `idAbsence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=698;

--
-- AUTO_INCREMENT for table `annee`
--
ALTER TABLE `annee`
  MODIFY `idAnnee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `anneescolaire`
--
ALTER TABLE `anneescolaire`
  MODIFY `idAnneeScolaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `idFiliere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `idGroupe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `idModule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absence`
--
ALTER TABLE `absence`
  ADD CONSTRAINT `absence_annee` FOREIGN KEY (`idAnnee`) REFERENCES `annee` (`idAnnee`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absence_anneescolaire` FOREIGN KEY (`idAnneeScolaire`) REFERENCES `anneescolaire` (`idAnneeScolaire`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `absence_filiere` FOREIGN KEY (`idFiliere`) REFERENCES `filiere` (`idFiliere`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absence_formatuer` FOREIGN KEY (`matricule`) REFERENCES `formateur` (`Matricule`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `absence_groupe` FOREIGN KEY (`idGroupe`) REFERENCES `groupe` (`idGroupe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absence_stagiaire` FOREIGN KEY (`CEF`) REFERENCES `stagiaire` (`CEF`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `annee`
--
ALTER TABLE `annee`
  ADD CONSTRAINT `annee_anneescolaire` FOREIGN KEY (`idAnneeScolaire`) REFERENCES `anneescolaire` (`idAnneeScolaire`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deleted_stagiaire`
--
ALTER TABLE `deleted_stagiaire`
  ADD CONSTRAINT `deletedstg_group` FOREIGN KEY (`idGroupe`) REFERENCES `groupe` (`idGroupe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `filiere`
--
ALTER TABLE `filiere`
  ADD CONSTRAINT `filiere_annee` FOREIGN KEY (`idAnnee`) REFERENCES `annee` (`idAnnee`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groupe`
--
ALTER TABLE `groupe`
  ADD CONSTRAINT `group_filiere` FOREIGN KEY (`idFiliere`) REFERENCES `filiere` (`idFiliere`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `justifierabsence`
--
ALTER TABLE `justifierabsence`
  ADD CONSTRAINT `justifierabsence_absence` FOREIGN KEY (`idAbsence`) REFERENCES `absence` (`idAbsence`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `fk_module_filiere` FOREIGN KEY (`idFiliere`) REFERENCES `filiere` (`idFiliere`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_stagiaire` FOREIGN KEY (`CEF`) REFERENCES `stagiaire` (`CEF`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stagiaire`
--
ALTER TABLE `stagiaire`
  ADD CONSTRAINT `satagiaire_groupe` FOREIGN KEY (`idGroupe`) REFERENCES `groupe` (`idGroupe`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
