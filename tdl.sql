-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : mar. 28 fév. 2023 à 16:46
-- Version du serveur : 10.6.5-MariaDB
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tdl`
--

-- --------------------------------------------------------

--
-- Structure de la table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `todo_list_id` int(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `completed` tinyint(1) DEFAULT 0,
  `completed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `todos_id` (`todo_list_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `todo_list_id`, `description`, `completed`, `completed_at`) VALUES
(25, 3, 15, 'finish school', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `todo_lists`
--

DROP TABLE IF EXISTS `todo_lists`;
CREATE TABLE IF NOT EXISTS `todo_lists` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `todo_lists`
--

INSERT INTO `todo_lists` (`id`, `user_id`, `title`, `created_at`) VALUES
(15, 3, 'school', '2023-02-28 17:38:10');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `firstname`, `lastname`, `email`) VALUES
(3, 'rim', '$2y$10$zcM/czt/voShRVJm5/r.2uouXw8V5WrStCnhCk9DiCmjsvgJYuVFm', 'Rim', 'Moghlali', 'rim.moghlali@laplateforme.io'),
(2, 'abrahamukachi', '$2y$10$0bYmhH1jZonp6fwU.gv3V.WY1WICkrl2MorAAfBnLBRKn1tInFvIm', 'Abraham', 'Ukachi', 'abraham.ukachi@laplateforme.io');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
