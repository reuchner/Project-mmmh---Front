-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 19 jan. 2018 à 12:54
-- Version du serveur :  10.1.22-MariaDB
-- Version de PHP :  7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db_mmmh`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `idadmin` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `pseudo` varchar(45) DEFAULT NULL,
  `mdp` varchar(45) DEFAULT NULL,
  `poste` varchar(45) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `conso`
--

CREATE TABLE `conso` (
  `idconso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `expert`
--

CREATE TABLE `expert` (
  `idexpert` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `pseudo` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mdp` varchar(45) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `ville` varchar(45) DEFAULT NULL,
  `profession` varchar(45) DEFAULT NULL,
  `code postal` varchar(45) DEFAULT NULL,
  `date de naissance` date DEFAULT NULL,
  `exptertise` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `idquestion` int(11) NOT NULL,
  `conso_idconso` int(11) NOT NULL,
  `pseudo_conso` varchar(45) DEFAULT NULL,
  `objet-titre` varchar(45) DEFAULT NULL,
  `question` varchar(249) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `question_has_admin`
--

CREATE TABLE `question_has_admin` (
  `question_idquestion` int(11) NOT NULL,
  `admin_idadmin` int(11) NOT NULL,
  `expert_idexpert` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `idtable1` int(11) NOT NULL,
  `question_idquestion` int(11) NOT NULL,
  `pseudoexpert` varchar(45) DEFAULT NULL,
  `objet_titre` varchar(45) DEFAULT NULL,
  `reponse` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `reponses_des_experts`
--

CREATE TABLE `reponses_des_experts` (
  `expert_idexpert` int(11) NOT NULL,
  `table1_idtable1` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tokens`
--

CREATE TABLE `tokens` (
  `token` varchar(80) NOT NULL,
  `type` enum('email','connexion','','') NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateEnd` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tokens`
--

INSERT INTO `tokens` (`token`, `type`, `created`, `dateEnd`, `user_id`) VALUES
('c516dee6553cdb53e9bbe6', 'email', '2018-01-19 12:53:03', '2018-01-20 12:53:03', 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `statuts` enum('actif','inactif','en attente','') NOT NULL DEFAULT 'en attente',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `statuts`, `created`) VALUES
(2, 'test', 'test@test.com', '098f6bcd4621d373cade4e832627b4f6', 'en attente', '2018-01-19 12:34:55'),
(3, 'toto', 'toto@toto.fr', 'f71dbe52628a3f83a77ab494817525c6', 'en attente', '2018-01-19 12:36:53');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idadmin`);

--
-- Index pour la table `conso`
--
ALTER TABLE `conso`
  ADD PRIMARY KEY (`idconso`);

--
-- Index pour la table `expert`
--
ALTER TABLE `expert`
  ADD PRIMARY KEY (`idexpert`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`idquestion`),
  ADD KEY `fk_question_conso1_idx` (`conso_idconso`);

--
-- Index pour la table `question_has_admin`
--
ALTER TABLE `question_has_admin`
  ADD PRIMARY KEY (`question_idquestion`,`admin_idadmin`,`expert_idexpert`),
  ADD KEY `fk_question_has_admin_admin1_idx` (`admin_idadmin`),
  ADD KEY `fk_question_has_admin_question1_idx` (`question_idquestion`),
  ADD KEY `fk_question_has_admin_expert1_idx` (`expert_idexpert`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`idtable1`),
  ADD KEY `fk_reponse*_question1_idx` (`question_idquestion`);

--
-- Index pour la table `reponses_des_experts`
--
ALTER TABLE `reponses_des_experts`
  ADD PRIMARY KEY (`expert_idexpert`,`table1_idtable1`),
  ADD KEY `fk_zoubida_has_table1_table11_idx` (`table1_idtable1`),
  ADD KEY `fk_zoubida_has_table1_zoubida_idx` (`expert_idexpert`);

--
-- Index pour la table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `idadmin` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `conso`
--
ALTER TABLE `conso`
  MODIFY `idconso` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `expert`
--
ALTER TABLE `expert`
  MODIFY `idexpert` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `idquestion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `idtable1` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `fk_question_conso1` FOREIGN KEY (`conso_idconso`) REFERENCES `conso` (`idconso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `question_has_admin`
--
ALTER TABLE `question_has_admin`
  ADD CONSTRAINT `fk_question_has_admin_admin1` FOREIGN KEY (`admin_idadmin`) REFERENCES `admin` (`idadmin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_question_has_admin_expert1` FOREIGN KEY (`expert_idexpert`) REFERENCES `expert` (`idexpert`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_question_has_admin_question1` FOREIGN KEY (`question_idquestion`) REFERENCES `question` (`idquestion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `fk_reponse*_question1` FOREIGN KEY (`question_idquestion`) REFERENCES `question` (`idquestion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `reponses_des_experts`
--
ALTER TABLE `reponses_des_experts`
  ADD CONSTRAINT `fk_zoubida_has_table1_table11` FOREIGN KEY (`table1_idtable1`) REFERENCES `reponse` (`idtable1`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_zoubida_has_table1_zoubida` FOREIGN KEY (`expert_idexpert`) REFERENCES `expert` (`idexpert`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
