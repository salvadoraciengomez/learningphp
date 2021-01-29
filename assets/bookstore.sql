-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-01-2021 a las 12:28:05
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bookstore`
--
CREATE DATABASE IF NOT EXISTS `bookstore` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bookstore`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `book`
--

CREATE TABLE `book` (
  `id` int(10) UNSIGNED NOT NULL,
  `isbn` char(13) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `stock` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `price` float UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `book`
--

INSERT INTO `book` (`id`, `isbn`, `title`, `author`, `stock`, `price`) VALUES
(1, '9780882339726', '1984', 'George Orwell', 12, 7.5),
(2, '9789724621081', '1Q84', 'Haruki Murakami', 9, 12.75),
(3, '9780736692427', 'Animal Farm', 'George Orwell', 8, 3.5),
(5, '9780753179246', '19 minutes', 'Jodi Picoult', 0, 10),
(6, '9781416500360', 'Odyssey', 'Homer', 0, 4.23),
(7, '9788187981954', 'Peter Pan', 'J. M. Barrie', 0, 2.34),
(12, '9781412108614', 'Iliad', 'Homer', 0, 9.25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `borrowed_books`
--

CREATE TABLE `borrowed_books` (
  `book_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `borrowed_books`
--

INSERT INTO `borrowed_books` (`book_id`, `customer_id`, `start`, `end`) VALUES
(1, 1, '2014-12-12 00:00:00', '2014-12-28 00:00:00'),
(1, 2, '2015-03-12 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer`
--

CREATE TABLE `customer` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` enum('basic','premium') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `customer`
--

INSERT INTO `customer` (`id`, `firstname`, `surname`, `email`, `type`) VALUES
(1, 'Han', 'Solo', 'han@tatooine.com', 'premium'),
(2, 'James', 'Kirk', 'enter@prise', 'basic');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale`
--

CREATE TABLE `sale` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sale`
--

INSERT INTO `sale` (`id`, `customer_id`, `date`) VALUES
(5, 1, '2021-01-20 14:31:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale_book`
--

CREATE TABLE `sale_book` (
  `sale_id` int(10) UNSIGNED NOT NULL,
  `book_id` int(10) UNSIGNED NOT NULL,
  `amount` smallint(5) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sale_book`
--

INSERT INTO `sale_book` (`sale_id`, `book_id`, `amount`) VALUES
(5, 1, 1),
(5, 2, 1),
(5, 3, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD UNIQUE KEY `isbn_2` (`isbn`),
  ADD KEY `title` (`title`);

--
-- Indices de la tabla `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD KEY `book_id` (`book_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indices de la tabla `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indices de la tabla `sale_book`
--
ALTER TABLE `sale_book`
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `book`
--
ALTER TABLE `book`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sale`
--
ALTER TABLE `sale`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD CONSTRAINT `borrowed_books_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `borrowed_books_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `sale_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Filtros para la tabla `sale_book`
--
ALTER TABLE `sale_book`
  ADD CONSTRAINT `sale_book_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`),
  ADD CONSTRAINT `sale_book_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`);
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
