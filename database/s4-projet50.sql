-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 08 Juin 2017 à 20:38
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `web18_main`
--

-- --------------------------------------------------------

--
-- Structure de la table `balade`
--

CREATE TABLE `balade` (
  `id_balade` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `status` enum('accepte','refuse','en_attente') NOT NULL DEFAULT 'en_attente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `contenu_parcours`
--

CREATE TABLE `contenu_parcours` (
  `id_p` int(11) NOT NULL,
  `id_b` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

CREATE TABLE `media` (
  `id_media` int(11) NOT NULL,
  `chemin` varchar(255) NOT NULL,
  `id_point_ref` int(11) NOT NULL,
  `status` enum('accepte','refuse','en_attente') NOT NULL DEFAULT 'en_attente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `point`
--

CREATE TABLE `point` (
  `id_point` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `latitude` decimal(7,5) NOT NULL,
  `longitude` decimal(8,5) NOT NULL,
  `description` text,
  `status` enum('accepte','refuse','en_attente') NOT NULL DEFAULT 'en_attente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `point`
--

INSERT INTO `point` (`id_point`, `nom`, `latitude`, `longitude`, `description`, `status`) VALUES
(1, 'Point1', '48.38434', '-4.49755', NULL, 'en_attente'),
(2, 'Point 2', '48.38536', '-4.50003', NULL, 'en_attente'),
(3, '123', '48.38522', '-4.50089', NULL, 'en_attente'),
(4, 'Point 55', '48.38462', '-4.49373', NULL, 'en_attente');

-- --------------------------------------------------------

--
-- Structure de la table `usagers`
--

CREATE TABLE `usagers` (
  `id_usager` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `permission` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `usagers`
--

INSERT INTO `usagers` (`id_usager`, `nom`, `prenom`, `mot_de_passe`, `email`, `permission`) VALUES
(19, 'Cardador', 'Jean', 'fddecb6a9fb5324cab83d2c9d4ec6f3492ee1df4', 'jony@tb', 'admin'),
(20, 'Marin', 'Yan', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'yan@tb', 'user'),
(21, '123', 'Elnatan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1@2', 'user');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `balade`
--
ALTER TABLE `balade`
  ADD PRIMARY KEY (`id_balade`);

--
-- Index pour la table `contenu_parcours`
--
ALTER TABLE `contenu_parcours`
  ADD KEY `id_p` (`id_p`),
  ADD KEY `id_b` (`id_b`);

--
-- Index pour la table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id_media`),
  ADD KEY `id_point_ref` (`id_point_ref`);

--
-- Index pour la table `point`
--
ALTER TABLE `point`
  ADD PRIMARY KEY (`id_point`);

--
-- Index pour la table `usagers`
--
ALTER TABLE `usagers`
  ADD PRIMARY KEY (`id_usager`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `balade`
--
ALTER TABLE `balade`
  MODIFY `id_balade` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `media`
--
ALTER TABLE `media`
  MODIFY `id_media` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `point`
--
ALTER TABLE `point`
  MODIFY `id_point` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `usagers`
--
ALTER TABLE `usagers`
  MODIFY `id_usager` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `contenu_parcours`
--
ALTER TABLE `contenu_parcours`
  ADD CONSTRAINT `balade` FOREIGN KEY (`id_b`) REFERENCES `balade` (`id_balade`),
  ADD CONSTRAINT `point` FOREIGN KEY (`id_p`) REFERENCES `point` (`id_point`);

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media` FOREIGN KEY (`id_point_ref`) REFERENCES `point` (`id_point`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
