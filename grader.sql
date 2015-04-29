SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


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
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

CREATE TABLE IF NOT EXISTS `competence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `description` varchar(500) NOT NULL,
  `max` int(3) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `project` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `training` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=92 ;

CREATE TABLE IF NOT EXISTS `course_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=108 ;

CREATE TABLE IF NOT EXISTS `course_score_rapport` (
  `course` int(11) NOT NULL,
  `course_werkfiche` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`course`,`course_werkfiche`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `course_studentlist_teacher_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course` int(11) NOT NULL,
  `studentlist` int(11) NOT NULL,
  `teacher` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `course` (`course`,`studentlist`,`teacher`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=66 ;

CREATE TABLE IF NOT EXISTS `criteria_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `doelstelling` int(11) NOT NULL,
  `Active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Subcompetentie van competentie' AUTO_INCREMENT=34 ;

CREATE TABLE IF NOT EXISTS `documenttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(500) NOT NULL,
  `amount_required` int(2) NOT NULL,
  `weight` int(3) NOT NULL,
  `project` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

CREATE TABLE IF NOT EXISTS `doelstelling_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `module` int(11) NOT NULL,
  `Active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='subcompetentie van score' AUTO_INCREMENT=92 ;

CREATE TABLE IF NOT EXISTS `email` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `user_id` int(99) NOT NULL,
  `adress` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `registration` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

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

CREATE TABLE IF NOT EXISTS `indicator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `max` int(3) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `subcompetence` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=71 ;

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

CREATE TABLE IF NOT EXISTS `lastdropdownRapport` (
  `user` int(11) NOT NULL,
  `course` varchar(255) NOT NULL,
  `courseid` int(11) NOT NULL,
  `studentlist` varchar(255) NOT NULL,
  `studentlistid` int(11) NOT NULL,
  `student` varchar(255) NOT NULL,
  `studentid` int(11) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='lastdropdown tabel voor de asses van het rapportensysteem';

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

CREATE TABLE IF NOT EXISTS `module_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `course` int(99) NOT NULL,
  `Active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='modules van 1 vak' AUTO_INCREMENT=59 ;

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `year` date NOT NULL,
  `course` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

CREATE TABLE IF NOT EXISTS `project_studentlist` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `project` int(11) NOT NULL,
  `studentlist` int(99) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

CREATE TABLE IF NOT EXISTS `role_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(99) NOT NULL,
  `permission_id` int(99) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

CREATE TABLE IF NOT EXISTS `rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  `operator` varchar(10) NOT NULL,
  `value` int(11) NOT NULL,
  `result` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `studentlist` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `owner` int(99) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

CREATE TABLE IF NOT EXISTS `studentlist_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

CREATE TABLE IF NOT EXISTS `studentlist_students` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `studentlist` int(99) NOT NULL,
  `student` int(99) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=713 ;

CREATE TABLE IF NOT EXISTS `studentlist_students_rapport` (
  `studentlist` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`studentlist`,`user`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Verzameling van welke studenten in welke studentenlijst zitten.';

CREATE TABLE IF NOT EXISTS `studentlist_users` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `studentlist` int(99) NOT NULL,
  `student` int(99) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=420 ;

CREATE TABLE IF NOT EXISTS `subcompetence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `description` varchar(500) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `max` int(3) NOT NULL,
  `min_required` int(3) NOT NULL,
  `competence` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

CREATE TABLE IF NOT EXISTS `training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `location` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

CREATE TABLE IF NOT EXISTS `training_course_rapport` (
  `id` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `training` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Verzameling van de verschillende vakken binnen 1 richting.';

CREATE TABLE IF NOT EXISTS `training_rapport` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `quotation_system` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=90 ;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `avatar` int(99) DEFAULT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'EN',
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `password` varchar(128) NOT NULL,
  `activation_key` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(99) NOT NULL,
  `role_id` int(99) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

CREATE TABLE IF NOT EXISTS `werkfiche_module_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `werkfiche` int(11) NOT NULL,
  `module` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `werkfiche` (`werkfiche`,`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Koppelt meerdere modules aan 1 bepaalde werkfiche.' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `werkfiche_module_score_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `werkfiche_module` int(11) NOT NULL,
  `werkfiche_user` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `werkfiche_module` (`werkfiche_module`),
  UNIQUE KEY `werkfiche_module_2` (`werkfiche_module`,`werkfiche_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `werkfiche_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` char(100) NOT NULL,
  `Course` int(11) NOT NULL,
  `Active` int(1) NOT NULL DEFAULT '1',
  `equipment` text,
  `method` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabel die algemeen een werkfiche bijhoudt ongeacht het vak.' AUTO_INCREMENT=48 ;

CREATE TABLE IF NOT EXISTS `werkfiche_user_rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `werkfiche` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `datum` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `werkfiche` (`werkfiche`,`user`,`datum`),
  UNIQUE KEY `werkfiche_2` (`werkfiche`,`user`,`datum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Koppelt een leerling aan een bepaalde werkfiche.' AUTO_INCREMENT=1 ;


ALTER TABLE `studentlist_students_rapport`
  ADD CONSTRAINT `studentlist_students_rapport_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `studentlist_students_rapport_ibfk_2` FOREIGN KEY (`studentlist`) REFERENCES `studentlist_rapport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
