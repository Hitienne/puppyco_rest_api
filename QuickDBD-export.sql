CREATE TABLE `Contenu` (
    `id_produit` int  NOT NULL ,
    `id_commande` int  NOT NULL ,
    PRIMARY KEY (
        `id_produit`,`id_commande`
    )
);

CREATE TABLE `Produit` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `id_categorie` int  NOT NULL ,
    `titre` varchar(10)  NOT NULL ,
    `prix` float(3)  NOT NULL ,
    `image` varchar(10)  NOT NULL ,
    `description` varchar(300)  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `Categorie` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `libelle` varchar(10)  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `Commande` (
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

CREATE TABLE `Client` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `email` varchar(10)  NOT NULL ,
    `password` varchar(64)  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

ALTER TABLE `Contenu` ADD CONSTRAINT `fk_Contenu_id_produit` FOREIGN KEY(`id_produit`)
REFERENCES `Produit` (`id`);

ALTER TABLE `Contenu` ADD CONSTRAINT `fk_Contenu_id_commande` FOREIGN KEY(`id_commande`)
REFERENCES `Commande` (`id`);

ALTER TABLE `Produit` ADD CONSTRAINT `fk_Produit_id_categorie` FOREIGN KEY(`id_categorie`)
REFERENCES `Categorie` (`id`);

ALTER TABLE `Commande` ADD CONSTRAINT `fk_Commande_id_client` FOREIGN KEY(`id_client`)
REFERENCES `Client` (`id`);

