-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 21-10-2024 a las 02:30:25
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lolinwonderland_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `authors`
--

CREATE TABLE `authors` (
  `author_id` int(11) NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `author_age` int(3) NOT NULL,
  `author_activity` int(4) NOT NULL,
  `author_img` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `authors`
--

INSERT INTO `authors` (`author_id`, `author_name`, `author_age`, `author_activity`, `author_img`) VALUES
(1, 'Sarah J. Mass', 38, 2012, 'sarah j mass.jpg'),
(2, 'Jennifer L. Armentrout', 44, 2011, 'jennifer l armentrout.jpg'),
(3, 'Marissa Meyer', 40, 2012, 'marisa meyer.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `book_name` varchar(100) NOT NULL,
  `book_authorid` int(100) DEFAULT NULL,
  `book_series` varchar(100) NOT NULL,
  `book_seriesnumber` int(11) NOT NULL,
  `book_summary` varchar(5000) NOT NULL,
  `book_img` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `books`
--

INSERT INTO `books` (`book_id`, `book_name`, `book_authorid`, `book_series`, `book_seriesnumber`, `book_summary`, `book_img`) VALUES
(1, 'A court of thorns and roses', 1, 'ACOTAR', 1, 'This books is about blablabla', 'ACOTAR.jpg'),
(2, 'A court of mist and fury', 1, 'ACOTAR', 2, 'The adventure continues and they...', 'ACOMAF.jpg'),
(3, 'A court of wings and ruin', 1, 'ACOTAR', 3, 'The war is near and...', 'ACOWAR.jpg'),
(4, 'From blood and ash', 2, 'From blood and ash', 1, 'Noblesse oblige and the protagonist...', 'FBAA.jpg'),
(5, 'Cinder', 3, 'Lunar Chronicles', 1, 'In a distopic world...', 'Cinder.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_lastname` varchar(100) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_lastname`, `user_email`, `user_username`, `user_password`) VALUES
(1, 'Victoria', 'Bayerque', 'tori.bayerque@gmail.com', 'ladypanther', '$2y$10$jxhcmkOgwyLrCzMLdP1wKuchsroA.S.Fqw9bTg.ooTPVemQROLTYi'),
(2, 'Web2', 'Web2', 'web2@web2.com', 'webadmin', '$2y$10$1p9TGjfHmB2Bm48ZF0oTGe7pRH0v0yus0aljTvScBwAhm4NmAPdRy');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_id`),
  ADD UNIQUE KEY `author_name` (`author_name`);

--
-- Indices de la tabla `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`,`book_name`),
  ADD KEY `book_authorid` (`book_authorid`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_username` (`user_username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`book_authorid`) REFERENCES `authors` (`author_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
