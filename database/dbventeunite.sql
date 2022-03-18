-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 17 mars 2022 à 19:50
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
DROP PROCEDURE IF EXISTS `sp_facture`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_facture` ()  BEGIN
DECLARE client varchar(255);
DECLARE unites int;
DECLARE tot float;
SELECT panier.client INTO client FROM panier GROUP BY panier.client;
SELECT SUM(panier.nombre) INTO unites FROM panier;
SELECT SUM(panier.montant) INTO tot FROM panier;
INSERT INTO factures(factures.client,unites,factures.montant_total,factures.datepaye)
VALUES(client,unites,tot,CURDATE());
END$$

DROP PROCEDURE IF EXISTS `sp_panier`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_panier` ()  NO SQL
BEGIN
SELECT * FROM panier;
DELETE FROM panier;
END$$

DROP PROCEDURE IF EXISTS `sp_payment`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_payment` (IN `fature` INT, IN `client` VARCHAR(50), IN `montan` FLOAT, IN `libelle` VARCHAR(225))  BEGIN
DECLARE mtcaisse float;
DECLARE idc int;
SELECT COUNT(id) INTO idc FROM caisses;
SELECT caisses.montant INTO mtcaisse FROM caisses;
IF(idc > 0)THEN
INSERT INTO payments(facture,client,montant_total,datepaye,libelle)VALUES(fature,client,
montan,CURDATE(),libelle);
UPDATE caisses SET caisses.montant=mtcaisse+montan;
ELSE
INSERT INTO payments(facture,client,montant_total,datepaye,libelle)VALUES(fature,client,
montan,CURDATE(),libelle);
INSERT INTO caisses(caisses.montant)VALUES(montan);
END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_produit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_produit` (IN `categ` VARCHAR(20), IN `nombre` FLOAT, IN `montan` FLOAT, IN `fourn` VARCHAR(20))  NO SQL
BEGIN 
DECLARE idc,idf,nbr,qte INT; 
DECLARE mtcaisse float;
SELECT COUNT(*) INTO nbr FROM stock WHERE stock.article=categ;
SET idc=(SELECT id FROM categories WHERE categories.designation=categ);
SET idf=(SELECT fournisseurs.id FROM fournisseurs WHERE fournisseurs.prenom=fourn);
SELECT caisses.montant INTO mtcaisse FROM caisses;
SELECT quantite INTO qte FROM stock WHERE stock.article=categ;
IF (nbr<=0)THEN
INSERT INTO products(category_id,nombre,montant,fournisseur_id,dates)VALUES(idc,nombre,montan,idf,CURDATE()); 
UPDATE caisses SET caisses.montant=mtcaisse-montan;
INSERT INTO stock(article,quantite)VALUES(categ,nombre);
ELSE
INSERT INTO products(category_id,nombre,montant,fournisseur_id,dates)VALUES(idc,nombre,montan,idf,CURDATE()); 
UPDATE caisses SET caisses.montant=mtcaisse-montan;
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
    INSERT INTO panier(id,client,article,nombre,montant)VALUES(idpan,cli,prod,nbr,montant);
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
-- Doublure de structure pour la vue `aff_products`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `aff_products`;
CREATE TABLE IF NOT EXISTS `aff_products` (
`id` int(10) unsigned
,`Produit` varchar(100)
,`nombre` int(11)
,`montant` double(8,2)
,`Fournisseur` varchar(100)
,`dates` date
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `aff_produit`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `aff_produit`;
CREATE TABLE IF NOT EXISTS `aff_produit` (
`Produit` varchar(100)
,`nombre` int(11)
,`montant` double(8,2)
,`fournisseur` varchar(100)
,`dates` date
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `aff_vente`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `aff_vente`;
CREATE TABLE IF NOT EXISTS `aff_vente` (
`id` int(10) unsigned
,`Client` varchar(100)
,`Produit` varchar(100)
,`nombre` int(11)
,`montant` double(8,2)
,`dates` date
);

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
(1, 99100);

-- --------------------------------------------------------

--
-- Structure de la table `caisses`
--

DROP TABLE IF EXISTS `caisses`;
CREATE TABLE IF NOT EXISTS `caisses` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `montant` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `caisses`
--

INSERT INTO `caisses` (`id`, `montant`) VALUES
(2, 10000);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `designation`) VALUES
(1, 'Airtel');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `postnom`, `prenom`, `sexe`, `quartier`, `avenue`, `telephone`) VALUES
(1, 'Default', 'Default', 'Default', 'm', 'Default', 'Default', 'default'),
(2, 'KAMBALE', 'KARAHIRE', 'Victoire', 'm', 'virunga', 'kis', '+243997604471');

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

DROP TABLE IF EXISTS `factures`;
CREATE TABLE IF NOT EXISTS `factures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client` varchar(255) NOT NULL,
  `unites` int(11) NOT NULL,
  `montant_total` float NOT NULL,
  `datepaye` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `factures`
--

