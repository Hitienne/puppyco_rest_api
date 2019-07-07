CREATE TABLE `contenu` (
    `id_produit` int  NOT NULL ,
    `id_commande` int  NOT NULL ,
    PRIMARY KEY (
        `id_produit`,`id_commande`
    )
);

CREATE TABLE `produit` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `id_categorie` int  NOT NULL ,
    `titre` varchar(50)  NOT NULL ,
    `prix` float  NOT NULL ,
    `image` varchar(10)  NOT NULL ,
    `description` varchar(300)  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `categorie` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `libelle` varchar(20)  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `commande` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `id_client` int  NOT NULL ,
    `date` date  NOT NULL ,
    `ville` varchar(20)  NOT NULL ,
    `pays` varchar(20)  NOT NULL ,
    `rue` varchar(20)  NOT NULL ,
    `code_postal` varchar(10)  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `client` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `email` varchar(25)  NOT NULL ,
    `password` varchar(64)  NOT NULL ,
    `nom` varchar(20)  NOT NULL ,
    `prenom` varchar(20)  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

ALTER TABLE `commande` ADD CONSTRAINT `fk_commande_id_client` FOREIGN KEY(`id_client`)
REFERENCES `client` (`id`);

ALTER TABLE `contenu` ADD CONSTRAINT `fk_contenu_id_produit` FOREIGN KEY(`id_produit`)
REFERENCES `produit` (`id`);

ALTER TABLE `contenu` ADD CONSTRAINT `fk_contenu_id_commande` FOREIGN KEY(`id_commande`)
REFERENCES `commande` (`id`);

ALTER TABLE `produit` ADD CONSTRAINT `fk_produit_id_categorie` FOREIGN KEY(`id_categorie`)
REFERENCES `categorie` (`id`);

SELECT * FROM client
