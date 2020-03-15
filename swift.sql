-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 11 mars 2020 à 07:03
-- Version du serveur :  10.4.10-MariaDB
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
-- Base de données :  `swift`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id_avis` int(3) NOT NULL AUTO_INCREMENT,
  `id_membre` int(3) NOT NULL,
  `id_salle` int(3) NOT NULL,
  `commentaire` text NOT NULL,
  `note` int(2) NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_avis`),
  KEY `cascade_membre` (`id_membre`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id_avis`, `id_membre`, `id_salle`, `commentaire`, `note`, `date_enregistrement`) VALUES
(19, 15, 6, 'Sympa mais attention aux escaliers !', 3, '2020-03-09 23:45:55'),
(20, 13, 8, 'Sympa et accueil hyper pro , on recommande !', 4, '2020-03-09 23:45:55'),
(21, 16, 9, 'L\'écran est idéal pour les présentations !!!!', 5, '2020-03-09 23:45:55'),
(22, 17, 10, 'spacieuse et parfaitement équipée \r\nun conseil une fontaine a eau serait un plus !', 4, '2020-03-09 23:45:55'),
(23, 12, 11, 'incroyablement ensoleillée des stores serait sympa ', 3, '2020-03-09 23:45:55'),
(24, 11, 10, 'un parking aurait ete bien !', 3, '2020-03-09 23:51:13'),
(25, 14, 9, 'Personne pour l\'accueil décevant !', 2, '2020-03-09 23:51:13'),
(26, 16, 8, 'Parfait pour l\'accés !', 4, '2020-03-09 23:51:13'),
(27, 15, 11, 'Au top ! hyperclasse et trés spacieuse', 5, '2020-03-09 23:51:13'),
(28, 13, 9, 'Difficile de trouver un crénaux libre mais trés pratique ', 4, '2020-03-09 23:51:13'),
(29, 16, 6, 'impeu de rénovation serait a prévoir', 1, '2020-03-09 23:51:13'),
(30, 11, 12, 'Incroyablement bien placée au TOP !', 5, '2020-03-11 08:00:53'),
(31, 17, 13, 'Super salle facile d\'accés pour les stagiaires', 4, '2020-03-11 08:00:53');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(3) NOT NULL AUTO_INCREMENT,
  `id_membre` int(3) NOT NULL,
  `id_produit` int(3) NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `cascade_produit` (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_membre`, `id_produit`, `date_enregistrement`) VALUES
