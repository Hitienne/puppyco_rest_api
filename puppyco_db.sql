-- -------------------------------------------------------------
-- TablePlus 2.6(242)
--
-- https://tableplus.com/
--
-- Database: puppyco_db
-- Generation Time: 2019-07-15 22:32:50.9980
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE TABLE `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(25) NOT NULL,
  `password` varchar(64) NOT NULL,
  `roles` json NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

CREATE TABLE `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  `date` date NOT NULL,
  `ville` varchar(20) NOT NULL,
  `pays` varchar(20) NOT NULL,
  `rue` varchar(20) NOT NULL,
  `code_postal` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_commande_id_client` (`id_client`),
  CONSTRAINT `fk_commande_id_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `contenu` (
  `id` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contenu_id_produit` (`id_produit`),
  KEY `fk_contenu_id_commande` (`id_commande`),
  CONSTRAINT `fk_contenu_id_commande` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id`),
  CONSTRAINT `fk_contenu_id_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `produit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categorie` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `prix` float NOT NULL,
  `images` json NOT NULL,
  `description` varchar(300) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produit_id_categorie` (`id_categorie`),
  CONSTRAINT `fk_produit_id_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

INSERT INTO `categorie` (`id`, `libelle`) VALUES ('1', 'test');

INSERT INTO `client` (`id`, `email`, `password`, `roles`, `nom`, `prenom`) VALUES ('1', 'borniche.leo@gmail.com', '339772bce04852647c44de0a73a314fc7a8e842266a80307299811b6c46b16f6', '[\"ROLE_USER\"]', 'borniche', 'Leo'),
('2', 'borniche.leo@gmail.com', '339772bce04852647c44de0a73a314fc7a8e842266a80307299811b6c46b16f6', '[\"ROLE_USER\"]', 'borniche', 'Leo'),
('3', 'borniche.leo@gmail.com', '339772bce04852647c44de0a73a314fc7a8e842266a80307299811b6c46b16f6', '[\"ROLE_USER\"]', 'borniche', 'Leo'),
('4', 'borniche.leo@gmail.com', '339772bce04852647c44de0a73a314fc7a8e842266a80307299811b6c46b16f6', '[\"ROLE_USER\"]', 'borniche', 'Leo'),
('5', 'borniche.leo@gmail.com', '339772bce04852647c44de0a73a314fc7a8e842266a80307299811b6c46b16f6', '[\"ROLE_USER\"]', 'borniche', 'Leo'),
('6', 'borniche.leo@gmail.com', '339772bce04852647c44de0a73a314fc7a8e842266a80307299811b6c46b16f6', '[\"ROLE_USER\"]', 'borniche', 'Leo'),
('7', 'borniche.leo@gmail.com', '339772bce04852647c44de0a73a314fc7a8e842266a80307299811b6c46b16f6', '[\"ROLE_USER\"]', 'borniche', 'Leo');

INSERT INTO `produit` (`id`, `id_categorie`, `titre`, `prix`, `images`, `description`, `stock`) VALUES ('12', '1', 'un produit bien', '10.99', '{\"arr\": [\"img\"]}', 'un super produit', '10'),
('13', '1', 'un produit bien', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('14', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('15', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('16', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('17', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('18', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('19', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('20', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('21', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('22', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('23', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('24', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('25', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('26', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('27', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('28', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('29', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('30', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10'),
('31', '1', 'un produit enorme', '10.99', '{\"principale\": \"img\", \"secondaire\": [\"img\", \"img\"]}', 'un super produit', '10');




/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;