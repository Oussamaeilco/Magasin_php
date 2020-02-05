-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  mer. 05 fév. 2020 à 13:55
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `magasin`
--

-- --------------------------------------------------------

--
-- Structure de la table `prix`
--

DROP TABLE IF EXISTS `prix`;
CREATE TABLE IF NOT EXISTS `prix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valeur` float DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `id_produit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_produit_idx` (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `prix`
--

INSERT INTO `prix` (`id`, `valeur`, `date_debut`, `date_fin`, `id_produit`) VALUES
(1, 15, '2020-02-04', '2020-02-29', 1),
(2, 150, '2020-02-04', '2020-02-29', 2),
(4, 15, '2020-02-29', '2020-03-31', 1),
(5, 150, '2020-03-01', '2020-03-20', 2),
(6, 30, '2020-02-05', '2020-02-29', 3);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `categorie` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `categorie`) VALUES
(1, 'USB 3.0 64Go', 'Informatique'),
(2, 'Ecran LED (SMART)', 'Informatique'),
(3, 'Souris Razor', 'Informatique');

-- --------------------------------------------------------

--
-- Structure de la table `produit_vente`
--

DROP TABLE IF EXISTS `produit_vente`;
CREATE TABLE IF NOT EXISTS `produit_vente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` int(11) DEFAULT NULL,
  `id_produit` int(11) DEFAULT NULL,
  `id_ventes` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produit_PK_idx` (`id_produit`),
  KEY `ventes_PK_idx` (`id_ventes`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit_vente`
--

INSERT INTO `produit_vente` (`id`, `quantite`, `id_produit`, `id_ventes`) VALUES
(3, 20, 1, 2),
(4, 5, 3, 2),
(5, 5, 1, 3),
(6, 8, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `stock_mv`
--

DROP TABLE IF EXISTS `stock_mv`;
CREATE TABLE IF NOT EXISTS `stock_mv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `qt_mv` int(11) DEFAULT NULL,
  `id_produit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_produit2_idx` (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stock_mv`
--

INSERT INTO `stock_mv` (`id`, `date`, `qt_mv`, `id_produit`) VALUES
(3, '2020-02-04', 30, 1),
(4, '2020-02-04', 20, 2),
(6, '2020-02-04', 10, 1),
(7, '2020-02-05', 8, 2),
(8, '2020-02-05', 30, 3),
(12, '2020-02-05', -20, 1),
(13, '2020-02-05', -5, 3),
(14, '2020-02-05', -5, 1),
(15, '2020-02-05', -8, 2);

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

DROP TABLE IF EXISTS `ventes`;
CREATE TABLE IF NOT EXISTS `ventes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `prix_totale` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ventes`
--

INSERT INTO `ventes` (`id`, `date`, `prix_totale`) VALUES
(1, '2000-02-02', 75),
(2, '2000-02-02', 450),
(3, '2020-02-05', 1275);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `prix`
--
ALTER TABLE `prix`
  ADD CONSTRAINT `id_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `produit_vente`
--
ALTER TABLE `produit_vente`
  ADD CONSTRAINT `produit_PK` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`),
  ADD CONSTRAINT `ventes_PK` FOREIGN KEY (`id_ventes`) REFERENCES `ventes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `stock_mv`
--
ALTER TABLE `stock_mv`
  ADD CONSTRAINT `id_produit2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
