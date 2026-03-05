-- Table categories
CREATE TABLE `categories` (
    `cat_id` INT AUTO_INCREMENT PRIMARY KEY,
    `cat_title` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(1, 'Lanceurs'),
(2, 'Rouleaux'),
(3, 'Snipers'),
(4, 'Seauceurs'),
(5, 'Pinceaux'),
(6, 'Éclatanas');

-- Table comptes
CREATE TABLE `comptes` (
    `user_id` INT AUTO_INCREMENT PRIMARY KEY,
    `pseudo` TEXT NOT NULL,
    `nom` VARCHAR(100) NOT NULL,
    `prenom` VARCHAR(100) NOT NULL,
    `email` VARCHAR(300) NOT NULL,
    `password` VARCHAR(300) NOT NULL,
    `mobile` VARCHAR(10) NOT NULL,
    `address1` VARCHAR(300) NOT NULL,
    `address2` VARCHAR(11) NOT NULL,
    `departement` INT NOT NULL,
    `type_de_compte` TINYINT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `comptes` (`user_id`, `pseudo`, `nom`, `prenom`, `email`, `password`, `mobile`, `address1`, `address2`, `departement`, `type_de_compte`) VALUES
(0, 'CartoucheInc', 'Limule', 'Cartouche', 'cartouche@la-maree-armee.com', '918bba63d066b83c418905067fc5cfd1', '0123456', '1 Place de Chromapolis', 'Chromapolis', 88200, 2),
(1, 'Beelz', 'Abyss', 'Beelzebub', 'furinauwu@luscious.net', 'ca4bba6cd6410128fa6c558de9527eb8', '0123456789', '666 Profondeurs des abysses', 'Fontaine', 55555, 1),
(2, 'Marina4', 'Marina', 'Ida', 'ida.marina@gmail.com', '5a6c364770674077611eae407a153545', '2738945', '12 Galleries Inkamari', 'Chromapolis', 23130, 1),
(3, 'Agent7', 'SECRET', 'SECRET', 'agent7@orcca.fr', 'a8e10ef80b98ef66a11053ee94614a94', '0712345678', '4ème Régiment', 'Inkopolis', 76, 0);

-- Table produits
CREATE TABLE `produits` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `categorie` INT NOT NULL,
    `nom` VARCHAR(32) NOT NULL,
    `prix` INT NOT NULL,
    `niveau` INT NOT NULL,
    `portee` INT NOT NULL,
    `vitesse_encrage` INT NOT NULL,
    `legeretee` INT NOT NULL,
    `image` TEXT NOT NULL,
    `num_order` INT NOT NULL DEFAULT 0,
    `id_vendeur` INT NOT NULL,
    FOREIGN KEY (`id_vendeur`) REFERENCES `comptes` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `produits` (`id`, `categorie`, `nom`, `prix`, `niveau`, `portee`, `vitesse_encrage`, `legeretee`, `image`, `num_order`, `id_vendeur`) VALUES
(1, 1, 'Liquidateur Jr.', 180, 1, 50, 80, 60, 'liquidateur_jr.png', 1, 0),
(2, 1, 'Lanceur héroïque (réplique)', 250, 2, 60, 70, 65, 'lanceur_heroique_rep.png', 0, 0),
(3, 1, 'Liquidateur', 320, 3, 70, 85, 70, 'liquidateur.png', 2, 0),
(4, 1, 'Aérogun', 400, 4, 80, 90, 75, 'aerogun.png', 0, 0),
(5, 1, 'N-ZAP-85', 450, 5, 85, 95, 80, 'n_zap_85.png', 1, 0),
(6, 1, 'Marqueur lourd', 500, 6, 90, 100, 85, 'marqueur_lourd.png', 0, 0),
(7, 1, 'Liquidateur pro', 550, 7, 95, 105, 90, 'liquidateur_pro.png', 0, 0),
(8, 2, 'Rouleau', 200, 1, 30, 60, 50, 'rouleau.png', 0, 0),
(9, 2, 'Dynamo-rouleau', 280, 2, 35, 70, 55, 'dynamo_rouleau.png', 0, 0),
(10, 2, 'Flexi-rouleau', 350, 3, 40, 75, 60, 'flexi_rouleau.png', 1, 0),
(11, 3, 'Concentrateur', 400, 1, 60, 90, 70, 'concentrateur.png', 0, 0),
(12, 3, 'Extraceur +', 480, 2, 65, 95, 75, 'extraceur_plus.png', 0, 0),
(13, 3, 'Bimbamboum Mk I', 550, 3, 70, 100, 80, 'bimbamboum_mk_i.png', 1, 0),
(14, 4, 'Seauceur', 250, 1, 40, 70, 50, 'seauceur.png', 1, 0),
(15, 4, 'Encrifugeur', 320, 2, 45, 75, 55, 'encrifugeur.png', 0, 0),
(16, 5, 'Épinceau brosse', 380, 1, 50, 80, 60, 'epinceau_brosse.png', 0, 0),
(17, 5, 'Épinceau', 450, 2, 55, 85, 65, 'epinceau.png', 1, 0),
(18, 6, 'Éclatana Doto', 500, 1, 60, 90, 70, 'eclatana_doto.png', 0, 0),
(19, 6, 'Éclatana d estampe', 550, 2, 65, 95, 75, 'eclatana_d_estampe.png', 1, 0);

-- Table commentaires
CREATE TABLE `commentaires` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_produit` INT NOT NULL,
    `pseudo` TEXT NOT NULL,
    `texte` TEXT NOT NULL,
    `media` TEXT DEFAULT NULL,
    FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `commentaires` (`id`, `id_produit`, `pseudo`, `texte`, `media`) VALUES
(7, 3, 'Marina4', 'Impeccable. Un excellent équilibre de légèreté et de dégâts.', 'img_commentaires/marina_with_a_splatter.jpg');

-- Table historique_achat
CREATE TABLE `historique_achat` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_produit` INT NOT NULL,
    `id_acheteur` INT NOT NULL,
    `id_vendeur` INT NOT NULL,
    FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id`),
    FOREIGN KEY (`id_acheteur`) REFERENCES `comptes` (`user_id`),
    FOREIGN KEY (`id_vendeur`) REFERENCES `comptes` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `historique_achat` (`id`, `id_produit`, `id_acheteur`, `id_vendeur`) VALUES
(1, 1, 1, 0),
(2, 17, 0, 2),
(3, 13, 2, 1),
(4, 5, 1, 2),
(5, 19, 2, 0),
(6, 3, 1, 0),
(7, 3, 2, 0),
(8, 14, 2, 0),
(9, 10, 1, 2),
(18, 3, 2, 0),
(19, 10, 2, 0),
(20, 14, 2, 0);

-- Table panier
CREATE TABLE `panier` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_produit` INT NOT NULL,
    `id_user` INT DEFAULT NULL,
    FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id`),
    FOREIGN KEY (`id_user`) REFERENCES `comptes` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Table liste_de_souhaits
CREATE TABLE `liste_de_souhaits` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_produit` INT NOT NULL,
    `id_compte` INT NOT NULL,
    FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id`),
    FOREIGN KEY (`id_compte`) REFERENCES `comptes` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
