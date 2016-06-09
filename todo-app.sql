-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июн 09 2016 г., 18:51
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `todo-app`
--

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `owner_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

--
-- Дамп данных таблицы `projects`
--

INSERT INTO `projects` (`id`, `name`, `owner_id`) VALUES
(41, 'New project', 2),
(49, 'Complete', 3),
(50, 'News', 2),
(51, '13 project', 4),
(52, 'America', 2),
(53, 'Garage', 2),
(54, 'National geografic', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `project_id` int(11) NOT NULL,
  `order_value` int(4) NOT NULL,
  `deadline` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id_2` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `status`, `project_id`, `order_value`, `deadline`) VALUES
(16, '1йвыв', 1, 41, 0, 0),
(23, 'sdfsdfsdf', 0, 49, 0, 0),
(24, 'fsdfdsf', 0, 49, 1, 0),
(25, 'dfsdfsdsd', 0, 49, 3, 0),
(26, 'New tasks', 0, 49, 2, 0),
(28, 'new new туц', 0, 41, 2, 0),
(29, 'new', 0, 50, 0, 0),
(30, 'qwer', 0, 50, 0, 0),
(31, 'aqwer', 1, 52, 10, 0),
(32, 'new', 1, 52, 9, 0),
(33, '1йвыв', 1, 52, 8, 0),
(34, 'aqwer', 1, 52, 7, 0),
(35, 'new', 1, 52, 6, 0),
(36, 'repair car', 1, 53, 0, 0),
(37, 'repair car', 1, 53, 0, 0),
(38, 'repair car', 1, 53, 0, 0),
(39, 'repair car', 1, 53, 0, 0),
(40, 'buy oil', 1, 53, 0, 0),
(41, 'buy oil', 1, 53, 0, 0),
(42, 'buy oil', 1, 53, 0, 0),
(43, 'paint the gate', 1, 53, 0, 0),
(44, 'paint the gate', 1, 53, 0, 0),
(45, 'fdfsdfs', 1, 53, 0, 0),
(46, 'fsdffefefrf', 1, 53, 0, 0),
(47, 'sfsefefdfsdf', 0, 53, 0, 0),
(48, 'fsdfefsdf', 0, 53, 0, 0),
(49, 'dfsdfsdf', 1, 52, 4, 0),
(50, 'sdfefsdfs', 1, 52, 5, 0),
(51, 'fsdfsefsefxd', 1, 52, 3, 0),
(52, 'fsdfefsdffdf', 1, 52, 2, 0),
(56, 'sdfsdfsdf', 1, 52, 1, 0),
(57, 'sdfsdf', 1, 52, 0, 0),
(58, 'вфывыфвыф', 0, 60, 0, 0),
(59, 'DROP TABLE test', 1, 60, 0, 0),
(60, 'DROP TABLE `test`', 0, 60, 0, 0),
(61, 'ваыва', 0, 60, 0, 0),
(62, 'вава', 0, 67, 0, 0),
(63, 'grgrgrg', 1, 72, 0, 0),
(64, 'dgfgfg', 0, 72, 1, 0),
(65, 'gfgfg df fg', 0, 56, 0, 0),
(66, 'вапвап', 0, 57, 0, 0),
(67, 'ytyyt', 0, 58, 2, 0),
(68, 'dfsdfsdf', 1, 58, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(30) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_hash` varchar(32) NOT NULL,
  `user_ip` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_login`, `user_password`, `user_hash`, `user_ip`) VALUES
(1, 'kalina1', '4341552fc9eee988ea15bb084f026ca9', '', 0),
(2, 'kalina', 'c49ce41e9ea66899c72cdbd09d585476', 'd530d07bc3bd4a6b202566da19b08542', 2130706433),
(3, 'kalina2', 'c49ce41e9ea66899c72cdbd09d585476', '', 0),
(4, 'kalina13', '7e51746feafa7f2621f71943da8f603c', 'fc58db64b593a8dc972dd1706aeffd9f', 2130706433),
(5, 'alinka', '70873e8580c9900986939611618d7b1e', '3b420ad9ded97309794f30620506a32c', 2130706433),
(6, 'kalina44', 'c49ce41e9ea66899c72cdbd09d585476', '84cb2eccaa1cb37dbcb3481cb09d91a0', 2130706433),
(7, 'kalina55', 'c49ce41e9ea66899c72cdbd09d585476', '5fd1f57d136158ea6773e630eb61af23', 2130706433),
(8, 'kalina66', 'c49ce41e9ea66899c72cdbd09d585476', 'caffcfbe2514bd652858f97c9411fadf', 2130706433),
(9, 'alina', '70873e8580c9900986939611618d7b1e', 'ca7c6de12c2613a0e066c14cfda64534', 2130706433),
(10, 'kalina88', '1f32aa4c9a1d2ea010adcf2348166a04', '7d16f2f5dc203e12e4b1ef63e0a1c31c', 2130706433);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
