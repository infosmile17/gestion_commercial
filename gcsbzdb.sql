-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 01 juin 2021 à 11:12
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gcsbzdb`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(30) NOT NULL,
  `titre` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `qte_min` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `reference`, `titre`, `description`, `qte_min`) VALUES
(18, 'ajla 100', 'ajla 100', 'ajla 100', 3),
(19, 'yariss 2020', 'tayota yariss 2020', 'salem tayota', 2),
(15, 'x5', 'x5', 'x5', 2),
(16, 'x3', 'x3', 'x3', 1);

-- --------------------------------------------------------

--
-- Structure de la table `articles_model`
--

DROP TABLE IF EXISTS `articles_model`;
CREATE TABLE IF NOT EXISTS `articles_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_article` int(11) NOT NULL,
  `id_model` int(11) NOT NULL,
  `qte` int(11) DEFAULT 0,
  `prix_achat` float NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles_model`
--

INSERT INTO `articles_model` (`id`, `id_article`, `id_model`, `qte`, `prix_achat`) VALUES
(33, 16, 6, 16, 717),
(32, 15, 6, 35, 955.57),
(31, 15, 5, 230, 133),
(37, 18, 4, 128, 26.11),
(38, 19, 7, -10, 105);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomprenom` varchar(50) NOT NULL,
  `tel1` int(11) NOT NULL,
  `tel2` int(11) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `remarques` text DEFAULT NULL,
  `date_ajout` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nomprenom`, `tel1`, `tel2`, `email`, `adresse`, `remarques`, `date_ajout`) VALUES
(2, 'Ibtihel NASRI', 50234000, 50234000, 'infosmile17@gmail.com', '50234000', '50234000', '2021-01-30 00:58:40'),
(3, 'Passager', 99111222, 0, '', '', '', '2021-02-09 15:07:43');

-- --------------------------------------------------------

--
-- Structure de la table `cmd_achat`
--

