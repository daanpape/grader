-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 20 mei 2015 om 22:29
-- Serverversie: 5.5.43-0ubuntu0.14.04.1
-- PHP-versie: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

INSERT INTO `location` (`id`, `name`) VALUES
(1, 'Howest - RSS'),
(2, 'Howest - RDR'),
(3, 'Howest - GKG'),
(4, 'Howest - SJS'),
(5, 'UGent - GKG'),
(6, 'Howest - Oostende');

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

INSERT INTO `emailtemplates` (`id`, `tag`, `lang`, `subject`, `plain`, `html`, `sender`, `replyto`) VALUES
  (1, 'activation', 'EN', 'Grader account activation', 'Hello {firstname} {lastname},\n\nThank you for registering for a DPTechnics account. Please activate\nyour account by following this link:\n\n{link}\n\nIf you can''t click, please copy and paste it into your browser. \n\nKind regards,\nThe DPTechnics Team', 'Hello {firstname} {lastname},<br/><br/>\n\n<p>\nThank you for registering for a DPTechnics account. Please activate\nyour account by following this link:\n</p>\n<br/>\n<a href="{link}">{link}</a>\n<br/>\n<p>\nIf you can''t click, please copy and paste it into your browser. \n</p>\n<br/>\nKind regards,<br/>\nThe DPTechnics Team', 'accounts.grader@howest.be', 'info@howest.be');





/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

