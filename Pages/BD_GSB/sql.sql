-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 24 mai 2023 à 23:23
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gsb_frais`
--

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `id` char(2) NOT NULL,
  `libelle` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
('CL', 'Saisie clôturée'),
('CR', 'Fiche créée, saisie en cours'),
('RB', 'Remboursée'),
('VA', 'Validée et mise en paiement');

-- --------------------------------------------------------

--
-- Structure de la table `fichefrais`
--

DROP TABLE IF EXISTS `fichefrais`;
CREATE TABLE IF NOT EXISTS `fichefrais` (
  `idVisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `montantValide` decimal(10,2) DEFAULT NULL,
  `dateModif` date DEFAULT NULL,
  `idEtat` char(2) DEFAULT 'CR',
  PRIMARY KEY (`idVisiteur`,`mois`),
  KEY `idEtat` (`idEtat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fichefrais`
--

INSERT INTO `fichefrais` (`idVisiteur`, `mois`, `montantValide`, `dateModif`, `idEtat`) VALUES
('GV1', '5', '903.48', '2023-05-25', 'CR');

-- --------------------------------------------------------

--
-- Structure de la table `fraisforfait`
--

DROP TABLE IF EXISTS `fraisforfait`;
CREATE TABLE IF NOT EXISTS `fraisforfait` (
  `id` char(3) NOT NULL,
  `libelle` char(20) DEFAULT NULL,
  `montant` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fraisforfait`
--

INSERT INTO `fraisforfait` (`id`, `libelle`, `montant`) VALUES
('ETP', 'Forfait Etape', '110.00'),
('KM', 'Frais Kilométrique', '0.62'),
('NUI', 'Nuitée Hôtel', '80.00'),
('REP', 'Repas Restaurant', '29.00');

-- --------------------------------------------------------

--
-- Structure de la table `lignefraisforfait`
--

DROP TABLE IF EXISTS `lignefraisforfait`;
CREATE TABLE IF NOT EXISTS `lignefraisforfait` (
  `idVisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `idFraisForfait` char(3) NOT NULL,
  `quantite` int DEFAULT NULL,
  PRIMARY KEY (`idVisiteur`,`mois`,`idFraisForfait`),
  KEY `idFraisForfait` (`idFraisForfait`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `lignefraisforfait`
--

INSERT INTO `lignefraisforfait` (`idVisiteur`, `mois`, `idFraisForfait`, `quantite`) VALUES
('GV1', '5', 'ETP', 4),
('GV1', '5', 'KM', 4),
('GV1', '5', 'NUI', 4),
('GV1', '5', 'REP', 4);

-- --------------------------------------------------------

--
-- Structure de la table `lignefraishorsforfait`
--

DROP TABLE IF EXISTS `lignefraishorsforfait`;
CREATE TABLE IF NOT EXISTS `lignefraishorsforfait` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idVisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `libelle` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idVisiteur` (`idVisiteur`,`mois`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `lignefraishorsforfait`
--

INSERT INTO `lignefraishorsforfait` (`id`, `idVisiteur`, `mois`, `libelle`, `date`, `montant`) VALUES
(1, 'GV1', '5', 'TEST', '0000-00-00', '25.00');

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

DROP TABLE IF EXISTS `visiteur`;
CREATE TABLE IF NOT EXISTS `visiteur` (
  `id` char(4) NOT NULL,
  `nom` char(30) DEFAULT NULL,
  `prenom` char(30) DEFAULT NULL,
  `login` char(20) DEFAULT NULL,
  `mdp` char(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `adresse` char(30) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `ville` char(30) DEFAULT NULL,
  `dateEmbauche` date DEFAULT NULL,
  `role` char(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `visiteur`
--

INSERT INTO `visiteur` (`id`, `nom`, `prenom`, `login`, `mdp`, `adresse`, `cp`, `ville`, `dateEmbauche`, `role`) VALUES
('a131', 'Villechalane', 'Louis', 'lvillachane', '$2y$10$3bIKHUbJF9lv9uVO.IPyiu8Lu8E.ql4hgtqEH60W.HkRDobTHg/Ea', '8 rue des Charmes', '46000', 'Cahors', '2005-12-21', ''),
('a17', 'Andre', 'David', 'dandre', '$2y$10$GDLdrFWvzlfroJ/KhdIbiO98l26Jm3yk68aT3LAb/3bTqg0RhGVkC', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23', ''),
('a55', 'Bedos', 'Christian', 'cbedos', '$2y$10$V82bKljG8.xu3Q2Dl6cMmOcNtg4tHa6QjciPQzhl.UQ.EGj69pcPG', '1 rue Peranud', '46250', 'Montcuq', '1995-01-12', ''),
('a93', 'Tusseau', 'Louis', 'ltusseau', '$2y$10$WQYLzuNwkf.1VxUc5i2nwe5c/Cm0AXN6wzjGRzZsMvQWpmCYT6Fs2', '22 rue des Ternes', '46123', 'Gramat', '2000-05-01', ''),
('b13', 'Bentot', 'Pascal', 'pbentot', '$2y$10$MOM8BjD.XgO0yl6E8DYSJuUqtCe2AT7HIZvLCHngyNqZf/KH41Txy', '11 allée des Cerises', '46512', 'Bessines', '1992-07-09', ''),
('b16', 'Bioret', 'Luc', 'lbioret', '$2y$10$W6KtUIkNWGWmuO.3u9F1iOQ9ZENEzEX6YGisA/GG5jG51rHzScLR.', '1 Avenue gambetta', '46000', 'Cahors', '1998-05-11', ''),
('b19', 'Bunisset', 'Francis', 'fbunisset', '$2y$10$pBq31rUqZumHqomQ5zuJwer3nh6/HEPn8pvR/VXtdtXVrObDsVuxi', '10 rue des Perles', '93100', 'Montreuil', '1987-10-21', ''),
('b25', 'Bunisset', 'Denise', 'dbunisset', '$2y$10$glLYmqtwu0mhg/qtrKgqc.Zc2Y.angm1856V2E2c8zb4Ju5VLUPey', '23 rue Manin', '75019', 'paris', '2010-12-05', ''),
('b28', 'Cacheux', 'Bernard', 'bcacheux', '$2y$10$Faxj.XnmQG/9Rd3Lp80uVeSp9P.lP.jbJ9XEci/aU.Aq.TT1SO9AO', '114 rue Blanche', '75017', 'Paris', '2009-11-12', ''),
('b34', 'Cadic', 'Eric', 'ecadic', '$2y$10$eSXXSfzqkYJ7FGkkiWdlG.ydZkitPZaEynNm3u9/X7ujYZD1h4bcO', '123 avenue de la République', '75011', 'Paris', '2008-09-23', ''),
('b4', 'Charoze', 'Catherine', 'ccharoze', '$2y$10$hdwcpv7oqUUCieaIpPss/uisRn0JkJXnVi978pld0aaAynpTsXgLe', '100 rue Petit', '75019', 'Paris', '2005-11-12', ''),
('b50', 'Clepkens', 'Christophe', 'cclepkens', '$2y$10$GYiQFWxNVlVTYlb8OR2N5eoWkWo3weAxGRZbi0HmTToGq56Yeap6y', '12 allée des Anges', '93230', 'Romainville', '2003-08-11', ''),
('b59', 'Cottin', 'Vincenne', 'vcottin', '$2y$10$pTZJQ8rPGnIbmNSy4uuxPufC7I54lHqOtsEtxUcCy2Jilq3r3mWH6', '36 rue Des Roches', '93100', 'Monteuil', '2001-11-18', ''),
('c14', 'Daburon', 'François', 'fdaburon', '$2y$10$HEz0I3uUqsD4vmdwRROCwOkbUV0OKJeWZj9wV.NkK8IfDopZ35A0a', '13 rue de Chanzy', '94000', 'Créteil', '2002-02-11', ''),
('c3', 'De', 'Philippe', 'pde', '$2y$10$jpysn.R.jOHinpB0CrVd8Okv1h9VJgEV4QnaAEQK6HEinagkvTRCu', '13 rue Barthes', '94000', 'Créteil', '2010-12-14', ''),
('c54', 'Debelle', 'Michel', 'mdebelle', '$2y$10$VsXJQLUUpgrXwc0JBnSrz.nrOVbTsNt0tDvatR9Fk8KNDpPUaodVi', '181 avenue Barbusse', '93210', 'Rosny', '2006-11-23', ''),
('CC1', 'CYRIL', 'CYRIL', 'Cyril_C', '$2y$10$hcKJyAxIRjMGNikYTKhT8O7Kw367a/bOQriDVbSx3jasdjKWQ3T8.', '10 rue du tor', '31000', 'Toulouse', '2023-05-18', 'C'),
('CV1', 'CYRIL', 'CYRIL', 'Cyril_V', '$2y$10$Kl3PqkMSyJ8yXDKvUt2lleKQ5gFhBWFo2tykmD9Y9vaORptEgncuG', '10 rue du tor', '31000', 'Toulouse', '2015-05-26', 'V'),
('d13', 'Debelle', 'Jeanne', 'jdebelle', '$2y$10$eaBE2a9/Oxugvttnlysb.eZjdm8NeNLFr3ktWQXUeCW6JEJzZQcMO', '134 allée des Joncs', '44000', 'Nantes', '2000-05-11', ''),
('d51', 'Debroise', 'Michel', 'mdebroise', '$2y$10$GAh/tMNCSZVFWUYrNFIDf.m6.mTVoYqiNzaKBxSt.JjKQOuU8IOIW', '2 Bld Jourdain', '44000', 'Nantes', '2001-04-17', ''),
('e22', 'Desmarquest', 'Nathalie', 'ndesmarquest', '$2y$10$vf2fNKWks9wxL39HnYrD.uuiBE0JKkDjld8b7LhcdBtVyPXs7xKCi', '14 Place d Arc', '45000', 'Orléans', '2005-11-12', ''),
('e24', 'Desnost', 'Pierre', 'pdesnost', '$2y$10$.208fMIfIj1HM0hPyi11/eqrbenPkhVMhItvxRX1gQA00C/pjl6sW', '16 avenue des Cèdres', '23200', 'Guéret', '2001-02-05', ''),
('e39', 'Dudouit', 'Frédéric', 'fdudouit', '$2y$10$D4eRPiEd7caePXYlYvBdXuSDDv5UBnmU4XXwTuMxcMKNPUkhgSEne', '18 rue de l église', '23120', 'GrandBourg', '2000-08-01', ''),
('e49', 'Duncombe', 'Claude', 'cduncombe', '$2y$10$fWk.3uy6BBh6dleMLedH7.uW2IJTxPRWI66mt1Gv.76EjQYobcdX2', '19 rue de la tour', '23100', 'La souteraine', '1987-10-10', ''),
('e5', 'Enault-Pascreau', 'Céline', 'cenault', '$2y$10$ma5PXS8ZI.bGZcZ/bWNpSO/NJ51RZWm8h0SZ3dv08O1y71CtJlF7S', '25 place de la gare', '23200', 'Gueret', '1995-09-01', ''),
('e52', 'Eynde', 'Valérie', 'veynde', '$2y$10$94kZ0NFvJErD8JzszNJSNuwUfgaRYj3knDN2H4Z4MDxMQJBmQ0pWy', '3 Grand Place', '13015', 'Marseille', '1999-11-01', ''),
('EC1', 'EWANN', 'EWANN', 'Ewann_C', '$2y$10$SdczhbhZHjLhDWemWvLmDe4yND6Xxtp5AGMUc9H7SpFtbS8fnnPKC', '10 rue du tor', '31000', 'Toulouse', '2012-10-10', 'C'),
('EV1', 'EWANN', 'EWANN', 'Ewann_V', '$2y$10$X4PnPLGR7nSdMcae6kfu7u5fJIE5m1Votl556MVCYKikYYqRCAIh.', '10 rue du tor', '31000', 'Toulouse', '2013-05-22', 'V'),
('f21', 'Finck', 'Jacques', 'jfinck', '$2y$10$m0nC2eXrHE7MhXvNpg9i0ei70X1Sr2Lqiinozvgg2Z8hWYqIyHgvu', '10 avenue du Prado', '13002', 'Marseille', '2001-11-10', ''),
('f39', 'Frémont', 'Fernande', 'ffremont', '$2y$10$9rcuFOVpjL3Gn.6uxK69mueygzB5y01XnIq0Xi0AQCyEoYB/ZL2Tu', '4 route de la mer', '13012', 'Allauh', '1998-10-01', ''),
('f4', 'Gest', 'Alain', 'agest', '$2y$10$H.yeB6ykHYDSxH5QYBR7G.PKjahqY2Mivmaa6PbxxsL3ssrRiIDqe', '30 avenue de la mer', '13025', 'Berre', '1985-11-01', ''),
('GC1', 'GABRIEL', 'GABRIEL', 'Gabriel_C', '$2y$10$rPSKTkGnIelyNCiJV2DOM.a7W520Dig206.ZQ/rpLDbF4PMkPwjLy', '10 rue du tor', '31000', 'Toulouse', '2023-05-04', 'C'),
('GV1', 'GABRIEL', 'GABRIEL', 'Gabriel_V', '$2y$10$nzihnnXl6zy30leoUxKLD.qMgcK50oDPctVf4hH.iRCwlpHRL1wZm', '10 rue du tor', '31000', 'Toulouse', '2013-05-01', 'V');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `fichefrais`
--
ALTER TABLE `fichefrais`
  ADD CONSTRAINT `fichefrais_ibfk_1` FOREIGN KEY (`idEtat`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `fichefrais_ibfk_2` FOREIGN KEY (`idVisiteur`) REFERENCES `visiteur` (`id`);

--
-- Contraintes pour la table `lignefraisforfait`
--
ALTER TABLE `lignefraisforfait`
  ADD CONSTRAINT `lignefraisforfait_ibfk_1` FOREIGN KEY (`idVisiteur`,`mois`) REFERENCES `fichefrais` (`idVisiteur`, `mois`),
  ADD CONSTRAINT `lignefraisforfait_ibfk_2` FOREIGN KEY (`idFraisForfait`) REFERENCES `fraisforfait` (`id`);

--
-- Contraintes pour la table `lignefraishorsforfait`
--
ALTER TABLE `lignefraishorsforfait`
  ADD CONSTRAINT `lignefraishorsforfait_ibfk_1` FOREIGN KEY (`idVisiteur`,`mois`) REFERENCES `fichefrais` (`idVisiteur`, `mois`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;