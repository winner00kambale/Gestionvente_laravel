-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 09 mars 2022 à 20:39
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dbventeunite`
--

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `sp_produit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_produit` (IN `categ` VARCHAR(20), IN `nombre` FLOAT, IN `montan` FLOAT, IN `fourn` VARCHAR(20))  NO SQL
BEGIN 
DECLARE idc,idf,nbr,qte INT; 
DECLARE mtcaisse float;
SELECT COUNT(*) INTO nbr FROM stock WHERE stock.article=categ;
SET idc=(SELECT id FROM categories WHERE categories.designation=categ);
SET idf=(SELECT fournisseurs.id FROM fournisseurs WHERE fournisseurs.prenom=fourn);
SELECT caisse.montant INTO mtcaisse FROM caisse;
SELECT quantite INTO qte FROM stock WHERE stock.article=categ;
IF (nbr<=0)THEN
INSERT INTO products(category_id,nombre,montant,fournisseur_id,dates)VALUES(idc,nombre,montan,idf,CURDATE()); 
UPDATE caisse SET caisse.montant=mtcaisse-montan;
INSERT INTO stock(article,quantite)VALUES(categ,nombre);
ELSE
INSERT INTO products(category_id,nombre,montant,fournisseur_id,dates)VALUES(idc,nombre,montan,idf,CURDATE()); 
UPDATE caisse SET caisse.montant=mtcaisse-montan;
UPDATE stock SET quantite=qte+nombre WHERE stock.article=categ;
END IF;

END$$

DROP PROCEDURE IF EXISTS `sp_vente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_vente` (IN `cli` VARCHAR(20), IN `prod` VARCHAR(20), IN `nbr` INT, IN `montant` FLOAT)  NO SQL
BEGIN
    DECLARE idcli,idprod,reste,idpan INT;
    DECLARE MESSAGE_TEXT varchar(20);
    SET idcli=(SELECT id FROM clients WHERE clients.prenom=cli);
    SET idprod=(SELECT id FROM categories WHERE categories.designation=prod);
    SET idpan=(SELECT COALESCE(MAX(id),0)+1 FROM panier);
    SELECT stock.quantite INTO reste FROM stock WHERE stock.article=prod;
    IF((SELECT stock.quantite FROM stock WHERE stock.article=prod) <= (SELECT alertstock.nombre FROM alertstock))THEN
    SET @message='impossible de passer cette operation car la quantite est superieur';
    SIGNAL SQLSTATE '45001' SET MESSAGE_TEXT = @message;
    ELSEIF(nbr >=(SELECT stock.quantite FROM stock WHERE stock.article=prod))THEN
    SET @message='impossible de passer cette operation car la quantite est superieur';
    SIGNAL SQLSTATE '45001' SET MESSAGE_TEXT = @message;
    ELSE
    INSERT INTO 		products_sale(products_sale.client_id,products_sale.category_id,products_sale.nombre,products_sale.montant,products_sale.dates)VALUES(idcli,idprod,nbr,montant,CURDATE()); 
    UPDATE stock SET stock.quantite=reste-nbr WHERE stock.article=prod;
    INSERT INTO panier(id,client,article,nombre,montant,dates)VALUES(idpan,cli,prod,nbr,montant,CURDATE());
    END IF;
END$$

DROP PROCEDURE IF EXISTS `st_securite`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `st_securite` (IN `qte` INT)  BEGIN
DECLARE ids int;
SELECT COUNT(id)INTO ids FROM alertstock;
IF(ids <= 0)THEN
INSERT INTO alertstock(nombre)VALUES(qte);
ELSE
UPDATE alertstock SET nombre=qte;
END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `alertstock`
--

DROP TABLE IF EXISTS `alertstock`;
CREATE TABLE IF NOT EXISTS `alertstock` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `alertstock`
--

INSERT INTO `alertstock` (`id`, `nombre`) VALUES
(1, 100);

-- --------------------------------------------------------

--
-- Structure de la table `caisse`
--

DROP TABLE IF EXISTS `caisse`;
CREATE TABLE IF NOT EXISTS `caisse` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `montant` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `caisse`
--

INSERT INTO `caisse` (`id`, `montant`) VALUES
(1, 99300);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `designation`) VALUES
(1, 'Airtel'),
(2, 'Orange');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postnom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quartier` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avenue` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `postnom`, `prenom`, `sexe`, `quartier`, `avenue`, `telephone`) VALUES
(1, 'Default', 'Default', 'Default', 'm', 'Default', 'Default', 'default'),
(2, 'Abdiel', 'Muhindo', 'Kisumba', 'm', 'virunga', 'kis', '+243997604471'),
(3, 'Monsard', 'Muhindo', 'DD', 'm', 'office2', 'kis', '+243997604400');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

DROP TABLE IF EXISTS `fournisseurs`;
CREATE TABLE IF NOT EXISTS `fournisseurs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postnom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `nom`, `postnom`, `prenom`, `sexe`, `adresse`, `shop`, `telephone`) VALUES
(1, 'KAMBALE', 'KARAHIRE', 'Victoire', 'm', 'Q.Katoti', 'la benediction', '+243997604471');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(46, '2014_10_12_000000_create_users_table', 1),
(47, '2014_10_12_100000_create_password_resets_table', 1),
(48, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(49, '2022_02_28_164912_categorie_prod', 1),
(50, '2022_02_28_165102_client', 1),
(51, '2022_02_28_165125_fournisseur', 1),
(52, '2022_02_28_165324_produit', 1),
(53, '2022_02_28_183358_stock', 1),
(54, '2022_02_28_183612_panier', 1),
(55, '2022_02_28_183836_vente_products', 1),
(56, '2022_02_28_184024_stock_alerte', 1);

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `article` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` int(11) NOT NULL,
  `montant` double(8,2) NOT NULL,
  `dates` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id`, `client`, `article`, `nombre`, `montant`, `dates`) VALUES