(12, 11, 27, '2020-03-09 23:55:50'),
(13, 12, 31, '2020-03-09 23:55:50'),
(14, 13, 32, '2020-03-09 23:55:50'),
(15, 14, 35, '2020-03-09 23:55:50'),
(16, 15, 36, '2020-03-09 23:55:50'),
(17, 16, 37, '2020-03-09 23:55:50'),
(18, 11, 38, '2020-03-09 23:55:50'),
(19, 12, 32, '2020-03-09 23:55:50'),
(20, 14, 36, '2020-03-09 23:55:50'),
(21, 15, 32, '2020-03-09 23:55:50');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int(3) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `statut` int(1) NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_membre`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(1, 'admin', '$2y$10$KuIVlg3HeS5NV0QweQkVW.S.o3l7heO9sG36gI/dKx/mly.lEFtc6', 'admin', 'admin', 'admin@gmail.com', 'm', 1, '2020-02-17 20:37:53'),
(11, 'Paul', 'paul123', 'Durant', 'Paul', 'paul@gmail.com', 'm', 0, '2020-03-09 23:40:34'),
(12, 'Sophie', 'sophie123', 'Legarek', 'sophie', 'sophie@gmail.com', 'f', 0, '2020-03-09 23:40:34'),
(13, 'Claire', 'claire123', 'christine', 'claire', 'claire@gmail.com', 'f', 0, '2020-03-09 23:40:34'),
(14, 'Michael', 'michael123', 'brochant', 'michael', 'michael@gmail.com', 'm', 0, '2020-03-09 23:40:34'),
(15, 'Bastien', 'bastien123', 'dupont', 'bastien', 'bastien@gmail.com', 'm', 0, '2020-03-09 23:40:34'),
(16, 'Marie', 'marie123', 'duchamp', 'marie', 'marie@gmail.com', 'f', 0, '2020-03-09 23:40:34'),
(17, 'michel', '$2y$10$XiVnSvoj1lP32GhXy2kl7OI.BV3ERj/q9nAVzpgPcY/VglnOtnAzK', 'michel', 'michel', 'michel@gmail.com', 'm', 0, '2020-03-09 23:41:22'),
(18, 'testmodif', '$2y$10$ZzBrbEB4TeNR3Ud6.aS86.Yy/2/oo7.4UYzwpWJ5vCu5G5EMCBF9W', 'testmodification', 'testmodification', 'testmodification@gmail.com', 'm', 0, '2020-03-10 02:27:28'),
(19, 'bob', '$2y$10$N1RyZroGyAh8D9w6tCYUeOAoXRV8AUO7cwNc8mbCaTTNw/giu/OXq', 'bob', 'bob', 'bobb@gmail.com', 'f', 0, '2020-03-10 19:48:20'),
(20, 'Chrisdu', '$2y$10$WFAvc/IbE/rvP0shKDmLA.AOJ73EA0pn7OG/adM59iGikA36kJz3C', 'Duranton', 'Christophe', 'chrisdu@gmail.com', 'm', 0, '2020-03-11 01:35:59');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int(3) NOT NULL AUTO_INCREMENT,
  `id_salle` int(3) NOT NULL,
  `date_arrivee` datetime NOT NULL,
  `date_depart` datetime NOT NULL,
  `prix` int(3) NOT NULL,
  `etat` enum('libre','reservation') NOT NULL,
  PRIMARY KEY (`id_produit`),
  KEY `cascade id_salle` (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `id_salle`, `date_arrivee`, `date_depart`, `prix`, `etat`) VALUES
(27, 6, '2020-02-01 11:11:00', '2020-02-02 22:22:00', 100, 'libre'),
(31, 8, '2020-04-17 10:00:00', '2020-04-17 12:00:00', 300, 'libre'),
(32, 9, '2020-06-13 12:12:00', '2020-06-13 13:13:00', 70, 'libre'),
(35, 10, '2020-06-05 12:12:00', '2020-06-05 18:00:00', 250, 'libre'),
(36, 9, '2020-06-27 12:12:00', '2020-06-27 13:13:00', 100, 'libre'),
(37, 10, '2020-07-17 10:10:00', '2020-07-17 11:11:00', 240, 'libre'),
(38, 11, '2020-05-15 10:00:00', '2020-05-15 12:12:00', 350, 'libre'),
(40, 12, '2020-05-09 08:00:00', '2020-05-09 19:00:00', 380, 'libre'),
(41, 12, '2020-03-18 08:00:00', '2020-03-18 08:00:00', 350, 'libre'),
(42, 13, '2020-03-26 08:00:00', '2020-03-26 18:00:00', 250, 'libre');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `id_salle` int(3) NOT NULL AUTO_INCREMENT,
  `titre` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `pays` varchar(20) DEFAULT NULL,
  `ville` varchar(20) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `cp` int(5) DEFAULT NULL,
  `capacite` int(3) DEFAULT NULL,
  `categorie` enum('réunion','bureau','formation') NOT NULL,
  PRIMARY KEY (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `titre`, `description`, `photo`, `pays`, `ville`, `adresse`, `cp`, `capacite`, `categorie`) VALUES
(6, ' cezanne  ', ' salle parfaite pour vos réunions  ', 'http://localhost/swift/photo/ cezanne -1.jpg', 'france', 'paris', '30 rue mademoiselle  ', 75015, 15, 'réunion'),
(8, ' Mozart  ', ' Cette salle est parfait pour tout type de réunion. Equipée d\'une table et de nombreuses chaises et prises de courant. il est à la fois fonctionnel et spacieux.  ', 'http://localhost/swift/photo/ Mozart -2.jpg', 'france', 'paris', ' 1 rue du pont  ', 75015, 5, 'réunion'),
(9, ' Monet  ', ' Salle spacieuse et confortable équipé d\'un écran de présentation et pouvant recevoir un grand nombre de collaborateurs   ', 'http://localhost/swift/photo/ Monet -3.jpg', 'france', 'paris', ' 2 rue du louvre   ', 75001, 8, 'réunion'),
(10, ' Voltaire  ', 'Salle spacieuse et élégante équipée de toutes les fonctionnalitées pour une présentation optimale, videoprojection et systeme de diffusion sonore  ', 'http://localhost/swift/photo/ Voltaire -5.jpg', 'france', 'marseille', '165 avenue du prado', 13008, 16, 'réunion'),
(11, ' Legrand  ', ' Grande salle spacieuse dans un environnement calme avec tous le materiel pour la presentation et la videoconference  ', 'http://localhost/swift/photo/ Legrand -6.jpg', 'france', 'paris', '180 avenue du prado   ', 13008, 10, 'réunion'),
(12, ' Rousseau', 'Salle de formation en plein coeur de la city équipée d\'un videoprojecteur dordinateur et d\'une fontaine a eau', 'http://localhost/swift/photo/ Rousseau-7.jpg', 'angleterre', 'londre', ' 92 Kensington Park Rd, Notting Hill', 19, 15, 'formation'),
(13, ' Bach', 'Grande spacieuse cette salle de formation offre un réel confort', 'http://localhost/swift/photo/ Bach-8.jpg', 'allemagne', 'berlin', ' Naunynstraße 38', 10999, 9, 'formation');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `cascade_membre` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `cascade_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `cascade id_salle` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
