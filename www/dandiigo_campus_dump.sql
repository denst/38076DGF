-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 13 2013 г., 16:33
-- Версия сервера: 5.5.28
-- Версия PHP: 5.4.6-1ubuntu1.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `dandiigo_campus`
--

-- --------------------------------------------------------

--
-- Структура таблицы `dg_acdmcyrs`
--

CREATE TABLE IF NOT EXISTS `dg_acdmcyrs` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `name` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

--
-- Дамп данных таблицы `dg_acdmcyrs`
--

INSERT INTO `dg_acdmcyrs` (`id`, `name`) VALUES
(1, 2012),
(2, 2013),
(3, 2014),
(4, 2015),
(5, 2016),
(6, 2017),
(7, 2018),
(8, 2019),
(9, 2020),
(10, 2021),
(11, 2022),
(12, 2023),
(13, 2024),
(14, 2025),
(15, 2026),
(16, 2027),
(17, 2028),
(18, 2029),
(19, 2030),
(20, 2031),
(21, 2032),
(22, 2033),
(23, 2034),
(24, 2035),
(25, 2036),
(26, 2037),
(27, 2038),
(28, 2039),
(29, 2040),
(30, 2041),
(31, 2042),
(32, 2043),
(33, 2044),
(34, 2045),
(35, 2046),
(36, 2047),
(37, 2048),
(38, 2049);

-- --------------------------------------------------------

--
-- Структура таблицы `dg_acdmrcrds`
--

CREATE TABLE IF NOT EXISTS `dg_acdmrcrds` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `subject` int(32) NOT NULL,
  `percentage_ev` int(3) DEFAULT NULL,
  `letter_ev` int(1) DEFAULT NULL COMMENT '5-A, 4-B, 3-C, 2-D, 1-E, 0-F',
  `comment_ev` int(1) DEFAULT NULL COMMENT '4-Excellent, 3-Very Good, 2-Good, 1-Satisfactory, 0-Poor',
  `period` int(1) NOT NULL COMMENT '0-semester, 1-term, 2-quarter, 3-custom8, 4-custom16',
  `order` int(1) NOT NULL,
  `student_id` int(32) NOT NULL,
  `date` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dg_acdmrcrds_ttls`
--

CREATE TABLE IF NOT EXISTS `dg_acdmrcrds_ttls` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `year_id` int(32) NOT NULL,
  `class` varchar(32) NOT NULL,
  `student_id` int(32) NOT NULL,
  `period` int(1) DEFAULT NULL COMMENT '0-semester, 1-term, 2-quarter, 3-custom8, 4-custom16',
  `percentage_ev` int(3) DEFAULT NULL,
  `letter_ev` int(1) DEFAULT NULL COMMENT '5-A, 4-B, 3-C, 2-D, 1-E, 0-F',
  `comment_ev` int(1) DEFAULT NULL COMMENT '4-Excellent, 3-Very Good, 2-Good, 1-Satisfactory, 0-Poor',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dg_achvmntrcrds`
--

CREATE TABLE IF NOT EXISTS `dg_achvmntrcrds` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `achievement` text NOT NULL,
  `notes` text NOT NULL,
  `date` int(32) NOT NULL,
  `student_id` int(32) NOT NULL,
  `year_id` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dg_achvmntrcrds_tchrs`
--

CREATE TABLE IF NOT EXISTS `dg_achvmntrcrds_tchrs` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `achievement` text NOT NULL,
  `notes` text NOT NULL,
  `date` int(32) NOT NULL,
  `teacher_id` int(32) NOT NULL,
  `year_id` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dg_admns`
--

