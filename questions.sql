-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2014 at 12:57 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `questions`
--

-- --------------------------------------------------------

--
-- Table structure for table `__questions_options`
--

CREATE TABLE IF NOT EXISTS `__questions_options` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `question_id` int(4) NOT NULL,
  `value` text NOT NULL,
  `correct` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `__questions_options`
--

INSERT INTO `__questions_options` (`id`, `question_id`, `value`, `correct`) VALUES
(1, 1, 'Resposta 01 - AAAAA', 1),
(2, 2, 'Resposta 02 - asdqaefgrr', 0),
(3, 2, 'Resposta 02- BBBBB', 1),
(4, 2, 'Resposta 02 - dfhfghgh', 0),
(5, 3, 'Resposta 03 - V - asddfg', 1),
(6, 3, 'Resposta 03 - F - fghsa', 0),
(7, 3, 'Resposta 03 - V - asdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `__questions_question`
--

CREATE TABLE IF NOT EXISTS `__questions_question` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `value` text NOT NULL,
  `type` int(1) NOT NULL,
  `difficulty` int(1) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `tag` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `__questions_question`
--

INSERT INTO `__questions_question` (`id`, `value`, `type`, `difficulty`, `subject`, `tag`) VALUES
(1, 'Questão 01 - Aberta e fácil - AAAA ?', 1, 1, 'AAA', 'aaa, bbb'),
(2, 'Questao 02 - Multipla escolha e média - BBBB?', 2, 2, 'BBBB', 'cccc ,dddd'),
(3, 'Pergunta 03 - Verdadeiro/Falso e dificil - CCCCCC?', 3, 3, 'ccccc', 'eeeee,ffff');

-- --------------------------------------------------------

--
-- Table structure for table `__question_open`
--

CREATE TABLE IF NOT EXISTS `__question_open` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `question_id` int(4) NOT NULL,
  `value` text NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