(1, 'Default', 'Orange', 100, 100.00, '2022-03-06'),
(2, 'Default', 'Orange', 10, 50.00, '2022-03-06'),
(3, 'Default', 'Orange', 10, 10.00, '2022-03-06'),
(4, 'Default', 'Airtel', 10, 10.00, '2022-03-06'),
(5, 'Default', 'Airtel', 10, 10.00, '2022-03-06'),
(6, 'Default', 'Airtel', 100, 100.00, '2022-03-06');

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED NOT NULL,
  `fournisseur_id` int(10) UNSIGNED NOT NULL,
  `nombre` int(11) NOT NULL,
  `montant` double(8,2) NOT NULL,
  `dates` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_fournisseur_id_foreign` (`fournisseur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `category_id`, `fournisseur_id`, `nombre`, `montant`, `dates`) VALUES
(1, 2, 1, 100, 100.00, '2022-03-04'),
(2, 1, 1, 100, 100.00, '2022-03-04'),
(3, 1, 1, 100, 100.00, '2022-03-04'),
(4, 2, 1, 50, 50.00, '2022-03-04'),
(5, 2, 1, 50, 50.00, '2022-03-04'),
(6, 2, 1, 50, 50.00, '2022-03-06'),
(7, 2, 1, 50, 50.00, '2022-03-06'),
(8, 1, 1, 100, 100.00, '2022-03-06'),
(9, 1, 1, 100, 100.00, '2022-03-06');

-- --------------------------------------------------------

--
-- Structure de la table `products_sale`
--

DROP TABLE IF EXISTS `products_sale`;
CREATE TABLE IF NOT EXISTS `products_sale` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `nombre` int(11) NOT NULL,
  `montant` double(8,2) NOT NULL,
  `dates` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `products_sale_client_id_foreign` (`client_id`),
  KEY `products_sale_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products_sale`
--

INSERT INTO `products_sale` (`id`, `client_id`, `category_id`, `nombre`, `montant`, `dates`) VALUES
(1, 1, 2, 100, 100.00, '2022-03-06'),
(2, 1, 2, 10, 50.00, '2022-03-06'),
(3, 1, 2, 10, 10.00, '2022-03-06'),
(4, 1, 1, 10, 10.00, '2022-03-06'),
(5, 1, 1, 10, 10.00, '2022-03-06'),
(6, 1, 1, 100, 100.00, '2022-03-06');

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `article` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantite` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`id`, `article`, `quantite`) VALUES
(1, 'Orange', 80),
(2, 'Airtel', 80);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
