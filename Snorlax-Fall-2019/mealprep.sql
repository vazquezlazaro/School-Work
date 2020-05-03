-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 18, 2019 at 10:27 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mealprep`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user` varchar(50) NOT NULL,
  `meal` varchar(50) NOT NULL,
  `day`  varchar(10) NOT NULL,
  `id`   varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`user`, `meal`, `day`, `id`) VALUES
('phillipsjosh18@students.ecu.edu', 'burger', '0', '000'),
('phillipsjosh18@students.ecu.edu', 'Chicken Quesadillas', '0', '001'),
('phillipsjosh18@students.ecu.edu', 'Omellete', '1', '002'),
('phillipsjosh18@students.ecu.edu', 'Spaghetti', '4', '003');

-- --------------------------------------------------------

--
-- Table structure for table `pantry`
--

CREATE TABLE `pantry` (
  `email` varchar(40) NOT NULL,
  `ingredient` varchar(20) NOT NULL,
  `amount` double NOT NULL,
  `measure` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pantry`
--

INSERT INTO `pantry` (`email`, `ingredient`, `amount`, `measure`) VALUES
('karensmith@gmail.com', 'bacon bit', 1, 'tbsp'),
('Karensmith@gmail.com', 'buns', 2, 'pack'),
('karensmith@gmail.com', 'cheddar cheese', 8, 'ounce'),
('karensmith@gmail.com', 'chicken breast', 1, 'pound'),
('Karensmith@gmail.com', 'cold water', 2, 'tbsp'),
('karensmith@gmail.com', 'fajita seasoning', 1, 'packet'),
('karensmith@gmail.com', 'flour tortillas', 10, 'pack'),
('karensmith@gmail.com', 'green bell pepper', 2, 'chopped'),
('karensmith@gmail.com', 'ground beef', 3, 'pound'),
('karensmith@gmail.com', 'monterey jack', 8, 'ounce'),
('karensmith@gmail.com', 'onion', 1, 'chopped'),
('karensmith@gmail.com', 'red bell pepper', 1, 'chopped'),
('Karensmith@gmail.com', 'tomato sauce', 3, 'tbsp'),
('karensmith@gmail.com', 'vegetable oil', 1, 'tbsp');

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `meal` varchar(30) NOT NULL,
  `ingredient` varchar(30) NOT NULL,
  `measure` varchar(15) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`meal`, `ingredient`, `measure`, `amount`) VALUES
('Biscuits and Gravy', 'flour', 'cup', 0.25),
('Biscuits and Gravy', 'jumbo biscuits', 'ounce', 16),
('Biscuits and Gravy', 'milk', 'cup', 2.5),
('Biscuits and Gravy', 'sausage crumble', 'ounce', 9.6),
('Burger', 'bread crumbs', 'cup', 0.25),
('Burger', 'buns', 'pack', 1),
('Burger', 'egg', 'large', 1),
('Burger', 'garlic powder', 'tspn', 2),
('Burger', 'ground beef', 'pound', 1),
('Burger', 'lettuce', 'head', 1),
('Burger', 'pepper', 'tspn', 0.5),
('Burger', 'salt', 'tspn', 0.5),
('Burger', 'tomato', 'medium', 1),
('Burger', 'worchestershire', 'tbsp', 1),
('Chicken Bake Meal', 'chicken breast', 'pound', 1.5),
('Chicken Bake Meal', 'potatoes', 'medium', 4),
('Chicken Bake Meal', 'string green beans', 'ounce', 16),
('Chicken Bake Meal', 'zesty italian seasioning', 'pack', 1),
('Chicken Quesadillas', 'bacon bits', 'tbsp', 1),
('Chicken Quesadillas', 'cheddar cheese', 'ounce', 8),
('Chicken Quesadillas', 'chicken breast', 'pound', 1),
('Chicken Quesadillas', 'fajita seasoning', 'packet', 1),
('Chicken Quesadillas', 'flour tortillas', 'pack', 1),
('Chicken Quesadillas', 'green bell pepper', 'chopped', 2),
('Chicken Quesadillas', 'monterey jack', 'ounce', 8),
('Chicken Quesadillas', 'onion', 'chopped', 1),
('Chicken Quesadillas', 'red bell pepper', 'chopped', 2),
('Chicken Quesadillas', 'vegetable oil', 'tbsp', 1),
('Fluffy Pancakes', 'all-purpose flour', 'cup', 1),
('Fluffy Pancakes', 'baking powder', 'tspn', 1),
('Fluffy Pancakes', 'baking soda', 'tspn', 0.5),
('Fluffy Pancakes', 'egg', 'large', 1),
('Fluffy Pancakes', 'melted butter', 'tbsp', 2),
('Fluffy Pancakes', 'milk', 'cup', 0.75),
('Fluffy Pancakes', 'salt', 'tspn', 0.5),
('Fluffy Pancakes', 'sugar', 'tbsp', 2),
('Instant Oatmeal', 'oatmeal', 'pack', 1),
('Instant Oatmeal', 'water', 'cup', 0.25),
('Omellete', 'cheese', 'cup', 0.33),
('Omellete', 'egg white', 'tbsp', 2),
('Omellete', 'eggs', 'large', 2),
('Sandwhich', 'bread', 'loaf', 1),
('Sandwhich', 'cheese', 'slice', 1),
('Sandwhich', 'ham', 'slice', 4),
('Sandwhich', 'mayonaisse', 'tspn', 1),
('Sandwhich', 'mustard', 'tspn', 1),
('Simple Mexican Pizza', 'cheese blend', 'cup', 2),
('Simple Mexican Pizza', 'ground beef', 'pound', 1.5),
('Simple Mexican Pizza', 'pizza crust', 'can', 1),
('Simple Mexican Pizza', 'refried beans', 'ounce', 16),
('Simple Mexican Pizza', 'salsa', 'ounce', 8),
('Spaghetti', 'basil', 'tsp', 2),
('Spaghetti', 'black pepper', 'tsp', 0.5),
('Spaghetti', 'diced tomatoes', 'can', 1),
('Spaghetti', 'garlic cloves', 'minced', 4),
('Spaghetti', 'green bell pepper', 'diced', 1),
('Spaghetti', 'ground beef', 'pound', 1),
('Spaghetti', 'onion', 'chopped', 1),
('Spaghetti', 'oregano', 'tsp', 2),
('Spaghetti', 'salt', 'tsp', 1),
('Spaghetti', 'tomato paste', 'can', 1),
('Spaghetti', 'tomato sauce', 'can', 1),
('Teriyaki Chicken', 'black pepper', 'tsp', 0.25),
('Teriyaki Chicken', 'cider vinegar', 'cup', 0.25),
('Teriyaki Chicken', 'cold water', 'tbsp', 1),
('Teriyaki Chicken', 'cornstarch', 'tbsp', 1),
('Teriyaki Chicken', 'garlic clove', 'minced', 1),
('Teriyaki Chicken', 'ground ginger', 'tsp', 0.5),
('Teriyaki Chicken', 'soy sauce', 'cup', 0.5),
('Teriyaki Chicken', 'white sugar', 'cup', 0.5);

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `firstname` varchar(15) NOT NULL,
  `lastname` varchar(15) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`firstname`, `lastname`, `email`, `password`) VALUES
('Chad', 'Gains', 'Gainsfordays97@gmail.com', 'armseveryday'),
('Karen', 'Smith', 'Karensmith@gmail.com', 'ilovemykids'),
('Corwin', 'Lipkin', 'lipkinc18@students.ecu.edu', 'password');


--
-- Indexes for dumped tables
--

--
-- Indexes for table `pantry`
--
ALTER TABLE `pantry`
  ADD PRIMARY KEY (`email`,`ingredient`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`meal`,`ingredient`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