DROP TABLE IF EXISTS `cmd_achat`;
CREATE TABLE IF NOT EXISTS `cmd_achat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_fourni` int(11) DEFAULT NULL,
  `id_transp` int(11) NOT NULL DEFAULT 1,
  `date_ajout` datetime DEFAULT current_timestamp(),
  `total` int(11) DEFAULT 0,
  `payee` int(11) DEFAULT 0,
  `transport` int(11) NOT NULL DEFAULT 0,
  `payee_transp` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cmd_achat`
--

INSERT INTO `cmd_achat` (`id`, `id_fourni`, `id_transp`, `date_ajout`, `total`, `payee`, `transport`, `payee_transp`) VALUES
(125, 7, 6, '2021-02-25 00:00:00', 4100, 4100, 100, 100),
(124, 2, 7, '2021-02-22 00:00:00', 2000, 2000, 200, 200),
(126, 2, 7, '2021-03-01 00:00:00', 300, 300, 100, 0),
(134, 2, 7, '2021-03-07 00:00:00', 1600, 1600, 120, 0),
(137, 2, 6, '2021-03-15 00:00:00', 1110, 1000, 100, 100),
(136, 2, 6, '2021-03-08 00:00:00', 1000, 0, 120, 0),
(139, 8, 9, '2021-06-01 00:00:00', 1000, 1000, 50, 50);

-- --------------------------------------------------------

--
-- Structure de la table `cmd_achat_ligne`
--

DROP TABLE IF EXISTS `cmd_achat_ligne`;
CREATE TABLE IF NOT EXISTS `cmd_achat_ligne` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cmd` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `prix_achat` int(11) NOT NULL,
  `id_model` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cmd_achat_ligne`
--

INSERT INTO `cmd_achat_ligne` (`id`, `id_cmd`, `id_article`, `qte`, `prix_achat`, `id_model`) VALUES
(77, 139, 19, 10, 105, 7),
(76, 137, 18, 111, 11, 4),
(75, 136, 18, 10, 112, 4),
(74, 134, 15, 3, 215, 6),
(73, 134, 18, 10, 108, 4),
(72, 133, 15, 5, 100, 5),
(71, 133, 16, 3, 100, 6),
(70, 133, 15, 10, 100, 6),
(69, 132, 15, 2, 100, 6),
(68, 131, 15, 2, 100, 6),
(67, 130, 15, 111, 2, 5),
(66, 130, 15, 111, 2, 5),
(65, 129, 15, 10, 100, 6),
(64, 128, 15, 3, 100, 6),
(63, 127, 16, 10, 100, 6),
(62, 127, 15, 3, 120, 6),
(61, 126, 15, 3, 133, 5),
(60, 125, 16, 3, 717, 6),
(59, 125, 15, 2, 1025, 6),
(58, 124, 14, 2, 550, 5),
(57, 124, 10, 10, 110, 5);

-- --------------------------------------------------------

--
-- Structure de la table `cmd_vente`
--

DROP TABLE IF EXISTS `cmd_vente`;
CREATE TABLE IF NOT EXISTS `cmd_vente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT current_timestamp(),
  `total` int(11) DEFAULT 0,
  `payee` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cmd_vente`
--

INSERT INTO `cmd_vente` (`id`, `id_client`, `date_ajout`, `total`, `payee`) VALUES
(41, 2, '2021-01-31 00:00:00', 315, 0),
(42, 2, '2021-02-03 00:00:00', 330, 0),
(62, 3, '2021-02-28 00:00:00', 600, 600),
(61, 2, '2021-02-28 00:00:00', 565, 300),
(64, 3, '2021-03-15 00:00:00', 90, 90),
(65, 3, '2021-06-01 00:00:00', 2200, 0);

-- --------------------------------------------------------

--
-- Structure de la table `cmd_vente_ligne`
--

DROP TABLE IF EXISTS `cmd_vente_ligne`;
CREATE TABLE IF NOT EXISTS `cmd_vente_ligne` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cmd` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `prix_vente` int(11) NOT NULL,
  `id_model` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cmd_vente_ligne`
--

INSERT INTO `cmd_vente_ligne` (`id`, `id_cmd`, `id_article`, `qte`, `prix_vente`, `id_model`) VALUES
(19, 61, 15, 1, 565, 5),
(18, 42, 11, 3, 110, 5),
(17, 41, 10, 3, 105, 4),
(22, 65, 19, 20, 110, 7),
(21, 64, 18, 3, 30, 4),
(20, 62, 15, 1, 600, 5);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commande_fournis`
--

DROP TABLE IF EXISTS `commande_fournis`;
CREATE TABLE IF NOT EXISTS `commande_fournis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_article` int(11) NOT NULL,
  `id_fournis` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `prix_achat` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fournis`
--

DROP TABLE IF EXISTS `fournis`;
CREATE TABLE IF NOT EXISTS `fournis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomprenom` varchar(50) NOT NULL,
  `tel1` int(11) NOT NULL,
  `tel2` int(11) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `remarques` text DEFAULT NULL,
  `date_ajout` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `fournis`
--

INSERT INTO `fournis` (`id`, `nomprenom`, `tel1`, `tel2`, `email`, `adresse`, `remarques`, `date_ajout`) VALUES
(2, 'Sameh Sameh AFI', 50234000, 50234000, 'afisemah@gmail.com', 'rue de la poste sidi bouzid', 'Tunis 212', '2021-01-22 21:30:33'),
(4, 'wassim brikii', 50234333, 50234111, 'infosmile17@gmail.com', '50234111', '50234111', '2021-01-24 19:31:50'),
(7, 'fournisseur bmw', 50234000, 50234000, 'afisemah@gmail.com', 'rue de la poste', 'Sidi Bouzid', '2021-02-25 21:52:06'),
(6, 'transp1 test', 98765432, 98765432, '', '', '', '2021-02-11 21:30:08'),
(8, 'med ali klay', 50234000, 50234000, 'afisemah@gmail.com', '50234000', '50234000', '2021-06-01 12:51:52');

-- --------------------------------------------------------

--
-- Structure de la table `gcsbz_users`
--

DROP TABLE IF EXISTS `gcsbz_users`;
CREATE TABLE IF NOT EXISTS `gcsbz_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(30) NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `gcsbz_users`
--

