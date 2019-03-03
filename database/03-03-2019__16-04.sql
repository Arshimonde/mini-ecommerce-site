-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  Dim 03 mars 2019 à 16:04
-- Version du serveur :  10.1.37-MariaDB
-- Version de PHP :  7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mini_ecommerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(4, 'shoes'),
(5, 'T-shirts'),
(6, 'Beauty products'),
(17, 'Fantasy Books'),
(19, 'Manga');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `company_name` varchar(30) DEFAULT NULL,
  `address` text,
  `city` varchar(30) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `first_name`, `last_name`, `company_name`, `address`, `city`, `country`, `phone`) VALUES
(8, 'Oualid', 'El Abdi', 'Drokavoka', 'Hay El Alaouine Rue El moussel', 'Temara', 'Morocco', '60000000'),
(9, 'John', 'Kyosaki', 'nothing', '123 street church', 'Las vegas', 'USA', '60000000'),
(10, 'Lucky', 'Luck', 'hyper', '1234 main st', 'toronto', 'Spain', '60000000'),
(11, 'Mohamed', 'Senhaji', 'IT', '1234 lorum ipsum', 'Temara', 'Morocco', '60000000');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(30) DEFAULT NULL,
  `product_image` varchar(200) DEFAULT NULL,
  `unit_price` double DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `disponible` tinyint(1) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `product_name`, `product_image`, `unit_price`, `quantity`, `disponible`, `id_category`) VALUES
(10, 'One punch man volume 1', 'public/products-images/81VAgJoB3BL.jpg', 10, 5, 1, 19),
(13, 'Attack on titan volume 2', 'public/products-images/b6bd5d9f02f987ceb012fcd930c1eb94.jpg', 10, 8, 1, 19),
(14, 'Attack on titan volume 1', 'public/products-images/91tYV+R03kL.jpg', 10, 11, 1, 19),
(15, 'Attack on titan volume 4', 'public/products-images/91HfjIdXvrL.jpg', 12, 5, 1, 19),
(17, 'Harry potter 1', 'public/products-images/51HSkTKlauL._SX346_BO1,204,203,200_.jpg', 9, 0, 1, 17),
(18, 'Cowboy bebop', 'public/products-images/luca-merli-cowboy-bebop-color.jpg', 15, 10, 1, 19),
(19, 'The Hobbit', 'public/products-images/61SJGmJDwzL._SX324_BO1,204,203,200_.jpg', 8, 11, 1, 17),
(20, 'Gangsta Volume 2', 'public/products-images/71FvSifU+3L.jpg', 17, 15, 1, 19),
(21, 'Death Parade', 'public/products-images/91Z2r7aWYzL._SL1500_.jpg', 8, 10, 1, 19);

-- --------------------------------------------------------

--
-- Structure de la table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `idClient` int(11) DEFAULT NULL,
  `idProduct` int(11) DEFAULT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `purchase`
--

INSERT INTO `purchase` (`id`, `idClient`, `idProduct`, `purchase_date`, `quantity`) VALUES
(16, 8, 10, '2019-02-02 20:56:08', NULL),
(17, 8, 13, '2019-02-02 20:56:08', NULL),
(18, 8, 14, '2019-02-02 20:56:08', NULL),
(19, 9, 17, '2019-02-08 14:32:19', NULL),
(20, 10, 10, '2019-02-08 18:00:12', NULL),
(21, 10, 17, '2019-02-08 18:00:12', NULL),
(22, 11, 10, '2019-03-01 19:49:23', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_client_fk` (`idClient`) USING BTREE,
  ADD KEY `product_fk` (`idProduct`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `client_fk` FOREIGN KEY (`idClient`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `product_fk` FOREIGN KEY (`idProduct`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
