-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 15 dec 2015 om 17:24
-- Serverversie: 5.5.43-0ubuntu0.14.04.1
-- PHP-versie: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `grader`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `assess_documents`
--

CREATE TABLE IF NOT EXISTS `assess_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `document` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  `submitted` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `document` (`document`),
  KEY `project` (`project`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Gegevens worden uitgevoerd voor tabel `assess_documents`
--

INSERT INTO `assess_documents` (`id`, `user`, `document`, `project`, `submitted`) VALUES
(1, 415, 62, 32, 1),
(2, 415, 63, 32, 1),
(3, 239, 62, 32, 1),
(4, 239, 63, 32, 0),
(5, 415, 66, 65, 1),
(6, 415, 67, 67, 1),
(7, 415, 68, 67, 1),
(8, 415, 69, 68, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `assess_score`
--

CREATE TABLE IF NOT EXISTS `assess_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `competence` int(11) NOT NULL,
  `subcompetence` int(11) NOT NULL,
  `indicator` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `assess_score_ibfk_6` (`indicator`),
  KEY `assess_score_ibfk_1` (`project`),
  KEY `assess_score_ibfk_2` (`student`),
  KEY `assess_score_ibfk_3` (`user`),
  KEY `assess_score_ibfk_4` (`competence`),
  KEY `assess_score_ibfk_5` (`subcompetence`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Gegevens worden uitgevoerd voor tabel `assess_score`
--

INSERT INTO `assess_score` (`id`, `project`, `student`, `user`, `competence`, `subcompetence`, `indicator`, `score`) VALUES
(1, 37, 239, 7, 10, 7, 11, 62),
(2, 37, 239, 6, 10, 7, 11, 62),
(3, 37, 239, 7, 10, 7, 12, 86),
(4, 37, 239, 7, 10, 7, 13, 19),
(5, 37, 239, 7, 11, 8, 14, 34),
(6, 37, 239, 7, 11, 8, 15, 0),
(7, 37, 239, 7, 11, 8, 16, 32),
(8, 37, 239, 7, 11, 8, 17, 25),
(9, 37, 239, 7, 11, 8, 18, 17),
(10, 37, 239, 6, 10, 7, 12, 71),
(11, 37, 239, 6, 10, 7, 13, 85),
(12, 37, 239, 6, 11, 8, 14, 100),
(13, 37, 239, 6, 11, 8, 15, 63),
(14, 37, 239, 6, 11, 8, 16, 66),
(15, 37, 239, 6, 11, 8, 17, 49),
(16, 37, 239, 6, 11, 8, 18, 78),
(17, 32, 415, 7, 65, 50, 63, 66),
(18, 32, 415, 7, 65, 50, 64, 66),
(19, 32, 415, 1, 65, 50, 63, 95),
(20, 32, 415, 1, 65, 50, 64, 34),
(21, 32, 239, 7, 65, 50, 63, 70),
(22, 32, 239, 7, 65, 50, 64, 60),
(23, 32, 239, 7, 65, 65, 81, 60),
(24, 67, 415, 7, 80, 66, 82, 73),
(25, 67, 415, 7, 80, 66, 83, 62),
(26, 67, 415, 7, 80, 67, 84, 61),
(27, 67, 415, 7, 80, 67, 85, 77),
(28, 67, 415, 7, 81, 68, 86, 84),
(29, 68, 415, 7, 82, 69, 87, 69);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `competence`
--

CREATE TABLE IF NOT EXISTS `competence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `description` varchar(500) NOT NULL,
  `max` int(3) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `project` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

--
-- Gegevens worden uitgevoerd voor tabel `competence`
--

INSERT INTO `competence` (`id`, `code`, `description`, `max`, `weight`, `project`) VALUES
(1, 'CO1', 'Competenties opslaan', 20, 60, 1),
(2, 'CO2', 'Competentie 2', 20, 50, 1),
(3, '', '', 20, 100, 1),
(4, '', '', 20, 100, 1),
(5, 'CO1', 'programmeren', 20, 100, 35),
(6, 'qcfxsfd', 'sfsdqfsdqfsdqf', 20, 100, 35),
(7, 'test', 'name', 20, 100, 35),
(8, 'test', 'name', 20, 100, 35),
(9, 'testcqdsf', 'dfqdfdsqfsdqfsdqfsdqfdsq', 20, 100, 35),
(10, 'LR7', 'Grafisch Presenteren', 20, 25, 37),
(11, 'LR2', 'Een uitvoeringsdossier opmaken van een bouwprogramma van gemiddelde complexiteit', 20, 75, 37),
(12, 'TI', 'TI', 20, 20, 42),
(13, 'TI', 'TI', 20, 20, 42),
(14, 'TI', 'TI', 20, 50, 43),
(15, '', '', 20, 100, 43),
(16, 'test', 'test', 20, 50, 43),
(17, '', '', 20, 100, 43),
(18, '001', 'testcompetence', 20, 100, 46),
(19, '001', 'testcompetence', 20, 100, 46),
(31, 'efzef', 'efezf', 20, 100, 46),
(32, 'efzef', 'efezf', 20, 100, 46),
(33, 'efzef', 'efezf', 20, 100, 46),
(34, 'efzef', 'efezf', 20, 100, 46),
(35, 'efzef', 'efezf', 20, 100, 46),
(36, 'efzef', 'efezf', 20, 100, 46),
(37, 'efzef', 'efezf', 20, 100, 46),
(38, 'efzef', 'efezf', 20, 100, 46),
(39, 'efzef', 'efezf', 20, 100, 46),
(40, 'efzef', 'efezf', 20, 100, 46),
(41, 'efzef', 'efezf', 20, 100, 46),
(42, 'efzef', 'efezf', 20, 100, 46),
(43, 'efzef', 'efezf', 20, 30, 46),
(44, 'efzef', 'efezf', 20, 30, 46),
(45, 'efzef', 'efezf', 20, 30, 46),
(46, 'efzef', 'efezf', 20, 30, 46),
(47, 'efzef', 'efezf', 20, 30, 46),
(48, 'efzef', 'efezf', 20, 30, 46),
(49, 'efzef', 'efezf', 20, 30, 46),
(50, '', '', 20, 25, 43),
(51, '', '', 20, 30, 43),
(52, '', '', 20, 50, 43),
(53, 'testte', 'test', 20, 100, 49),
(54, 'testte', 'test', 20, 100, 49),
(55, 'testte', 'test', 20, 100, 49),
(56, 'testte', 'test', 20, 100, 49),
(57, 'testte', 'test', 20, 100, 49),
(58, 'testte', 'test', 20, 100, 49),
(59, 'testte', 'test', 20, 100, 49),
(60, 'testte', 'test', 20, 100, 49),
(61, 'testte', 'test', 20, 100, 49),
(62, 'testte', 'test', 20, 100, 49),
(63, '', '', 20, 50, 43),
(64, 'ead', 'ezea', 20, 100, 49),
(65, 'WEB1', 'Webdevelopment', 20, 50, 32),
(66, 'Test 1', 'test 1', 20, 50, 57),
(67, 'Test 2', 'test 2', 20, 25, 57),
(68, 'test 3', 'Test 3', 20, 25, 57),
(69, 'fzeffzefe', 'fezfzefezf', 20, 100, 27),
(70, 'fzeffzefe', 'fezfzefezf', 20, 100, 27),
(71, 'test', '', 20, 100, 38),
(72, 'H1', 'RAM', 20, 100, 63),
(73, '15151', 'Bla', 20, 100, 64),
(74, 'H2', 'ROM', 20, 50, 63),
(75, 'H1', 'ROM', 20, 50, 65),
(78, 'H2', 'RAM', 20, 50, 65),
(79, 'WEB2', 'Webdevelopment', 20, 50, 32),
(80, 'P1', 'Language', 20, 100, 67),
(81, 'P2', 'Presentation', 20, 50, 67),
(82, 'P1', 'Project', 20, 100, 68);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `training` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_ibfk_1` (`training`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=92 ;

--
-- Gegevens worden uitgevoerd voor tabel `course`
--

INSERT INTO `course` (`id`, `name`, `training`) VALUES
(27, '1BA Kleuteronderwijs', 1),
(28, '2BA Kleuteronderwijs', 1),
(29, '3BA Kleuteronderwijs', 1),
(30, '1BA Lager Onderwijs', 2),
(31, '2BA Lager Onderwijs', 2),
(32, '3BA Lager Onderwijs', 2),
(33, '1BA Secundair Onderwijs', 3),
(34, '2BA Secundair Onderwijs', 3),
(35, '3BA Secundair Onderwijs', 3),
(36, '1BA Biomedische Laboratoriumtechnologie', 4),
(37, '2BA Biomedische Laboratoriumtechnologie', 4),
(38, '3BA Biomedische Laboratoriumtechnologie', 4),
(39, '1BA Bedrijfsmanagement', 5),
(40, '2BA Bedrijfsmanagement', 5),
(41, '3BA Bedrijfsmanagement', 5),
(42, '1BA Communicatiemanagement', 6),
(43, '2BA Communicatiemanagement', 6),
(44, '3BA Communicatiemanagement', 6),
(45, '1BA Energiemanagement', 7),
(46, '2BA EnergieManagement', 7),
(47, '3BA Energiemanagement', 7),
(48, '1BA Ergotherapie', 8),
(49, '2BA Ergotherapie', 8),
(50, '3BA Ergotherapie', 8),
(51, '1BA Industrieel Ontwerpen', 9),
(52, '2BA Industrieel Ontwerpen', 9),
(53, '3BA Industrieel Ontwerpen', 9),
(54, '1BA Journalistiek', 10),
(55, '2BA Journalistiek', 10),
(56, '3BA Journalistiek', 10),
(57, '1BA Digital Arts & Entertainment', 11),
(58, '2BA Digital Arts & Entertainment', 11),
(59, '3BA Digital Arts & Entertainment', 11),
(60, '1BA Netwerkeconomie', 15),
(61, '2BA Netwerkeconomie', 15),
(62, '3BA Netwerkeconomie', 15),
(63, '1BA Office Management', 16),
(64, '2BA Office Management', 16),
(65, '3BA office Management', 16),
(66, '1BA Toegepaste Informatica', 18),
(67, '2BA Toegepaste Informatica', 18),
(68, '3BA Toegepaste Informatica', 18),
(69, '1BA Sport en Bewegen', 20),
(70, '2BA Sport en Bewegen', 20),
(71, '3BA Sport en Bewegen', 20),
(72, '1BA Sociaal Werk', 21),
(73, '2BA Sociaal Werk', 21),
(74, '3BA Sociaal Werk', 21),
(75, '1BA Sociaal Werk', 22),
(76, '2BA Sociaal Werk', 22),
(77, '3BA Sociaal Werk', 22),
(78, '1BA Toegepaste Architectuur', 25),
(79, '2BA Toegepaste Architectuur', 25),
(80, '3BA Toegepaste Architectuur', 25),
(81, '1BA Toegepaste Gezondheidswetenschappen', 26),
(82, '2BA Toegepaste Gezondheidswetenschappen', 26),
(83, '3BA Toegepaste Gezondheidswetenschappen', 26),
(84, '1BA Toegepaste Psychologie', 27),
(85, '2BA Toegepaste Psychologie', 27),
(86, '3BA Toegepaste Psychologie', 27),
(87, '1BA Toerisme en Recreatiemanagement', 28),
(88, '2BA Toerisme en Recreatiemanagement', 28),
(89, '3BA Toerisme en Recreatiemanagement', 28),
(90, '1BA Verpleegkunde', 29),
(91, '2BA Verpleegkunde', 29);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `course_rapport`
--

CREATE TABLE IF NOT EXISTS `course_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=112 ;

--
-- Gegevens worden uitgevoerd voor tabel `course_rapport`
--

INSERT INTO `course_rapport` (`id`, `code`, `name`, `description`, `active`) VALUES
(1, 'Fr2', 'Frans 2', 'Frans voor de 2e graad', 1),
(2, 'Ger', 'German', 'Duitse taal', 1),
(3, 'En', 'Engels', 'Engelse taal', 1),
(26, 'Dr', 'Drummen', 'Drummen in het Nederlands', 1),
(28, 'Dr', 'Drumming', 'Drumming in English', 1),
(44, 'Ch', 'Chinese', 'Chinese grammar', 1),
(45, 'Jp', 'Japanese', 'Japanese grammar', 1),
(46, 'Kr', 'Korean', 'Korean grammar', 1),
(63, 'ICT', 'Informatics', 'Informatics for first grade', 1),
(97, 'BA', 'Bow and Arrow', 'Boogschieten', 1),
(108, 'testt', 'test', 'test', 0),
(111, 'Fr3', 'Frans 3', 'Frans 3e graad', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `course_studentlist_teacher_rapport`
--

CREATE TABLE IF NOT EXISTS `course_studentlist_teacher_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course` int(11) NOT NULL,
  `studentlist` int(11) NOT NULL,
  `teacher` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `course` (`course`,`studentlist`,`teacher`),
  UNIQUE KEY `course_2` (`course`,`studentlist`,`teacher`),
  KEY `teacher` (`teacher`),
  KEY `studentlist` (`studentlist`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=103 ;

--
-- Gegevens worden uitgevoerd voor tabel `course_studentlist_teacher_rapport`
--

INSERT INTO `course_studentlist_teacher_rapport` (`id`, `course`, `studentlist`, `teacher`, `active`) VALUES
(1, 1, 1, 12, 0),
(2, 1, 2, 12, 0),
(4, 1, 3, 12, 0),
(5, 1, 6, 15, 0),
(6, 1, 7, 15, 0),
(7, 2, 2, 12, 1),
(77, 2, 1, 14, 1),
(79, 1, 1, 1, 0),
(84, 108, 12, 6, 1),
(85, 1, 12, 5, 0),
(86, 2, 12, 5, 1),
(87, 2, 12, 3, 1),
(89, 1, 13, 14, 1),
(90, 1, 13, 16, 1),
(91, 1, 13, 12, 1),
(92, 1, 13, 11, 0),
(93, 2, 16, 16, 1),
(94, 1, 13, 15, 1),
(99, 2, 13, 11, 1),
(100, 111, 17, 16, 1),
(101, 111, 17, 15, 1),
(102, 111, 13, 15, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `criteria_rapport`
--

CREATE TABLE IF NOT EXISTS `criteria_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `doelstelling` int(11) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `doelstelling` (`doelstelling`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Subcompetentie van competentie' AUTO_INCREMENT=39 ;

--
-- Gegevens worden uitgevoerd voor tabel `criteria_rapport`
--

INSERT INTO `criteria_rapport` (`id`, `name`, `description`, `doelstelling`, `Active`) VALUES
(1, 'Franse ''R''', 'Kan deze persoon de Franse R goed uitspreken', 1, 0),
(2, 'Luid spreken', 'Luid kunnen spreken', 2, 1),
(3, 'geen inkt morsen', 'geen inkt morsen', 3, 1),
(4, 'present tenses', 'heden tijd', 4, 1),
(5, 'past tenses', 'verleden tijd', 4, 1),
(35, 'lastivallen', 'De leerling valt geen klasgenoten lastig.', 100, 1),
(36, 'lastivallen', 'De leerling valt geen klasgenoten lastig.', 101, 1),
(37, 'lastivallen', 'De leerling valt geen klasgenoten lastig.', 102, 1),
(38, 'german s', '', 103, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `documenttype`
--

CREATE TABLE IF NOT EXISTS `documenttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(500) NOT NULL,
  `amount_required` int(2) NOT NULL,
  `weight` int(3) NOT NULL,
  `project` int(11) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- Gegevens worden uitgevoerd voor tabel `documenttype`
--

INSERT INTO `documenttype` (`id`, `description`, `amount_required`, `weight`, `project`, `locked`) VALUES
(33, 'Grondplannen', 4, 20, 1, 0),
(34, 'Dakenplan', 1, 15, 1, 0),
(35, 'snedes', 4, 25, 1, 0),
(36, 'gevels', 2, 20, 1, 0),
(37, 'rioleringsschema', 1, 20, 1, 0),
(38, 'funderingsschema', 1, 20, 1, 0),
(39, 'isometriÃ«n van dakkapel', 2, 15, 1, 0),
(40, 'voldoende details', 2, 15, 1, 0),
(41, 'projectbundel', 1, 15, 1, 0),
(42, 'goed gekozen doorsnedes', 2, 15, 1, 0),
(47, 'Projectdocument', 1, 50, 35, 0),
(48, 'Zipfile', 1, 50, 35, 0),
(49, 'Grondplannen', 4, 20, 37, 0),
(59, 'Goed gekozen doorsnedes ifv moeilijkheid knooppunten', 2, 15, 37, 0),
(60, 'oihoi', 100, 100, 46, 0),
(61, 'test5', 544, 50, 49, 0),
(62, 'Eerste webpagina', 1, 50, 32, 0),
(63, 'Tweede webpagina', 1, 50, 32, 0),
(66, 'First Document', 1, 50, 65, 0),
(67, 'Source Code', 1, 50, 67, 0),
(68, 'Presentation', 2, 50, 67, 0),
(69, 'Source', 1, 50, 68, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `doelstelling_rapport`
--

CREATE TABLE IF NOT EXISTS `doelstelling_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `module` int(11) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `module` (`module`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='subcompetentie van score' AUTO_INCREMENT=106 ;

--
-- Gegevens worden uitgevoerd voor tabel `doelstelling_rapport`
--

INSERT INTO `doelstelling_rapport` (`id`, `name`, `description`, `module`, `Active`) VALUES
(1, 'Onderwerp', 'De leerling kan op beschrijvend niveau het onderwerp bepalen.', 1, 1),
(2, 'stemvolume', 'qdqsd', 1, 0),
(3, 'Schoonschrift', 'Mooi schrijven', 2, 1),
(4, 'grammatica', 'grammatica', 5, 1),
(5, 'zinsbouw', 'mooie zinnen', 5, 1),
(6, 'Engelse ''R''', 'uitspraak van ''R''', 6, 1),
(92, 'uitspraak van de klinkers', 'Juiste uitspraak van de klinkers', 57, 1),
(94, 'Van croissants houden', 'Veel croissants eten', 59, 0),
(95, 'analyse', '', 60, 1),
(96, 'analyse', '', 61, 1),
(98, 'onderwerp', 'De leerling kan op beschrijvend niveau het onderwerp bepalen.', 59, 1),
(99, 'hoofdgedachte', 'De leerling kan op beschrijvend niveau de hoofdgedachte achterhalen.', 59, 1),
(100, 'concentratie', 'De leerling kan zich blijven concentreren ook al begrijpt die niet alles.', 59, 1),
(101, 'concentratie', 'De leerling kan zich blijven concentreren ook al begrijpt die niet alles.', 59, 1),
(102, 'concentratie', 'De leerling kan zich blijven concentreren ook al begrijpt die niet alles.', 59, 1),
(103, 'german pronounciation', '', 63, 1),
(104, 'Onderwerp', 'De leerling kan op beschrijvend niveau het onderwerp bepalen.', 64, 1),
(105, 'Onderwerp', 'De leerling kan op beschrijvend niveau het onderwerp bepalen.', 66, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `email`
--

CREATE TABLE IF NOT EXISTS `email` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `user_id` int(99) NOT NULL,
  `adress` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `registration` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `email_ibfk_1` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Gegevens worden uitgevoerd voor tabel `email`
--

INSERT INTO `email` (`id`, `user_id`, `adress`, `type`, `registration`) VALUES
(1, 1, 'daan@dptechnics.com', 'PERSONAL', 1),
(2, 2, 'matthieu.calie@gmail.com', 'PERSONAL', 1),
(3, 3, 'daan.pape@student.howest.be', 'PERSONAL', 1),
(4, 4, 'aryan.eimermacher@student.howest.be', 'PERSONAL', 1),
(5, 5, 'matthieu.calie1@gmail.com', 'PERSONAL', 1),
(6, 6, 'jonas.vanalderweireldt@student.howest.be', 'PERSONAL', 1),
(7, 7, 'niels.verhaegen@student.howest.be', 'PERSONAL', 1),
(8, 8, 'glenn.matthys@student.howest.be', 'PERSONAL', 1),
(10, 10, 'jenox@hotmail.com', 'PERSONAL', 1),
(11, 11, 'Zhiyuan.chou@student.howest.be', 'PERSONAL', 1),
(12, 12, 'thomas.de.wispelaere@student.howest.be', 'PERSONAL', 1),
(13, 13, 'mathias.verbanck@student.howest.be', 'PERSONAL', 1),
(14, 14, 'dirk.vandycke@howest.be', 'PERSONAL', 1),
(15, 15, 'joachim.cromheecke@student.howest.be', 'PERSONAL', 1),
(16, 16, 'mathiasverbanck@gmail.com', 'PERSONAL', 1),
(17, 17, 'christian.toisoul@gharial.be', 'PERSONAL', 1),
(22, 22, 'nielsvverhaegen@gmail.com', 'PERSONAL', 1),
(23, 23, 'test@test.test', 'PERSONAL', 1),
(25, 25, 'test@test.tes', 'PERSONAL', 1),
(26, 26, 'test@jonas.com', 'PERSONAL', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `emailtemplates`
--

CREATE TABLE IF NOT EXISTS `emailtemplates` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `tag` varchar(20) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `plain` varchar(5000) NOT NULL,
  `html` varchar(5000) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `replyto` varchar(100) NOT NULL DEFAULT 'info@dptechnics.com',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Gegevens worden uitgevoerd voor tabel `emailtemplates`
--

INSERT INTO `emailtemplates` (`id`, `tag`, `lang`, `subject`, `plain`, `html`, `sender`, `replyto`) VALUES
(1, 'activation', 'EN', 'Grader account activation', 'Hello {firstname} {lastname},\n\nThank you for registering for a DPTechnics account. Please activate\nyour account by following this link:\n\n{link}\n\nIf you can''t click, please copy and paste it into your browser. \n\nKind regards,\nThe DPTechnics Team', 'Hello {firstname} {lastname},<br/><br/>\n\n<p>\nThank you for registering for a DPTechnics account. Please activate\nyour account by following this link:\n</p>\n<br/>\n<a href="{link}">{link}</a>\n<br/>\n<p>\nIf you can''t click, please copy and paste it into your browser. \n</p>\n<br/>\nKind regards,<br/>\nThe DPTechnics Team', 'accounts.grader@howest.be', 'info@howest.be');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `indicator`
--

CREATE TABLE IF NOT EXISTS `indicator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `max` int(3) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `subcompetence` int(11) NOT NULL,
  `pointType` varchar(30) NOT NULL DEFAULT 'Slider',
  PRIMARY KEY (`id`),
  KEY `indicator_ibfk_1` (`subcompetence`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=88 ;

--
-- Gegevens worden uitgevoerd voor tabel `indicator`
--

INSERT INTO `indicator` (`id`, `name`, `description`, `max`, `weight`, `subcompetence`, `pointType`) VALUES
(1, 'ind1', 'i1', 20, 100, 1, 'Slider'),
(2, 'ind2', 'i2', 20, 100, 2, 'Slider'),
(3, 'ind3', 'i3', 20, 100, 3, 'Slider'),
(4, 'ind4', 'i4', 20, 100, 4, 'Slider'),
(5, 'ind2', 'i2', 20, 100, 1, 'Slider'),
(6, 'ind2', 'i2', 20, 100, 1, 'Slider'),
(7, 'ind2', 'i2', 20, 100, 1, 'Slider'),
(8, 'test', 'test', 20, 100, 1, 'Slider'),
(9, 'test', 'test', 20, 100, 1, 'Slider'),
(10, 'test', 'test', 20, 100, 1, 'Slider'),
(11, 'Knooppunten', 'leesbaarheid van knooppunt, verloop van de folies', 20, 50, 7, 'Slider'),
(12, 'Grafische kwaliteit tekst', 'Grafische kwaliteit van tekst bemating en peilen', 20, 50, 7, 'Slider'),
(13, 'Grafische kwaliteit plannen, details, gevels en snedes', 'in functie van schaaln', 20, 100, 7, 'Slider'),
(14, 'Draagstructuur', 'uitvoerbaar, logisch opgelost, begrijpt de student de draagstructuur?', 20, 25, 8, 'Slider'),
(15, 'Inzicht', 'Gekozen samenstellingen van vloeren, wanden, daken en knooppunten van verschillende onderdelen. Winddichtheid, luchtdichtheid, acoustische ontkoppeling, koudebruggen.', 20, 25, 8, 'Slider'),
(16, 'Logica', 'riolering en regenwaterafvoering', 20, 25, 8, 'Slider'),
(17, 'Overzicht', 'Student toont aan dat hij het belang van correcte en voldoende bemating en peilen begrijpt in functie van een uitvoeringsdossier', 20, 25, 8, 'Slider'),
(18, '', '', 20, 100, 8, 'Slider'),
(19, 'CMS', 'CMS', 20, 100, 9, 'Slider'),
(20, 'JS', 'JS', 20, 100, 9, 'Slider'),
(21, 'CMS', 'CMS', 20, 100, 10, 'Slider'),
(22, 'JS', 'JS', 20, 100, 10, 'Slider'),
(23, 'test 1', '', 20, 25, 11, 'Slider'),
(24, 'efe', 'fefe', 20, 100, 16, 'Slider'),
(25, 'efe', 'fefe', 20, 100, 17, 'Slider'),
(26, 'efe', 'fefe', 20, 100, 18, 'Slider'),
(27, 'efe', 'fefe', 20, 100, 19, 'Slider'),
(28, 'efe', 'fefe', 20, 100, 20, 'Slider'),
(29, 'efe', 'fefe', 20, 100, 21, 'Slider'),
(30, 'efe', 'fefe', 20, 100, 22, 'Slider'),
(31, 'efe', 'fefe', 20, 100, 23, 'Slider'),
(32, 'efe', 'fefe', 20, 100, 24, 'Slider'),
(33, 'efe', 'fefe', 20, 100, 25, 'Slider'),
(34, 'efe', 'fefe', 20, 100, 26, 'Slider'),
(35, 'efe', 'fefe', 20, 100, 27, 'Slider'),
(36, 'efe', 'fefe', 20, 100, 28, 'Slider'),
(37, 'efe', 'fefe', 20, 100, 29, 'Slider'),
(38, 'efe', 'fefe', 20, 100, 30, 'Slider'),
(39, 'efe', 'fefe', 20, 100, 31, 'Slider'),
(40, 'efe', 'fefe', 20, 100, 32, 'Slider'),
(41, 'efe', 'fefe', 20, 100, 33, 'Slider'),
(42, 'efe', 'fefe', 20, 100, 34, 'Slider'),
(43, 'efe', 'fefe', 20, 100, 35, 'Slider'),
(44, 'efe', 'fefe', 20, 100, 36, 'Slider'),
(45, 'efe', 'fefe', 20, 100, 37, 'Slider'),
(55, 'test lock 1', '', 20, 25, 11, 'Slider'),
(56, 'test lock 2', '', 20, 25, 11, 'Slider'),
(57, '', '', 20, 25, 11, 'Slider'),
(58, '', '', 20, 33, 47, 'Slider'),
(59, '', '', 20, 33, 47, 'Slider'),
(60, '', '', 20, 33, 47, 'Slider'),
(61, 'deadadadea', 'dededed', 20, 0, 48, 'Slider'),
(62, 'aeddea', 'dededed', 20, 0, 48, 'Slider'),
(63, 'Select', 'Kennis van select-tag', 20, 50, 50, 'Slider'),
(64, 'Input', 'Kennis van input-tag', 20, 50, 50, 'Slider'),
(65, 'ind 1', 'ind 1', 20, 50, 51, 'Slider'),
(66, 'ind 2', 'ind 2', 20, 25, 51, 'Slider'),
(67, 'ind 3', 'ind 3', 20, 25, 51, 'Slider'),
(68, 'ind 4', 'ind 4', 20, 100, 52, 'Slider'),
(69, 'ind 1 ', 'ind 1', 20, 100, 53, 'Slider'),
(70, 'sub 1', 'sub 1', 20, 100, 54, 'Slider'),
(73, 'H1.1.1', 'Afkorting', 20, 100, 59, 'Slider'),
(79, 'H1.2.1', 'Afkorting', 20, 100, 63, 'Slider'),
(81, 'Body', 'Kennis van body tag', 20, 100, 65, 'Slider'),
(82, 'P1.1.1', 'Verbs', 20, 50, 66, 'Slider'),
(83, 'P1.1.2', 'Voc', 20, 50, 66, 'Slider'),
(84, 'P1.2.1', 'Verbs', 20, 50, 67, 'Slider'),
(85, 'P1.2.2', 'Voc', 20, 50, 67, 'Slider'),
(86, 'P2.1.1', 'Slides', 20, 100, 68, 'Slider'),
(87, 'P1.1.1', 'Powerpoint', 20, 100, 69, 'Punten');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `lastdropdown`
--

CREATE TABLE IF NOT EXISTS `lastdropdown` (
  `user` int(99) NOT NULL,
  `location` varchar(255) NOT NULL,
  `locationid` int(99) NOT NULL,
  `training` varchar(255) NOT NULL,
  `trainingid` int(99) NOT NULL,
  `course` varchar(255) NOT NULL,
  `courseid` int(99) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden uitgevoerd voor tabel `lastdropdown`
--

INSERT INTO `lastdropdown` (`user`, `location`, `locationid`, `training`, `trainingid`, `course`, `courseid`) VALUES
(1, 'Howest - RSS', 1, 'Toegepaste Informatica', 18, '1BA Toegepaste Informatica', 66),
(2, 'Howest - RSS', 1, 'Toegepaste Informatica', 18, '1BA Toegepaste Informatica', 66),
(6, 'Howest - RSS', 1, 'Toegepaste Architectuur', 25, '3BA Toegepaste Architectuur', 80),
(7, 'Howest - RSS', 1, 'Toegepaste Architectuur', 25, '2BA Toegepaste Architectuur', 79),
(8, 'Howest - RSS', 1, 'Toegepaste Informatica', 18, '1BA Toegepaste Informatica', 66),
(11, 'Howest - RSS', 1, 'Bedrijfsmanagement', 5, '1BA Bedrijfsmanagement', 39),
(12, 'Howest - RSS', 1, 'Toegepaste Informatica', 18, '1BA Toegepaste Informatica', 66),
(15, 'Howest - GKG', 3, 'Industrieel Productontwerpen', 9, '1BA Industrieel Ontwerpen', 51),
(16, 'Howest - RSS', 1, 'Bedrijfsmanagement', 5, '1BA Bedrijfsmanagement', 39),
(17, 'Howest - Oostende', 6, 'Toegepaste Gezondheidswetenschappen', 26, '3BA Toegepaste Gezondheidswetenschappen', 83);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `lastdropdownRapport`
--

CREATE TABLE IF NOT EXISTS `lastdropdownRapport` (
  `user` int(11) NOT NULL,
  `course` varchar(255) DEFAULT NULL,
  `courseid` int(11) DEFAULT NULL,
  `studentlist` varchar(255) DEFAULT NULL,
  `studentlistid` int(11) DEFAULT NULL,
  `student` varchar(255) DEFAULT NULL,
  `studentid` int(11) DEFAULT NULL,
  `courseidworksheet` int(11) DEFAULT NULL,
  `courseworksheet` int(11) DEFAULT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='lastdropdown tabel voor de asses van het rapportensysteem';

--
-- Gegevens worden uitgevoerd voor tabel `lastdropdownRapport`
--

INSERT INTO `lastdropdownRapport` (`user`, `course`, `courseid`, `studentlist`, `studentlistid`, `student`, `studentid`, `courseidworksheet`, `courseworksheet`) VALUES
(2, 'testdata2april', 64, '', 0, 'Student', 0, NULL, NULL),
(8, 'Frans', 1, '', 0, 'Zhiyuan Chou', 11, NULL, NULL),
(11, 'German', 2, 'Frans 2e graad', 13, 'Joachim Cromheecke', 15, NULL, NULL),
(12, 'Frans 2', 1, 'Frans 2e graad', 13, 'Mathias Verbanck', 13, NULL, NULL),
(15, 'Frans 2', 1, 'Frans 2e graad', 13, 'Zhiyuan Chou', 11, NULL, NULL),
(16, 'Frans 3', 111, 'Frans 3e graad', 17, 'Thomas De Wispelaere', 12, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Gegevens worden uitgevoerd voor tabel `location`
--

INSERT INTO `location` (`id`, `name`) VALUES
(1, 'Howest - RSS'),
(2, 'Howest - RDR'),
(3, 'Howest - GKG'),
(4, 'Howest - SJS'),
(5, 'UGent - GKG'),
(6, 'Howest - Oostende');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `module_rapport`
--

CREATE TABLE IF NOT EXISTS `module_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `course` int(99) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `course` (`course`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='modules van 1 vak' AUTO_INCREMENT=68 ;

--
-- Gegevens worden uitgevoerd voor tabel `module_rapport`
--

INSERT INTO `module_rapport` (`id`, `name`, `description`, `course`, `Active`) VALUES
(1, 'Luisteren', 'Luister Ervaring in het frans', 1, 1),
(2, 'Frans schrijven', '1e testcompetentie', 1, 0),
(3, 'Duits spreken', 'Duits spreken', 2, 1),
(4, 'Duits schrijven', 'Duits schrijven', 2, 1),
(5, 'Engels schrijven', 'praten', 3, 1),
(6, 'Engels praten', 'schrijven', 3, 1),
(45, 'Algemene doelstellingen', '', 63, 1),
(49, 'Opbouw drum kennen', 'Weten hoe een drumstel in mekaar zit', 26, 1),
(50, 'Drum spelen', 'Praktijk', 26, 1),
(57, 'Koreaans spreken', 'Juiste uitspraak', 46, 1),
(59, 'Lezen', 'Kan vlot Franse tekst lezen', 1, 1),
(60, 'projecten', '', 108, 1),
(61, 'projecten', '', 108, 1),
(63, 'german speaking', '', 2, 1),
(64, 'Luisteren', 'Luister Ervaring in het frans', 111, 1),
(65, 'Lezen', 'Kan vlot Franse tekst lezen', 111, 1),
(66, 'Luisteren', 'Luister Ervaring in het frans', 111, 1),
(67, 'Lezen', 'Kan vlot Franse tekst lezen', 111, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Gegevens worden uitgevoerd voor tabel `permissions`
--

INSERT INTO `permissions` (`id`, `permission`) VALUES
(1, ''),
(2, 'home'),
(3, 'assess'),
(4, 'courses'),
(5, 'projects'),
(6, 'api/*'),
(8, 'register'),
(9, 'checkemail'),
(10, 'activate/*'),
(11, 'login/*'),
(12, 'logout'),
(13, 'project/*'),
(14, 'project/*'),
(15, 'assess/project/*'),
(16, 'account/*'),
(17, 'upload'),
(18, 'student/*'),
(19, 'admin/*'),
(20, 'coursesrapporten'),
(21, 'homerapporten'),
(22, 'assessrapporten'),
(23, 'account'),
(24, 'studentrapportrapporten'),
(25, 'coursecompetence/*'),
(26, 'worksheetrapporten');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `year` date NOT NULL,
  `course` int(11) NOT NULL,
  `document` int(11) NOT NULL,
  `nrOfAssessing` int(11) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- Gegevens worden uitgevoerd voor tabel `project`
--

INSERT INTO `project` (`id`, `code`, `name`, `description`, `year`, `course`, `document`, `nrOfAssessing`) VALUES
(1, 'GP4.7', 'Stage', 'Stage Kleuteronderwijs', '0000-00-00', 27, 0, 2),
(31, 'GPbladibla', 'bladibladibla', 'blablalba', '0000-00-00', 39, 0, 2),
(32, 'Prog 1', 'Website', 'Build website', '0000-00-00', 66, 0, 2),
(37, 'GP45', 'Module GP4', 'Uitvoeringsdossier met uitvoeringsdetails', '0000-00-00', 80, 0, 2),
(38, 'OP1', 'Onderzoeksproject', 'Onderzoeksprojecten van de studenten', '0000-00-00', 68, 0, 2),
(39, 'PPR', 'Paper Vendor Management', 'Per groep van 4 personen', '0000-00-00', 68, 0, 2),
(40, 'SPD', 'Sharepoint development', 'Projecten', '0000-00-00', 68, 0, 2),
(47, 'FR', 'Frans', 'Franse taal leren :)', '0000-00-00', 80, 0, 2),
(49, 'deded', 'dededdede', 'deded', '0000-00-00', 58, 0, 2),
(50, 'test', 'Test', 'Testproject', '0000-00-00', 62, 0, 2),
(51, 'Fr1', 'Frans1', 'Frans voor het 1e jaar', '0000-00-00', 52, 0, 2),
(52, 'Non odit N', 'Noelle Holman', 'Et et alias culpa ea aliqua Voluptas', '0000-00-00', 39, 0, 2),
(53, 'Numquam as', 'Nissim Padilla', 'Maxime praesentium sapiente sit mollitia', '0000-00-00', 51, 0, 2),
(54, 'Fr', 'Frans', 'taal', '0000-00-00', 0, 0, 2),
(57, 'test', 'test', 'test', '0000-00-00', 78, 0, 2),
(58, 'msdjkf', 'mslkqdfj', 'msdfkljf', '0000-00-00', 5, 0, 2),
(60, '008', 'brom', 'jomes brom', '0000-00-00', 52, 0, 2),
(65, 'H1', 'Hardware', 'Hardware', '0000-00-00', 66, 0, 2),
(67, 'P1', 'Project', 'Programming project', '0000-00-00', 67, 0, 2),
(68, 'P1', 'Project', 'Programming Project', '0000-00-00', 79, 0, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `project_studentlist`
--

CREATE TABLE IF NOT EXISTS `project_studentlist` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `project` int(11) NOT NULL,
  `studentlist` int(99) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Gegevens worden uitgevoerd voor tabel `project_studentlist`
--

INSERT INTO `project_studentlist` (`id`, `project`, `studentlist`) VALUES
(14, 37, 16),
(15, 46, 18),
(16, 48, 18),
(17, 49, 18),
(19, 29, 19),
(20, 32, 17),
(21, 31, 18),
(22, 65, 20),
(23, 67, 20),
(24, 68, 20);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Gegevens worden uitgevoerd voor tabel `roles`
--

INSERT INTO `roles` (`id`, `role`, `description`) VALUES
(1, 'GUEST', 'When not logged in you get the GUEST role. '),
(2, 'SUPERUSER', 'The superuser role must have access to everything. '),
(3, 'USER', 'Contains rights for every USER in the system'),
(4, 'STUDENT', 'Can only do studentactions');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `role_permissions`
--

CREATE TABLE IF NOT EXISTS `role_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(99) NOT NULL,
  `permission_id` int(99) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_permissions_ibfk_2` (`permission_id`),
  KEY `role_permissions_ibfk_1` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Gegevens worden uitgevoerd voor tabel `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(7, 1, 6),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 2, 13),
(14, 3, 14),
(15, 3, 15),
(16, 3, 16),
(17, 3, 17),
(18, 1, 18),
(19, 1, 18),
(20, 2, 19),
(21, 3, 20),
(22, 3, 21),
(23, 3, 22),
(24, 3, 23),
(25, 3, 24),
(26, 3, 25),
(27, 3, 26);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rules`
--

CREATE TABLE IF NOT EXISTS `rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  `operator` varchar(10) NOT NULL,
  `value` int(11) NOT NULL,
  `sign` varchar(500) NOT NULL,
  `result` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `rules_ibfk_1` (`project`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Gegevens worden uitgevoerd voor tabel `rules`
--

INSERT INTO `rules` (`id`, `project`, `name`, `subject`, `subject_id`, `action`, `operator`, `value`, `sign`, `result`) VALUES
(17, 37, 'Test Rule', 'subcompetence', 7, 'Lay-out opmaken', '<', 80, '-', 50),
(20, 32, 'Web', 'indicator', 63, 'Kennis van select-tag', '<', 80, '-', 10),
(22, 67, 'Rule', 'subcompetence', 67, 'French', '<', 50, '-', 10),
(23, 68, 'Rule', 'indicator', 87, 'Powerpoint', '<', 60, '-', 10);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `studentlist`
--

CREATE TABLE IF NOT EXISTS `studentlist` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `owner` int(99) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `studentlist_ibfk_1` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Gegevens worden uitgevoerd voor tabel `studentlist`
--

INSERT INTO `studentlist` (`id`, `owner`, `name`) VALUES
(16, 1, 'Howest Brugge - TI5'),
(17, 2, 'Studenten TA'),
(18, 11, 'Zhiyuan - New User List '),
(19, 16, 'Mathias - New User List '),
(20, 7, '2BA Toegepaste Informatica');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `studentlist_rapport`
--

CREATE TABLE IF NOT EXISTS `studentlist_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Gegevens worden uitgevoerd voor tabel `studentlist_rapport`
--

INSERT INTO `studentlist_rapport` (`id`, `owner`, `name`, `Active`) VALUES
(1, 12, 'Studenten_Frans', 1),
(2, 12, 'Studenten_Duits', 1),
(3, 12, 'Studenten_Engels', 1),
(6, 15, 'Studenten_Jetair', 1),
(7, 15, 'Studenten_Koreaans', 1),
(9, 15, 'Studenten_Japans', 1),
(12, 11, 'groep 3', 1),
(13, 16, 'Frans 2e graad', 1),
(14, 16, 'Spaans 3e graad', 1),
(15, 16, 'PC-Technieken', 1),
(16, 16, 'BandenMonteurs', 1),
(17, 16, 'Frans 3e graad', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `studentlist_students`
--

CREATE TABLE IF NOT EXISTS `studentlist_students` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `studentlist` int(99) NOT NULL,
  `student` int(99) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=772 ;

--
-- Gegevens worden uitgevoerd voor tabel `studentlist_students`
--

INSERT INTO `studentlist_students` (`id`, `studentlist`, `student`) VALUES
(592, 16, 239),
(593, 16, 240),
(594, 16, 241),
(595, 16, 242),
(596, 16, 243),
(597, 16, 244),
(598, 16, 245),
(599, 16, 246),
(600, 16, 247),
(601, 16, 248),
(602, 16, 249),
(603, 16, 250),
(604, 16, 251),
(605, 16, 252),
(606, 16, 253),
(607, 16, 254),
(608, 16, 255),
(609, 16, 256),
(610, 16, 257),
(611, 16, 258),
(612, 16, 259),
(613, 16, 260),
(614, 16, 261),
(615, 16, 262),
(616, 16, 263),
(617, 16, 264),
(618, 16, 265),
(619, 16, 266),
(620, 16, 267),
(621, 16, 268),
(622, 16, 269),
(623, 16, 270),
(624, 16, 271),
(625, 16, 272),
(626, 16, 273),
(627, 16, 274),
(628, 16, 275),
(629, 16, 276),
(630, 16, 277),
(631, 16, 278),
(632, 16, 279),
(633, 16, 280),
(635, 16, 282),
(636, 16, 283),
(637, 16, 284),
(638, 16, 285),
(639, 16, 286),
(640, 16, 287),
(641, 16, 288),
(642, 16, 289),
(643, 16, 290),
(644, 16, 291),
(645, 16, 292),
(646, 16, 293),
(647, 16, 294),
(648, 16, 295),
(649, 16, 296),
(650, 17, 415),
(651, 17, 239),
(652, 17, 240),
(653, 17, 241),
(654, 17, 242),
(655, 17, 243),
(656, 17, 244),
(657, 17, 245),
(658, 17, 246),
(659, 17, 247),
(660, 17, 248),
(661, 17, 249),
(662, 17, 250),
(663, 17, 251),
(664, 17, 252),
(665, 17, 253),
(666, 17, 254),
(667, 17, 255),
(668, 17, 256),
(669, 17, 257),
(670, 17, 258),
(671, 17, 259),
(672, 17, 260),
(673, 17, 261),
(674, 17, 262),
(675, 17, 263),
(676, 17, 264),
(677, 17, 265),
(678, 17, 266),
(679, 17, 267),
(680, 17, 268),
(681, 17, 269),
(682, 17, 270),
(683, 17, 271),
(684, 17, 272),
(685, 17, 273),
(686, 17, 274),
(687, 17, 275),
(688, 17, 276),
(689, 17, 277),
(690, 17, 278),
(691, 17, 279),
(692, 17, 280),
(693, 17, 281),
(694, 17, 282),
(695, 17, 283),
(696, 17, 284),
(697, 17, 285),
(698, 17, 286),
(699, 17, 287),
(700, 17, 288),
(701, 17, 289),
(702, 17, 290),
(703, 17, 291),
(704, 17, 292),
(705, 17, 293),
(706, 17, 294),
(707, 17, 295),
(708, 17, 296),
(709, 18, 416),
(710, 18, 417),
(711, 19, 418),
(712, 19, 419),
(713, 20, 415),
(714, 20, 239),
(715, 20, 240),
(716, 20, 241),
(717, 20, 242),
(718, 20, 243),
(719, 20, 244),
(720, 20, 245),
(721, 20, 246),
(722, 20, 247),
(723, 20, 248),
(724, 20, 249),
(725, 20, 250),
(726, 20, 251),
(727, 20, 252),
(728, 20, 253),
(729, 20, 254),
(730, 20, 255),
(731, 20, 256),
(732, 20, 257),
(733, 20, 258),
(734, 20, 259),
(735, 20, 260),
(736, 20, 261),
(737, 20, 262),
(738, 20, 263),
(739, 20, 264),
(740, 20, 265),
(741, 20, 266),
(742, 20, 267),
(743, 20, 268),
(744, 20, 269),
(745, 20, 270),
(746, 20, 271),
(747, 20, 272),
(748, 20, 273),
(749, 20, 274),
(750, 20, 275),
(751, 20, 276),
(752, 20, 277),
(753, 20, 278),
(754, 20, 279),
(755, 20, 280),
(756, 20, 281),
(757, 20, 282),
(758, 20, 283),
(759, 20, 284),
(760, 20, 285),
(761, 20, 286),
(762, 20, 287),
(763, 20, 288),
(764, 20, 289),
(765, 20, 290),
(766, 20, 291),
(767, 20, 292),
(768, 20, 293),
(769, 20, 294),
(770, 20, 295),
(771, 20, 296);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `studentlist_students_rapport`
--

CREATE TABLE IF NOT EXISTS `studentlist_students_rapport` (
  `studentlist` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`studentlist`,`user`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Verzameling van welke studenten in welke studentenlijst zitten.';

--
-- Gegevens worden uitgevoerd voor tabel `studentlist_students_rapport`
--

INSERT INTO `studentlist_students_rapport` (`studentlist`, `user`) VALUES
(1, 1),
(2, 1),
(1, 2),
(16, 2),
(2, 4),
(2, 6),
(3, 6),
(12, 6),
(2, 8),
(1, 11),
(13, 11),
(1, 12),
(3, 12),
(13, 12),
(17, 12),
(1, 13),
(13, 13),
(1, 15),
(3, 15),
(6, 15),
(13, 15),
(17, 15);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `studentlist_users`
--

CREATE TABLE IF NOT EXISTS `studentlist_users` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `studentlist` int(99) NOT NULL,
  `student` int(99) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `studentlist_users_ibfk_2` (`student`),
  KEY `studentlist_users_ibfk_1` (`studentlist`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=420 ;

--
-- Gegevens worden uitgevoerd voor tabel `students`
--

INSERT INTO `students` (`id`, `firstname`, `lastname`, `mail`) VALUES
(239, 'Sven', 'Beschuyt', 'Sven.Beschuyt@student.howest.be'),
(240, 'Thijs', 'Borra', 'Thijs.Borra@student.howest.be'),
(241, 'Patrick', 'Brunswyck', 'Patrick.Brunswyck@student.howest.be'),
(242, 'Colin', 'Bundervoet', 'Colin.Bundervoet@student.howest.be'),
(243, 'Aaron', 'Caenepeel', 'aaron.caenepeel@student.howest.be'),
(244, 'Matthieu', 'Calie', 'Matthieu.Calie@student.howest.be'),
(245, 'Zhiyuan', 'Chou', 'Zhiyuan.Chou@student.howest.be'),
(246, 'Elise', 'Christiaens', 'Elise.Christiaens@student.howest.be'),
(247, 'Alessio', 'Claeys', 'Alessio.Claeys@student.howest.be'),
(248, 'Yann', 'Collignon', 'Yann.Collignon@student.howest.be'),
(249, 'Koen', 'Cornelis', 'Koen.Cornelis@student.howest.be'),
(250, 'Kevin', 'De Coster', 'Kevin.De.Coster@student.howest.be'),
(251, 'Ken', 'De Moor', 'Ken.De.Moor@student.howest.be'),
(252, 'Jelle', 'De Witte', 'Jelle.De.Witte@student.howest.be'),
(253, 'William', 'Debruyn', 'William.Debruyn@student.howest.be'),
(254, 'Stijn', 'Decat', 'Stijn.Decat@student.howest.be'),
(255, 'Jonasi', 'Deetens', 'jonasi.deetens@student.howest.be'),
(256, 'Tim', 'Dekiere', 'Tim.Dekiere@student.howest.be'),
(257, 'Matthias', 'Deschacht', 'matthias.deschacht@student.howest.be'),
(258, 'Nathan', 'Desmet', 'Nathan.Desmet@student.howest.be'),
(259, 'Kenneth', 'Dhondt', 'kenneth.dhondt2@student.howest.be'),
(260, 'Aryan', 'Eimermacher', 'Aryan.Eimermacher@student.howest.be'),
(261, 'Michiel', 'Fielibert', 'Michiel.Fielibert@student.howest.be'),
(262, 'Stijn', 'Gheyle', 'stijn.gheyle@student.howest.be'),
(263, 'Jesse', 'Goethals', 'Jesse.Goethals@student.howest.be'),
(264, 'Niels', 'Gunst', 'Niels.Gunst@student.howest.be'),
(265, 'Jelle', 'Hanssens', 'Jelle.Hanssens@student.howest.be'),
(266, 'Philip', 'Hermans', 'Philip.Hermans@student.howest.be'),
(267, 'Stijn', 'Jonckheere', 'Stijn.Jonckheere2@student.howest.be'),
(268, 'Lenny', 'Knockaert', 'Lenny.Knockaert@student.howest.be'),
(269, 'Niels', 'Kuylle', 'niels.kuylle@student.howest.be'),
(270, 'Jens', 'Maeckelbergh', 'Jens.Maeckelbergh@student.howest.be'),
(271, 'Lorenzo', 'MartelÃ©', 'lorenzo.martele@student.howest.be'),
(272, 'Siglinde', 'Masselis', 'siglinde.masselis@howest.be'),
(273, 'Dylan', 'Moerman', 'dylan.moerman@student.howest.be'),
(274, 'Cynthia', 'Ongena', 'cynthia.ongena@student.howest.be'),
(275, 'Stijn', 'Ongenae', 'Stijn.Ongenae@student.howest.be'),
(276, 'Tsang Sing', 'Pang', 'tsang.sing.pang@student.howest.be'),
(277, 'Daan', 'Pape', 'Daan.Pape@student.howest.be'),
(278, 'Tiem', 'Pauwaert', 'tiem.pauwaert@student.howest.be'),
(279, 'Bryan', 'Schelstraete', 'bryan.schelstraete@student.howest.be'),
(280, 'Nele', 'Scherrens', 'Nele.Scherrens@student.howest.be'),
(281, 'Corneel', 'Theben Tervile', 'corneel.theben.tervile@howest.be'),
(282, 'Tim', 'Tijssens', 'tim.tijssens@student.howest.be'),
(283, 'Kris', 'Van de Voorde', 'Kris.Van.de.Voorde@student.howest.be'),
(284, 'Bastiaan', 'Van den Bussche', 'Bastiaan.Van.den.Bussche@student.howest.be'),
(285, 'Sander', 'Van Hyfte', 'Sander.Van.Hyfte@student.howest.be'),
(286, 'Alexander', 'Van Maele', 'Alexander.Van.Maele@student.howest.be'),
(287, 'Jelle', 'Vandendriessche', 'Jelle.Vandendriessche@student.howest.be'),
(288, 'Mathias', 'Vandewalle', 'mathias.vandewalle@student.howest.be'),
(289, 'Dirk', 'Vandycke', 'Dirk.Vandycke@howest.be'),
(290, 'Joris', 'Vanhecke', 'Joris.Vanhecke@student.howest.be'),
(291, 'Maxim', 'Vanhockerhout', 'Maxim.Vanhockerhout@student.howest.be'),
(292, 'Yo-Tina', 'Verbraecken', 'Yo-Tina.Verbraecken@student.howest.be'),
(293, 'Jonas', 'Vergison', 'Jonas.Vergison@student.howest.be'),
(294, 'Maarten', 'Vermue', 'Maarten.Vermue@student.howest.be'),
(295, 'Sander', 'Wallaert', 'Sander.Wallaert@student.howest.be'),
(296, 'Niels', 'Zwaenepoel', 'niels.zwaenepoel@student.howest.be'),
(415, 'Jannick', 'Ballegeer', 'jannick.ballegeer@student.howest.be'),
(416, 'test', 'test', 'jeiah@eidie.eifzeha'),
(417, 'ededd', 'dede', 'edjebde'),
(418, 'Patricia', 'Yates', 'konidap'),
(419, 'Cally', 'Carr', 'jyfaxosu');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `subcompetence`
--

CREATE TABLE IF NOT EXISTS `subcompetence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `description` varchar(500) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `max` int(3) NOT NULL,
  `min_required` int(3) NOT NULL,
  `competence` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- Gegevens worden uitgevoerd voor tabel `subcompetence`
--

INSERT INTO `subcompetence` (`id`, `code`, `description`, `weight`, `max`, `min_required`, `competence`) VALUES
(1, 'SUB1', 's1', 50, 20, 10, 1),
(2, 'SUB2', 's2', 50, 20, 10, 1),
(3, 'SUB3', 's3', 50, 20, 10, 2),
(4, 'SUB4', 's4', 50, 20, 10, 2),
(7, 'DC7.1', 'Lay-out opmaken', 100, 20, 10, 10),
(8, 'DC2.3', 'Samenstelling', 100, 20, 10, 11),
(9, 'Web', 'Web', 50, 20, 10, 12),
(10, 'Web', 'Web', 50, 20, 10, 13),
(11, 'Web', 'Web', 50, 20, 10, 14),
(12, '', '', 100, 20, 10, 16),
(13, '', '', 100, 20, 10, 18),
(14, '002', 'testsubcompetence', 100, 20, 10, 19),
(15, 'dead', 'dede', 100, 20, 10, 26),
(16, 'dead', 'dede', 100, 20, 10, 27),
(17, 'dead', 'dede', 100, 20, 10, 28),
(18, 'dead', 'dede', 100, 20, 10, 29),
(19, 'dead', 'dede', 100, 20, 10, 30),
(20, 'dead', 'dede', 100, 20, 10, 31),
(21, 'dead', 'dede', 100, 20, 10, 32),
(22, 'dead', 'dede', 100, 20, 10, 33),
(23, 'dead', 'dede', 100, 20, 10, 34),
(24, 'dead', 'dede', 100, 20, 10, 35),
(25, 'dead', 'dede', 100, 20, 10, 36),
(26, 'dead', 'dede', 100, 20, 10, 37),
(27, 'dead', 'dede', 100, 20, 10, 38),
(28, 'dead', 'dede', 100, 20, 10, 39),
(29, 'dead', 'dede', 100, 20, 10, 40),
(30, 'dead', 'dede', 100, 20, 10, 41),
(31, 'dead', 'dede', 100, 20, 10, 42),
(32, 'dead', 'dede', 80, 20, 10, 43),
(33, 'dead', 'dede', 80, 20, 10, 44),
(34, 'dead', 'dede', 80, 20, 10, 45),
(35, 'dead', 'dede', 80, 20, 10, 46),
(36, 'dead', 'dede', 80, 20, 10, 47),
(37, 'dead', 'dede', 80, 20, 10, 48),
(38, 'dead', 'dede', 80, 20, 10, 49),
(39, '', '', 17, 20, 10, 14),
(40, '', '', 17, 20, 10, 14),
(41, '', '', 17, 20, 10, 14),
(42, '', '', 33, 20, 10, 14),
(43, '', '', 33, 20, 10, 14),
(44, 'sub 2', 'sub 2', 17, 20, 10, 14),
(45, 'sub 3', 'sub 3', 17, 20, 10, 14),
(46, 'sub 4', 'sub 4', 17, 20, 10, 14),
(47, '', '', 50, 20, 10, 14),
(48, 'edad', 'ad', 50, 20, 10, 64),
(49, 'daed', 'dae', 50, 20, 10, 64),
(50, 'HTML', 'Kennis van HTML', 100, 20, 10, 65),
(51, 'Sub 1', 'sub 1', 50, 20, 10, 66),
(52, 'sub 2', 'sub 2', 50, 20, 10, 66),
(53, 'Sub 1', 'sub 1', 100, 20, 10, 67),
(54, 'sub1', 'sub 1', 100, 20, 10, 68),
(55, 'H1.1', 'DDR3', 100, 20, 10, 72),
(59, 'H1.1', 'ROM', 33, 20, 10, 75),
(63, 'H1.2', 'PROM', 33, 20, 10, 75),
(64, 'H1.3', 'EPROM', 33, 20, 10, 75),
(65, 'CSS', 'Kennis van CSS', 50, 20, 10, 65),
(66, 'P1.1', 'English', 50, 20, 10, 80),
(67, 'P1.2', 'French', 50, 20, 10, 80),
(68, 'P2.1', 'Powerpoint', 100, 20, 10, 81),
(69, 'P1.1', 'Presentation', 100, 20, 10, 82);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `training`
--

CREATE TABLE IF NOT EXISTS `training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `location` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `training_ibfk_1` (`location`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Gegevens worden uitgevoerd voor tabel `training`
--

INSERT INTO `training` (`id`, `name`, `location`) VALUES
(1, 'Kleuteronderwijs', 4),
(2, 'Lager onderwijs', 4),
(3, 'Secundair onderwijs', 4),
(4, 'Biomedische Laboratiriumtechnologie', 1),
(5, 'Bedrijfsmanagement', 1),
(6, 'Communicatiemanagement', 2),
(7, 'Energiemanagement', 3),
(8, 'Ergotherapie', 2),
(9, 'Industrieel Productontwerpen', 3),
(10, 'Journalistiek', 2),
(11, 'Digital Arts & Entertainment', 3),
(15, 'Netwerkeconomie', 1),
(16, 'Office Management', 1),
(18, 'Toegepaste Informatica', 1),
(20, 'Sport en Bewegen', 4),
(21, 'Sociaal Werk (Brugge)', 4),
(22, 'Sociaal Werk (Kortrijk)', 2),
(25, 'Toegepaste Architectuur', 1),
(26, 'Toegepaste Gezondheidswetenschappen', 6),
(27, 'Toegepaste Psychologie', 1),
(28, 'Toerisme en Recreatiemanagement', 2),
(29, 'Verpleegkunde', 1),
(30, 'Brugprogramma verpleegkunde ', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `training_course_rapport`
--

CREATE TABLE IF NOT EXISTS `training_course_rapport` (
  `id` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `training` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `course` (`course`,`training`),
  UNIQUE KEY `course_2` (`course`,`training`),
  KEY `training` (`training`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Verzameling van de verschillende vakken binnen 1 richting.';

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `training_rapport`
--

CREATE TABLE IF NOT EXISTS `training_rapport` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `quotation_system` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=96 ;

--
-- Gegevens worden uitgevoerd voor tabel `uploads`
--

INSERT INTO `uploads` (`id`, `filename`) VALUES
(1, 'upload/37ed4d7.jpg'),
(2, 'upload/img_548aca03e8e93.png'),
(3, 'upload/img_548acab2420c7.jpg'),
(4, 'upload/img_548acb11c12e3.png'),
(5, 'upload/img_548acc55ad9c4.png'),
(6, 'upload/img_548acc63b4057.csv'),
(7, 'upload/file_548accd25fde3.png'),
(8, 'upload/file_548acd2288f3b.csv'),
(9, 'upload/file_548acd4269e5a.csv'),
(10, 'upload/file_548acd426d5df.png'),
(11, 'upload/file_548acf93ca02a.png'),
(12, 'upload/file_548acf9daf0d8.png'),
(13, 'upload/file_548acfac992b0.jpg'),
(14, 'upload/file_548ad01b2a71d.jpg'),
(15, 'upload/file_548ad06d92480.jpg'),
(16, 'upload/file_549ebb5cdb6ca.jpg'),
(17, 'upload/file_54a1b7dac60a8.jpg'),
(18, 'upload/file_54a85ef98dee9.jpg'),
(19, 'upload/file_54a85f8fba18a.jpg'),
(20, 'upload/file_54a86379822a8.jpg'),
(21, 'upload/file_54a863ad4c334.jpg'),
(22, 'upload/file_54a863e4e8ec7.jpg'),
(23, 'upload/file_54a8640af11d7.jpg'),
(24, 'upload/file_54a864cf561aa.jpg'),
(25, 'upload/file_54a86590cd1f2.jpg'),
(26, 'upload/file_54a865deb04d8.jpg'),
(27, 'upload/file_54a867083fa4f.jpg'),
(28, 'upload/file_54a86a7dcd576.csv'),
(29, 'upload/file_54a86b57b2861.csv'),
(30, 'upload/file_54a86bc409b0a.csv'),
(31, 'upload/file_54a86d210bd9f.csv'),
(32, 'upload/file_54a86d61df9c9.csv'),
(33, 'upload/file_54a917d71fc23.csv'),
(34, 'upload/file_54a9183c7884d.csv'),
(35, 'upload/file_54a9218d720ac.csv'),
(36, 'upload/file_54a92327a4238.csv'),
(37, 'upload/file_54a92370b5d37.csv'),
(38, 'upload/file_54a923e505c75.csv'),
(39, 'upload/file_54a92524c57a1.'),
(40, 'upload/file_54a9253e50827.'),
(41, 'upload/file_54a925454c83b.csv'),
(42, 'upload/file_54a9258ed769a.csv'),
(43, 'upload/file_54a925e09d48d.csv'),
(44, 'upload/file_54a9269069090.'),
(45, 'upload/file_54a92699b6b10.csv'),
(46, 'upload/file_54a926fbdf699.csv'),
(47, 'upload/file_54a9274822c0c.csv'),
(48, 'upload/file_54a927ff90898.csv'),
(49, 'upload/file_54a92847ca8ee.csv'),
(50, 'upload/file_54a92871365fa.csv'),
(51, 'upload/file_54a9287688b88.'),
(52, 'upload/file_54a928b58ffea.csv'),
(53, 'upload/file_54a92976453e6.csv'),
(54, 'upload/file_54a92a22ad379.csv'),
(55, 'upload/file_54a92b491c2b9.csv'),
(56, 'upload/file_54a92b8dcae23.csv'),
(57, 'upload/file_54a930bd36b48.csv'),
(58, 'upload/file_54a931841eb17.csv'),
(59, 'upload/file_54a931b3de1ee.csv'),
(60, 'upload/file_54a93942b0667.csv'),
(61, 'upload/file_54a9398a6553b.csv'),
(62, 'upload/file_54a93b44eeffc.csv'),
(63, 'upload/file_54a93b9ca210a.csv'),
(64, 'upload/file_54a93cbbad305.csv'),
(65, 'upload/file_54a93d32c9a65.csv'),
(66, 'upload/file_54a94afc65557.csv'),
(67, 'upload/file_54a9580d68ab1.csv'),
(68, 'upload/file_54afb099e4f93.jpg'),
(69, 'upload/file_54b7bad54e031.jpg'),
(70, 'upload/file_54b7bae531e6f.jpg'),
(71, 'upload/file_54b7baf31ea15.jpg'),
(72, 'upload/file_54b7baff030e1.jpg'),
(73, 'upload/file_54b7bb01be61d.jpg'),
(74, 'upload/file_54b7bb06818db.png'),
(75, 'upload/file_54b7bb30309b9.jpg'),
(76, 'upload/file_54ef27e6c4986.png'),
(77, 'upload/file_550841794d078.jpg'),
(78, 'upload/file_5513c561d4203.jpg'),
(79, 'upload/file_5513c5877d15c.jpg'),
(80, 'upload/file_5513c589cba8a.jpg'),
(81, 'upload/file_5513c5929a487.jpg'),
(82, 'upload/file_5513c5938945c.jpg'),
(83, 'upload/file_5513c5942ece7.jpg'),
(84, 'upload/file_5513c59494ccc.jpg'),
(85, 'upload/file_5513c594ac2e8.jpg'),
(86, 'upload/file_5513c594cd58a.jpg'),
(87, 'upload/file_5513c594eff89.jpg'),
(88, 'upload/file_5513c595b5ff9.jpg'),
(89, 'upload/file_553f56569a46c.png'),
(90, 'upload/file_554dd56496391.'),
(91, 'upload/file_554dd583bbcbd.png'),
(92, 'upload/file_555cecd93609f.csv'),
(93, 'upload/file_555ddeac05cba.jpg'),
(94, 'upload/file_555de0f18e139.jpg'),
(95, 'upload/file_555efb70ca45f.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `avatar` int(99) DEFAULT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'EN',
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `password` varchar(128) NOT NULL,
  `activation_key` varchar(100) DEFAULT NULL,
  `status` enum('WAIT_ACTIVATION','ACTIVE','DISABLED') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'WAIT_ACTIVATION',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Gegevens worden uitgevoerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `avatar`, `lang`, `firstname`, `lastname`, `password`, `activation_key`, `status`, `created`) VALUES
(1, 'daan@dptechnics.com', 89, 'EN', 'Daan', 'Pape', '$2y$10$6J9qKp2bPqwcYE5q7eIjvuvDMkDTDdQBc.h.fQJk8sA/IQrvPyy8S', '', 'ACTIVE', '2014-11-06 12:06:55'),
(2, 'matthieu.calie@gmail.com', 75, 'EN', 'Matthieu', 'Calie', '$2y$10$pJJz6tnJ09EpNnxNL8MwXO.4n1wqjzUaLJuVm2ReKLa/B0RLmvXvq', '', 'ACTIVE', '2014-11-06 13:12:56'),
(3, 'daan.pape@student.howest.be', NULL, 'EN', 'Daan', 'Pape', '$2y$10$hDz91rbPOP5gSmH8zhm6kO2vmeJFc0ZAm7/T5ESuhLoGphxhLmY4i', '', 'ACTIVE', '2014-11-13 09:15:44'),
(4, 'aryan.eimermacher@student.howest.be', NULL, 'EN', 'Aryan', 'Eimermacher', '$2y$10$vOcvVFPgqPChuWwS4X9.wewgZ.TlImxZ7bzNtP3unrTise59JBRJu', '', 'ACTIVE', '2014-12-11 17:17:45'),
(5, 'matthieu.calie1@gmail.com', NULL, 'EN', 'Matthieu', 'Calie', '$2y$10$L71FQsxzuqJSEAyTWFH5buK.rgctx.3KA4NE/bWZJuYw/lGFMatae', 'bd4e9b7aed564f3cf2b69db58e87a684b564472f', 'WAIT_ACTIVATION', '2015-01-04 10:42:06'),
(6, 'jonas.vanalderweireldt@student.howest.be', NULL, 'EN', 'Jonas', 'Vanalderweireldt', '$2y$10$/liTzX0vdatHKUMtMIxSYO6e/wKrbCZn/adiaHsOm3WtsBeI237mi', '', 'ACTIVE', '2015-02-13 11:46:16'),
(7, 'niels.verhaegen@student.howest.be', NULL, 'EN', 'Niels', 'Verhaegen', '$2y$10$ZVfbTJAXi3boy3GRzbcDJ.MyuYN8uXoeNf7C1WJ/4gKhPtLpcNjk2', '', 'ACTIVE', '2015-02-16 20:12:55'),
(8, 'glenn.matthys@student.howest.be', NULL, 'EN', 'Glenn', 'Matthys', '$2y$10$vEjvRe.hTYG13PShTKtlKuFl5FqFUfvORdooEc2iYh786DeXJyefG', '', 'ACTIVE', '2015-02-16 21:19:24'),
(10, 'jenox@hotmail.com', NULL, 'EN', 'Wallace', 'Rodriquez', '$2y$10$zdFUQviRx.GUW/9aRG22j..h/jp9zvKVNYVhgYE97DwkxnKsluPh2', '262d2dccbd5231027c788e1ecfc9b933be469dfb', 'WAIT_ACTIVATION', '2015-02-26 13:24:14'),
(11, 'Zhiyuan.chou@student.howest.be', 91, 'EN', 'Zhiyuan', 'Chou', '$2y$10$L6VgNOSytsn6mNwhP9Y5zO.LqIABwj7iy14C.eOf6EnW1MtAcmLOy', '', 'ACTIVE', '2015-02-26 13:27:15'),
(12, 'thomas.de.wispelaere@student.howest.be', NULL, 'EN', 'Thomas', 'De Wispelaere', '$2y$10$NLzR/eixK.h7nmMBl3JyIO4F..DNoY8oIsDkyHqdXLpGYKR.yeOL.', '', 'ACTIVE', '2015-02-26 13:28:12'),
(13, 'mathias.verbanck@student.howest.be', NULL, 'EN', 'Mathias', 'Verbanck', '$2y$10$X7XPDCxyAfZItuHZAsbP/.KCH6RUexJfZQnmCzgvnPBYs1Tq2at1K', '', 'ACTIVE', '2015-02-26 14:22:38'),
(14, 'dirk.vandycke@howest.be', NULL, 'EN', 'Dirk', 'Vandycke', '$2y$10$94WC9MreJ6/omDE/hd6o/.i2Y6FlUKfp8HJSLHkt6.MMRt3Epgkiu', '', 'ACTIVE', '2015-03-05 09:37:47'),
(15, 'joachim.cromheecke@student.howest.be', NULL, 'EN', 'Joachim', 'Cromheecke', '$2y$10$2eNUqVnBWIB2JsFWvnUtR.J5Lzjq5At5Ounbw.66eZf/h0rzkE5FS', '4d30ebfbae104cf8367edb1ab4d9f9099d81b2e4', 'ACTIVE', '2015-03-05 10:31:17'),
(16, 'mathiasverbanck@gmail.com', 95, 'EN', 'Mathias', 'Verbanck', '$2y$10$nRgaGkdT.hymbv75Abfptu2RSjSlNh9zq3dk2njSyavKI9NZCB.Ya', '', 'ACTIVE', '2015-03-16 09:58:42'),
(17, 'christian.toisoul@gharial.be', NULL, 'EN', 'Christian', 'Toisoul', '$2y$10$9A494tBzj.5SFNFohq41QuvUC/ShYJqXoVVDleZONr2rNSl0y6G7O', '', 'ACTIVE', '2015-03-17 18:29:36'),
(22, 'nielsvverhaegen@gmail.com', NULL, 'EN', 'Niels', 'Verhaegen', '$2y$10$1ay/NO4pTU3seH5w6X2xnej3XA2W3cix.FdoghfnBMJq69OE8S77K', '', 'ACTIVE', '2015-04-28 07:28:15'),
(23, 'test@test.test', NULL, 'EN', 'test', 'test', '$2y$10$34iD5HHknmFnNwIVX.qOEOThVxPlgmm8O4SIB8b6cgYS5cy/6tsce', '1998f77b9608fc9cb40a1b7c9c19f664e0e87309', 'ACTIVE', '2015-04-30 12:29:41'),
(25, 'test@test.tes', NULL, 'EN', 'Jonas', 'Vanalderweireldt', '$2y$10$IyLs/StZJcyPLRZuQ9Vap.yIpw215SlVvwsYKJpy7SKKHOJ1vh3Cq', NULL, 'ACTIVE', '2015-05-19 17:04:39'),
(26, 'test@jonas.com', NULL, 'NL', 'Testgebruiker', 'GebruikerTest', '$2y$10$8Y2C9Mw8/ARvzgp.7xYqKu8TQbvf9IdTFoYS8zh.qL3Xaq51rLlcO', NULL, 'ACTIVE', '2015-05-21 15:54:37');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(99) NOT NULL,
  `role_id` int(99) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_roles_ibfk_1` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=199 ;

--
-- Gegevens worden uitgevoerd voor tabel `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(2, 1, 3),
(5, 4, 3),
(14, 1, 2),
(21, 11, 1),
(22, 11, 2),
(23, 11, 3),
(24, 12, 3),
(25, 12, 2),
(26, 12, 1),
(27, 14, 1),
(28, 14, 2),
(29, 14, 3),
(30, 15, 1),
(31, 15, 2),
(32, 15, 3),
(34, 13, 1),
(36, 13, 3),
(37, 13, 2),
(41, 16, 2),
(42, 16, 3),
(43, 16, 1),
(44, 17, 1),
(45, 17, 2),
(46, 17, 3),
(99, 5, 3),
(100, 5, 2),
(110, 2, 1),
(111, 2, 4),
(112, 2, 2),
(113, 2, 3),
(120, 22, 1),
(121, 22, 4),
(122, 22, 3),
(138, 7, 1),
(139, 7, 4),
(140, 7, 3),
(141, 7, 2),
(157, 8, 1),
(158, 8, 2),
(159, 8, 3),
(160, 8, 4),
(164, 23, 1),
(165, 23, 3),
(166, 23, 2),
(179, 25, 1),
(180, 25, 4),
(181, 25, 3),
(182, 25, 2),
(189, 26, 4),
(190, 26, 3),
(191, 26, 1),
(193, 7, 4),
(197, 6, 1),
(198, 6, 4);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkfiche_competence_rapport`
--

CREATE TABLE IF NOT EXISTS `werkfiche_competence_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `werkfiche` int(11) NOT NULL,
  `competence` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `werkfiche` (`werkfiche`,`competence`),
  KEY `competence` (`competence`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Gegevens worden uitgevoerd voor tabel `werkfiche_competence_rapport`
--

INSERT INTO `werkfiche_competence_rapport` (`id`, `werkfiche`, `competence`) VALUES
(4, 68, 1),
(5, 68, 2),
(6, 69, 1),
(7, 69, 2),
(8, 69, 3),
(9, 70, 1),
(10, 71, 1),
(11, 71, 2),
(12, 74, 1),
(13, 78, 1),
(14, 78, 94),
(15, 81, 99),
(16, 83, 98),
(18, 96, 1),
(19, 96, 98),
(20, 96, 100),
(21, 96, 101),
(22, 96, 102);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkfiche_competence_score_rapport`
--

CREATE TABLE IF NOT EXISTS `werkfiche_competence_score_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `werkfiche_competence` int(11) NOT NULL,
  `werkfiche_user` int(11) NOT NULL,
  `score` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `werkfiche_competence` (`werkfiche_competence`,`werkfiche_user`),
  KEY `werkfiche_user` (`werkfiche_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkfiche_criteria_rapport`
--

CREATE TABLE IF NOT EXISTS `werkfiche_criteria_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `werkfiche` int(11) NOT NULL,
  `criteria` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `werkfiche` (`werkfiche`,`criteria`),
  KEY `criteria` (`criteria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Gegevens worden uitgevoerd voor tabel `werkfiche_criteria_rapport`
--

INSERT INTO `werkfiche_criteria_rapport` (`id`, `werkfiche`, `criteria`) VALUES
(4, 68, 1),
(5, 69, 2),
(6, 70, 1),
(7, 71, 2),
(8, 74, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkfiche_criteria_score_rapport`
--

CREATE TABLE IF NOT EXISTS `werkfiche_criteria_score_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `werkfiche_criteria` int(11) NOT NULL,
  `werkfiche_user` int(11) NOT NULL,
  `score` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `werkfiche_criteria` (`werkfiche_criteria`,`werkfiche_user`),
  KEY `werkfiche_user` (`werkfiche_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkfiche_module_rapport`
--

CREATE TABLE IF NOT EXISTS `werkfiche_module_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `werkfiche` int(11) NOT NULL,
  `module` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `werkfiche` (`werkfiche`,`module`),
  KEY `module` (`module`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Koppelt meerdere modules aan 1 bepaalde werkfiche.' AUTO_INCREMENT=22 ;

--
-- Gegevens worden uitgevoerd voor tabel `werkfiche_module_rapport`
--

INSERT INTO `werkfiche_module_rapport` (`id`, `werkfiche`, `module`) VALUES
(4, 68, 1),
(5, 69, 1),
(6, 69, 2),
(7, 70, 1),
(8, 71, 1),
(9, 71, 2),
(10, 72, 3),
(11, 72, 4),
(12, 74, 1),
(13, 74, 59),
(14, 78, 1),
(15, 81, 1),
(16, 81, 59),
(17, 83, 59),
(20, 96, 1),
(21, 96, 59);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkfiche_module_score_rapport`
--

CREATE TABLE IF NOT EXISTS `werkfiche_module_score_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `werkfiche_module` int(11) NOT NULL,
  `werkfiche_user` int(11) NOT NULL,
  `score` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `werkfiche_module` (`werkfiche_module`),
  UNIQUE KEY `werkfiche_module_2` (`werkfiche_module`,`werkfiche_user`),
  KEY `werkfiche_user` (`werkfiche_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkfiche_rapport`
--

CREATE TABLE IF NOT EXISTS `werkfiche_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` char(100) NOT NULL,
  `Course` int(11) NOT NULL,
  `Active` int(1) NOT NULL DEFAULT '1',
  `equipment` text,
  `method` text,
  `assessment` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Course` (`Course`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabel die algemeen een werkfiche bijhoudt ongeacht het vak.' AUTO_INCREMENT=97 ;

--
-- Gegevens worden uitgevoerd voor tabel `werkfiche_rapport`
--

INSERT INTO `werkfiche_rapport` (`id`, `Name`, `Course`, `Active`, `equipment`, `method`, `assessment`) VALUES
(67, 'Luisteroefening', 1, 1, NULL, NULL, 'A - E'),
(68, 'Spreekbeurt huisdieren', 1, 1, 'more test', 'more test', 'A - E'),
(69, 'Test werkwoorden', 1, 1, 'test', 'test', 'A - E'),
(70, 'test4', 1, 0, 'test', 'test', '1 - 10'),
(71, 'test5', 1, 0, 'test', 'test', 'Custom'),
(72, 'TestGerman', 2, 1, 'Test', 'Test', 'A - E'),
(73, 'test', 1, 0, NULL, NULL, 'A - E'),
(74, 'test', 1, 0, 'test', 'test', 'A - E'),
(75, 'test', 1, 0, NULL, NULL, '1 - 10'),
(76, 'Spreekbeurt huis', 2, 1, 'none', 'none', '1 - 10'),
(78, '9', 1, 0, '', '', 'A - E'),
(79, 'Spreekbeurt huisdier', 2, 1, 'geen', 'thuis voorberieden en opzoeken', '1 - 10'),
(80, 'test', 1, 0, NULL, NULL, ''),
(81, 'test', 1, 0, 'test', 'test', 'A - E'),
(82, 'test', 2, 1, NULL, NULL, ''),
(83, 'test 2', 1, 0, 'niets', 'qsdqsd', 'A - E'),
(84, 'Spreekbeurt', 111, 1, '/', 'prepare at home.', '1 - 10'),
(85, 'test', 1, 1, NULL, NULL, ''),
(86, 'Test Frans', 2, 0, 'Pen, papier', 'Schriftelijk', '1 - 10'),
(94, 'Taak Frans 2', 1, 1, NULL, NULL, ''),
(95, 'Taak Frans 3', 1, 1, 'blu', 'blu', 'A - E'),
(96, 'Taak Frans 4', 1, 1, 'blu', 'blu', 'None');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkfiche_user_rapport`
--

CREATE TABLE IF NOT EXISTS `werkfiche_user_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `werkfiche` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `datum` varchar(50) DEFAULT NULL,
  `score` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `werkfiche` (`werkfiche`,`user`,`datum`),
  UNIQUE KEY `werkfiche_2` (`werkfiche`,`user`,`datum`),
  UNIQUE KEY `werkfiche_3` (`werkfiche`,`user`,`datum`),
  UNIQUE KEY `werkfiche_4` (`werkfiche`,`user`,`datum`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Koppelt een leerling aan een bepaalde werkfiche.' AUTO_INCREMENT=66 ;

--
-- Gegevens worden uitgevoerd voor tabel `werkfiche_user_rapport`
--

INSERT INTO `werkfiche_user_rapport` (`id`, `werkfiche`, `user`, `datum`, `score`) VALUES
(21, 67, 1, NULL, NULL),
(22, 68, 1, NULL, NULL),
(23, 68, 2, '05/15/2015', 'D'),
(24, 68, 11, '05/01/2015', 'B'),
(25, 68, 12, '05/06/2015', 'A'),
(26, 68, 13, NULL, NULL),
(27, 68, 15, NULL, NULL),
(29, 70, 2, '05/14/2015', '2'),
(30, 72, 4, NULL, NULL),
(31, 72, 1, NULL, NULL),
(32, 72, 4, NULL, NULL),
(34, 72, 8, NULL, NULL),
(39, 72, 6, '05/01/2015', 'B'),
(40, 72, 10, NULL, NULL),
(42, 67, 10, NULL, NULL),
(43, 72, 10, NULL, NULL),
(44, 72, 6, NULL, NULL),
(45, 72, 10, NULL, NULL),
(47, 79, 6, '05/07/2015', '4'),
(48, 72, 10, NULL, NULL),
(52, 69, 11, '05/13/2015', 'C'),
(53, 68, 6, NULL, NULL),
(54, 72, 11, NULL, NULL),
(56, 72, 13, NULL, NULL),
(57, 72, 15, NULL, NULL),
(61, 83, 11, '05/13/2015', 'B'),
(62, 84, 12, '05/12/2015', '5'),
(63, 84, 15, NULL, NULL),
(64, 69, 2, NULL, NULL),
(65, 96, 13, NULL, NULL);

--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `assess_documents`
--
ALTER TABLE `assess_documents`
  ADD CONSTRAINT `assess_documents_ibfk_1` FOREIGN KEY (`user`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `assess_documents_ibfk_2` FOREIGN KEY (`document`) REFERENCES `documenttype` (`id`),
  ADD CONSTRAINT `assess_documents_ibfk_3` FOREIGN KEY (`project`) REFERENCES `project` (`id`);

--
-- Beperkingen voor tabel `assess_score`
--
ALTER TABLE `assess_score`
  ADD CONSTRAINT `assess_score_ibfk_1` FOREIGN KEY (`project`) REFERENCES `project` (`id`),
  ADD CONSTRAINT `assess_score_ibfk_2` FOREIGN KEY (`student`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `assess_score_ibfk_3` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `assess_score_ibfk_4` FOREIGN KEY (`competence`) REFERENCES `competence` (`id`),
  ADD CONSTRAINT `assess_score_ibfk_5` FOREIGN KEY (`subcompetence`) REFERENCES `subcompetence` (`id`),
  ADD CONSTRAINT `assess_score_ibfk_6` FOREIGN KEY (`indicator`) REFERENCES `indicator` (`id`);

--
-- Beperkingen voor tabel `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`training`) REFERENCES `training` (`id`);

--
-- Beperkingen voor tabel `course_studentlist_teacher_rapport`
--
ALTER TABLE `course_studentlist_teacher_rapport`
  ADD CONSTRAINT `course_studentlist_teacher_rapport_ibfk_1` FOREIGN KEY (`course`) REFERENCES `course_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_studentlist_teacher_rapport_ibfk_2` FOREIGN KEY (`teacher`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_studentlist_teacher_rapport_ibfk_3` FOREIGN KEY (`studentlist`) REFERENCES `studentlist_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `criteria_rapport`
--
ALTER TABLE `criteria_rapport`
  ADD CONSTRAINT `criteria_rapport_ibfk_1` FOREIGN KEY (`doelstelling`) REFERENCES `doelstelling_rapport` (`id`);

--
-- Beperkingen voor tabel `doelstelling_rapport`
--
ALTER TABLE `doelstelling_rapport`
  ADD CONSTRAINT `doelstelling_rapport_ibfk_1` FOREIGN KEY (`module`) REFERENCES `module_rapport` (`id`);

--
-- Beperkingen voor tabel `email`
--
ALTER TABLE `email`
  ADD CONSTRAINT `email_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `indicator`
--
ALTER TABLE `indicator`
  ADD CONSTRAINT `indicator_ibfk_1` FOREIGN KEY (`subcompetence`) REFERENCES `subcompetence` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `module_rapport`
--
ALTER TABLE `module_rapport`
  ADD CONSTRAINT `module_rapport_ibfk_1` FOREIGN KEY (`course`) REFERENCES `course_rapport` (`id`);

--
-- Beperkingen voor tabel `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`);

--
-- Beperkingen voor tabel `rules`
--
ALTER TABLE `rules`
  ADD CONSTRAINT `rules_ibfk_1` FOREIGN KEY (`project`) REFERENCES `project` (`id`);

--
-- Beperkingen voor tabel `studentlist`
--
ALTER TABLE `studentlist`
  ADD CONSTRAINT `studentlist_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`id`);

--
-- Beperkingen voor tabel `studentlist_students_rapport`
--
ALTER TABLE `studentlist_students_rapport`
  ADD CONSTRAINT `studentlist_students_rapport_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `studentlist_students_rapport_ibfk_2` FOREIGN KEY (`studentlist`) REFERENCES `studentlist_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `studentlist_users`
--
ALTER TABLE `studentlist_users`
  ADD CONSTRAINT `studentlist_users_ibfk_1` FOREIGN KEY (`studentlist`) REFERENCES `studentlist` (`id`),
  ADD CONSTRAINT `studentlist_users_ibfk_2` FOREIGN KEY (`student`) REFERENCES `users` (`id`);

--
-- Beperkingen voor tabel `training`
--
ALTER TABLE `training`
  ADD CONSTRAINT `training_ibfk_1` FOREIGN KEY (`location`) REFERENCES `location` (`id`);

--
-- Beperkingen voor tabel `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `werkfiche_competence_rapport`
--
ALTER TABLE `werkfiche_competence_rapport`
  ADD CONSTRAINT `werkfiche_competence_rapport_ibfk_1` FOREIGN KEY (`competence`) REFERENCES `doelstelling_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `werkfiche_competence_rapport_ibfk_2` FOREIGN KEY (`werkfiche`) REFERENCES `werkfiche_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `werkfiche_competence_score_rapport`
--
ALTER TABLE `werkfiche_competence_score_rapport`
  ADD CONSTRAINT `werkfiche_competence_score_rapport_ibfk_1` FOREIGN KEY (`werkfiche_competence`) REFERENCES `werkfiche_competence_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `werkfiche_competence_score_rapport_ibfk_2` FOREIGN KEY (`werkfiche_user`) REFERENCES `werkfiche_user_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `werkfiche_criteria_rapport`
--
ALTER TABLE `werkfiche_criteria_rapport`
  ADD CONSTRAINT `werkfiche_criteria_rapport_ibfk_1` FOREIGN KEY (`criteria`) REFERENCES `criteria_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `werkfiche_criteria_rapport_ibfk_2` FOREIGN KEY (`werkfiche`) REFERENCES `werkfiche_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `werkfiche_criteria_score_rapport`
--
ALTER TABLE `werkfiche_criteria_score_rapport`
  ADD CONSTRAINT `werkfiche_criteria_score_rapport_ibfk_1` FOREIGN KEY (`werkfiche_criteria`) REFERENCES `werkfiche_criteria_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `werkfiche_criteria_score_rapport_ibfk_2` FOREIGN KEY (`werkfiche_user`) REFERENCES `werkfiche_user_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `werkfiche_module_rapport`
--
ALTER TABLE `werkfiche_module_rapport`
  ADD CONSTRAINT `werkfiche_module_rapport_ibfk_1` FOREIGN KEY (`werkfiche`) REFERENCES `werkfiche_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `werkfiche_module_rapport_ibfk_2` FOREIGN KEY (`module`) REFERENCES `module_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `werkfiche_module_score_rapport`
--
ALTER TABLE `werkfiche_module_score_rapport`
  ADD CONSTRAINT `werkfiche_module_score_rapport_ibfk_1` FOREIGN KEY (`werkfiche_module`) REFERENCES `werkfiche_module_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `werkfiche_module_score_rapport_ibfk_2` FOREIGN KEY (`werkfiche_user`) REFERENCES `werkfiche_user_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `werkfiche_rapport`
--
ALTER TABLE `werkfiche_rapport`
  ADD CONSTRAINT `werkfiche_rapport_ibfk_1` FOREIGN KEY (`Course`) REFERENCES `course_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `werkfiche_user_rapport`
--
ALTER TABLE `werkfiche_user_rapport`
  ADD CONSTRAINT `werkfiche_user_rapport_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `werkfiche_user_rapport_ibfk_2` FOREIGN KEY (`werkfiche`) REFERENCES `werkfiche_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