INSERT INTO `gcsbz_users` (`id`, `user_name`, `login`, `password`, `date_creation`) VALUES
(1, 'issam', 'issam', 'issam', '2021-01-24 12:41:47');

-- --------------------------------------------------------

--
-- Structure de la table `model`
--

DROP TABLE IF EXISTS `model`;
CREATE TABLE IF NOT EXISTS `model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `model`
--

INSERT INTO `model` (`id`, `nom`, `description`) VALUES
(4, 'info smile', 'info smile'),
(5, 'triangule', 'triangule'),
(6, 'BMW', ''),
(7, 'tayota', 'tayota');

-- --------------------------------------------------------

--
-- Structure de la table `payement_client`
--

DROP TABLE IF EXISTS `payement_client`;
CREATE TABLE IF NOT EXISTS `payement_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cmd` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `payement_client`
--

INSERT INTO `payement_client` (`id`, `id_cmd`, `montant`, `date`) VALUES
(19, 62, 300, '2021-02-28'),
(17, 61, 300, '2021-02-28'),
(24, 62, 300, '2021-02-28'),
(25, 64, 80, '2021-03-15'),
(26, 64, 10, '2021-03-15');

-- --------------------------------------------------------

--
-- Structure de la table `payement_fourni`
--

DROP TABLE IF EXISTS `payement_fourni`;
CREATE TABLE IF NOT EXISTS `payement_fourni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cmd` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `payement_fourni`
--

INSERT INTO `payement_fourni` (`id`, `id_cmd`, `montant`, `date`) VALUES
(13, 124, 1500, '2021-02-28'),
(14, 125, 4100, '2021-03-01'),
(17, 124, 500, '2021-03-01'),
(19, 126, 300, '1111-11-11'),
(20, 134, 1000, '2021-03-07'),
(21, 134, 600, '2021-03-07'),
(22, 137, 1000, '2021-03-15'),
(23, 139, 500, '2021-06-01'),
(24, 139, 500, '2021-06-01');

-- --------------------------------------------------------

--
-- Structure de la table `payement_transp`
--

DROP TABLE IF EXISTS `payement_transp`;
CREATE TABLE IF NOT EXISTS `payement_transp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cmd` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `payement_transp`
--

INSERT INTO `payement_transp` (`id`, `id_cmd`, `montant`, `date`) VALUES
(35, 139, 50, '2021-06-01'),
(34, 137, 20, '2021-03-15'),
(33, 137, 80, '2021-03-15'),
(32, 124, 200, '2021-03-15'),
(31, 125, 5, '2021-03-14'),
(30, 125, 15, '2021-03-14'),
(29, 125, 80, '2021-03-14');

-- --------------------------------------------------------

--
-- Structure de la table `transp`
--

DROP TABLE IF EXISTS `transp`;
CREATE TABLE IF NOT EXISTS `transp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomprenom` varchar(50) NOT NULL,
  `tel1` int(11) NOT NULL,
  `tel2` int(11) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `remarques` text DEFAULT NULL,
  `date_ajout` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `transp`
--

INSERT INTO `transp` (`id`, `nomprenom`, `tel1`, `tel2`, `email`, `adresse`, `remarques`, `date_ajout`) VALUES
(6, 'wassim briki', 50234000, 50234000, '', '', '', '2021-02-11 21:32:57'),
(7, 'ahmed afi', 98765432, 98765432, '', '', '', '2021-02-28 21:09:28'),
(8, 'sameh test', 98564123, 98564123, 'infosmile17@gmail.com', 'info smile 2', 'info smile 2', '2021-03-07 23:25:29'),
(9, 'med liveruer', 50234000, 50234000, 'afisameh07@gmail.com', '50234000', '50234000', '2021-06-01 12:52:22');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