INSERT INTO `factures` (`id`, `client`, `unites`, `montant_total`, `datepaye`) VALUES
(3, 'Default', 55, 200, '2022-03-12'),
(4, 'Default', 75, 220, '2022-03-15'),
(5, 'Default', 85, 230, '2022-03-15'),
(6, 'Default', 10, 10, '2022-03-17');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `nom`, `postnom`, `prenom`, `sexe`, `adresse`, `shop`, `telephone`) VALUES
(1, 'Monsard', 'Kambale', 'Salama', 'm', '3Lampes', 'la gloire', '+243997604471');

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
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(57, '2014_10_12_000000_create_users_table', 1),
(58, '2014_10_12_100000_create_password_resets_table', 1),
(59, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(60, '2022_02_28_164912_categorie_prod', 1),
(61, '2022_02_28_165102_client', 1),
(62, '2022_02_28_165125_fournisseur', 1),
(63, '2022_02_28_165324_produit', 1),
(64, '2022_02_28_183358_stock', 1),
(65, '2022_02_28_183612_panier', 1),
(66, '2022_02_28_183836_vente_products', 1),
(67, '2022_02_28_184024_stock_alerte', 1),
(68, '2022_03_03_083421_caisse', 2);

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Structure de la table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facture` int(11) NOT NULL,
  `client` varchar(255) NOT NULL,
  `montant_total` float NOT NULL,
  `datepaye` datetime NOT NULL,
  `libelle` varchar(225) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_fac` (`facture`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `payments`
--

INSERT INTO `payments` (`id`, `facture`, `client`, `montant_total`, `datepaye`, `libelle`) VALUES
(1, 3, 'Default', 200, '2022-03-14 00:00:00', 'payement facture'),
(2, 4, 'Default', 220, '2022-03-15 00:00:00', 'payement facture'),
(3, 5, 'Default', 230, '2022-03-15 00:00:00', 'payement facture'),
(5, 6, 'Default', 10, '2022-03-17 00:00:00', 'payement facture');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `category_id`, `fournisseur_id`, `nombre`, `montant`, `dates`) VALUES
(1, 1, 1, 200, 200.00, '2022-03-11'),
(2, 1, 1, 100, 100.00, '2022-03-17');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products_sale`
--

INSERT INTO `products_sale` (`id`, `client_id`, `category_id`, `nombre`, `montant`, `dates`) VALUES
(1, 1, 1, 5, 100.00, '2022-03-11'),
(2, 1, 1, 5, 100.00, '2022-03-11'),
(3, 1, 1, 50, 100.00, '2022-03-12'),
(4, 1, 1, 50, 100.00, '2022-03-12'),
(5, 1, 1, 20, 20.00, '2022-03-15'),
(6, 1, 1, 10, 10.00, '2022-03-15'),
(7, 1, 1, 10, 10.00, '2022-03-17');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`id`, `article`, `quantite`) VALUES
(1, 'Airtel', 150);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'vaingueurkambale@gmail.com', '$2y$10$T8p9zTw.TUxnr0i/s4.3Xel4zQ.VnheefWsm7EMj3taKMXd6K8vkC', '2022-03-10 16:17:05', '2022-03-10 16:17:05');

-- --------------------------------------------------------

--
-- Structure de la vue `aff_products`
--
DROP TABLE IF EXISTS `aff_products`;

DROP VIEW IF EXISTS `aff_products`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `aff_products`  AS  select `products`.`id` AS `id`,`categories`.`designation` AS `Produit`,`products`.`nombre` AS `nombre`,`products`.`montant` AS `montant`,`fournisseurs`.`prenom` AS `Fournisseur`,`products`.`dates` AS `dates` from ((`products` join `categories` on((`categories`.`id` = `products`.`category_id`))) join `fournisseurs` on((`fournisseurs`.`id` = `products`.`fournisseur_id`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `aff_produit`
--
DROP TABLE IF EXISTS `aff_produit`;

DROP VIEW IF EXISTS `aff_produit`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `aff_produit`  AS  select `categories`.`designation` AS `Produit`,`products`.`nombre` AS `nombre`,`products`.`montant` AS `montant`,`fournisseurs`.`prenom` AS `fournisseur`,`products`.`dates` AS `dates` from ((`products` join `categories` on((`categories`.`id` = `products`.`category_id`))) join `fournisseurs` on((`fournisseurs`.`id` = `products`.`fournisseur_id`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `aff_vente`
--
DROP TABLE IF EXISTS `aff_vente`;

DROP VIEW IF EXISTS `aff_vente`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `aff_vente`  AS  select `products_sale`.`id` AS `id`,`clients`.`prenom` AS `Client`,`categories`.`designation` AS `Produit`,`products_sale`.`nombre` AS `nombre`,`products_sale`.`montant` AS `montant`,`products_sale`.`dates` AS `dates` from ((`products_sale` join `categories` on((`categories`.`id` = `products_sale`.`category_id`))) join `clients` on((`clients`.`id` = `products_sale`.`client_id`))) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