CREATE TABLE IF NOT EXISTS `dg_admns` (
  `admin_id` int(32) unsigned NOT NULL,
  `fathername` varchar(100) NOT NULL,
  `grfathername` varchar(100) NOT NULL,
  `dob` varchar(32) NOT NULL,
  `sex` int(1) NOT NULL COMMENT ' 0 - male, 1 - female',
  `home_address` text NOT NULL,
  `lpw` varchar(100) NOT NULL,
  `job` varchar(100) NOT NULL,
  `contact_name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `telephone` text NOT NULL,
  `emergency` text NOT NULL,
  `languages` text NOT NULL,
  `health` varchar(255) NOT NULL,
  `name` varchar(32) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dg_dscplnrrcrds`
--

CREATE TABLE IF NOT EXISTS `dg_dscplnrrcrds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `record` text NOT NULL,
  `notes` text NOT NULL,
  `action` text NOT NULL,
  `date` int(32) NOT NULL,
  `student_id` int(32) NOT NULL,
  `year_id` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dg_dscplnrrcrds_tchrs`
--

CREATE TABLE IF NOT EXISTS `dg_dscplnrrcrds_tchrs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `record` text NOT NULL,
  `notes` text NOT NULL,
  `action` text NOT NULL,
  `date` int(32) NOT NULL,
  `teacher_id` int(32) NOT NULL,
  `year_id` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dg_fnnclrcrds`
--

CREATE TABLE IF NOT EXISTS `dg_fnnclrcrds` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `year_id` int(32) NOT NULL,
  `level_id` int(32) NOT NULL,
  `paid` int(1) NOT NULL,
  `period` int(1) NOT NULL,
  `order` int(1) NOT NULL,
  `student_id` int(32) NOT NULL,
  `annual` int(10) NOT NULL,
  `early` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dg_lvls`
--

CREATE TABLE IF NOT EXISTS `dg_lvls` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `order` int(5) NOT NULL,
  `annual` int(10) NOT NULL DEFAULT '0',
  `early_repayment` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `dg_lvls`
--

INSERT INTO `dg_lvls` (`id`, `name`, `order`, `annual`, `early_repayment`) VALUES
(1, 'Pre-School', 1, 0, 0),
(2, 'Kindergarten', 3, 1000, 10),
(3, 'Preparatory', 3, 0, 0),
(5, '2', 5, 1000, 10),
(6, '3', 6, 1000, 10),
(7, '4', 7, 0, 0),
(8, '5', 8, 0, 0),
(9, '6', 9, 0, 0),
(10, '7', 10, 0, 0),
(11, '8', 11, 0, 0),
(12, '9', 12, 0, 0),
(13, '10', 13, 0, 0),
(14, '11', 14, 0, 0),
(15, '12', 15, 0, 0),
(17, '1', 4, 1000, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `dg_rls`
--

CREATE TABLE IF NOT EXISTS `dg_rls` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `dg_rls`
--

INSERT INTO `dg_rls` (`id`, `name`, `description`) VALUES
(1, 'sadmin', 'This is role for super admin'),
(2, 'admin', 'This is role for admin'),
(3, 'teacher', 'This is role for teacher'),
(4, 'student', 'This is role for stutend');

-- --------------------------------------------------------

--
-- Структура таблицы `dg_rls_usrs`
--

CREATE TABLE IF NOT EXISTS `dg_rls_usrs` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `dg_rls_usrs`
--

INSERT INTO `dg_rls_usrs` (`user_id`, `role_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `dg_sbjcts`
--

CREATE TABLE IF NOT EXISTS `dg_sbjcts` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pid` int(32) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `dg_sbjcts`
--

INSERT INTO `dg_sbjcts` (`id`, `name`, `pid`) VALUES
(1, 'Soop', 0),
(2, 'Xer', 0),
(3, 'Art', 0),
(4, 'Science', 0),
(5, 'Physical Education', 0),
(6, 'Biology', 0),
(7, 'Physics', 0),
(8, 'Chemistry', 0),
(9, 'History', 0),
(10, 'Geography', 0),
(11, 'Economics', 0),
(12, 'Civics', 0),
(13, 'Amharic', 0),
(14, 'carabas', 0),
(15, 'I like to participate in outdoor games.', 5),
(16, 'I can throw & catch a ball.', 5),
(17, 'I can draw straight, curvy & zigzag lines. (Fine Motor Skills)', 3),
(18, 'I can colour within the border lines.', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `dg_sbjcts_clsss`
--

CREATE TABLE IF NOT EXISTS `dg_sbjcts_clsss` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `subject_id` int(32) NOT NULL,
  `class_id` int(32) NOT NULL,
  `scheme` int(1) NOT NULL COMMENT '0-Percentage, 1-Letter, 2-comment',
  `teacher_id` int(32) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `subject_id` (`subject_id`,`class_id`),
  KEY `fk_class_id` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dg_schlrshps`
--

CREATE TABLE IF NOT EXISTS `dg_schlrshps` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `year_id` int(32) NOT NULL,
  `student_id` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dg_stdnts`
--

CREATE TABLE IF NOT EXISTS `dg_stdnts` (
  `student_id` int(10) unsigned NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `dob` text NOT NULL,
  `sex` int(1) NOT NULL COMMENT ' 0 - male, 1 - female',
  `address` text NOT NULL,
  `father` text NOT NULL,
  `mother` text NOT NULL,
  `quardian` text NOT NULL,
  `tels_em` text NOT NULL,
  `languages` text NOT NULL,
  `health` text NOT NULL,
  `siblings` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `fathername` varchar(255) NOT NULL,
  `grfathername` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `class_id` int(32) DEFAULT NULL,
  `start_year` int(32) DEFAULT NULL,
  `end_year` int(32) DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dg_sttngs`
--

CREATE TABLE IF NOT EXISTS `dg_sttngs` (
  `key` varchar(50) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `dg_sttngs`
--

INSERT INTO `dg_sttngs` (`key`, `value`) VALUES
('academic_period', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `dg_tchrs`
--

CREATE TABLE IF NOT EXISTS `dg_tchrs` (
  `teacher_id` int(32) unsigned NOT NULL,
  `fathername` varchar(100) NOT NULL,
  `grfathername` varchar(100) NOT NULL,
  `dob` varchar(32) NOT NULL,
  `sex` int(1) NOT NULL COMMENT ' 0 - male, 1 - female',
  `home_address` text NOT NULL,
  `lpw` varchar(100) NOT NULL,
  `job` varchar(100) NOT NULL,
  `contact_name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `telephone` text NOT NULL,
  `emergency` text NOT NULL,
  `languages` text NOT NULL,
  `health` varchar(255) NOT NULL,
  `qualification` text NOT NULL,
  `experience` text NOT NULL,
  `name` varchar(32) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `start_year` int(32) NOT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dg_tchrs_sbjcts`
--

CREATE TABLE IF NOT EXISTS `dg_tchrs_sbjcts` (
  `teacher_id` int(32) unsigned NOT NULL,
  `subject_id` int(32) NOT NULL,
  PRIMARY KEY (`teacher_id`,`subject_id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dg_tmpl_clsss`
--

CREATE TABLE IF NOT EXISTS `dg_tmpl_clsss` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `level_id` int(32) NOT NULL,
  `teacher_id` int(32) NOT NULL DEFAULT '0',
  `year_id` int(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`level_id`,`year_id`),
  KEY `level_id` (`level_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dg_usrs`
--

CREATE TABLE IF NOT EXISTS `dg_usrs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0-not active, 1-active',
  `change_password` int(1) NOT NULL DEFAULT '0' COMMENT '0-not change, 1-need change',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `dg_usrs`
--

INSERT INTO `dg_usrs` (`id`, `username`, `password`, `logins`, `last_login`, `status`, `change_password`) VALUES
(1, 'sadmin', '7ccee320217398736c5a085864cbacffdeec9d420f1de2855c4f8394ea52c601', 119, 1363173696, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `dg_usr_tkns`
--

CREATE TABLE IF NOT EXISTS `dg_usr_tkns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dg_yrs_sbjcts_clsss`
--

CREATE TABLE IF NOT EXISTS `dg_yrs_sbjcts_clsss` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `year_id` int(32) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `parent_subject` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `year_id` (`year_id`,`subject`,`class`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `dg_admns`
--
ALTER TABLE `dg_admns`
  ADD CONSTRAINT `dg_admns_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `dg_usrs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `dg_rls_usrs`
--
ALTER TABLE `dg_rls_usrs`
  ADD CONSTRAINT `dg_rls_usrs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dg_usrs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dg_rls_usrs_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `dg_rls` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `dg_stdnts`
--
ALTER TABLE `dg_stdnts`
  ADD CONSTRAINT `dg_stdnts_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `dg_usrs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `dg_tchrs`
--
ALTER TABLE `dg_tchrs`
  ADD CONSTRAINT `dg_tchrs_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `dg_usrs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `dg_tchrs_sbjcts`
--
ALTER TABLE `dg_tchrs_sbjcts`
  ADD CONSTRAINT `dg_tchrs_sbjcts_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `dg_tchrs` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dg_tchrs_sbjcts_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `dg_sbjcts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `dg_tmpl_clsss`
--
ALTER TABLE `dg_tmpl_clsss`
  ADD CONSTRAINT `dg_tmpl_clsss_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `dg_lvls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `dg_usr_tkns`
--
ALTER TABLE `dg_usr_tkns`
  ADD CONSTRAINT `dg_usr_tkns_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dg_usrs` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
