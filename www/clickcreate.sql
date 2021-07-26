SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



--
-- Base de données : `clickCreate`
--

-- --------------------------------------------------------

--
-- Structure de la table `cc_attributes`
--

CREATE TABLE `cc_attributes` (
                                 `id` int(11) NOT NULL,
                                 `name` varchar(50) COLLATE utf8_bin NOT NULL,
                                 `description` longtext COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `cc_attributes`
--

INSERT INTO `cc_attributes` (`id`, `name`, `description`) VALUES
(1, 'Aucun attribut', 'Aucun attribut');

-- --------------------------------------------------------

--
-- Structure de la table `cc_category`
--

CREATE TABLE `cc_category` (
                               `id` int(11) NOT NULL,
                               `name` varchar(150) COLLATE utf8_bin NOT NULL,
                               `description` longtext COLLATE utf8_bin,
                               `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `cc_group_variant`
--

CREATE TABLE `cc_group_variant` (
                                    `id` int(11) NOT NULL,
                                    `price` double NOT NULL,
                                    `stock` int(11) NOT NULL,
                                    `picture` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `cc_orders`
--

CREATE TABLE `cc_orders` (
                             `id` int(11) NOT NULL,
                             `montant` float NOT NULL,
                             `payment_intent` VARCHAR(255) NOT NULL,
                             `User_id` int(11) NOT NULL,
                             `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                             `status` tinyint(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `cc_pages`
--

CREATE TABLE `cc_pages` (
                            `id` int(11) NOT NULL,
                            `name` varchar(255) COLLATE utf8_bin NOT NULL,
                            `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            `slug` varchar(255) COLLATE utf8_bin NOT NULL,
                            `publication` int(1) NOT NULL,
                            `User_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `cc_products`
--

CREATE TABLE `cc_products` (
                               `id` int(11) NOT NULL,
                               `name` varchar(200) COLLATE utf8_bin NOT NULL,
                               `description` longtext COLLATE utf8_bin NOT NULL,
                               `type` tinyint(1) NOT NULL,
                               `isPublished` tinyint(1) NOT NULL,
                               `idCategory` int(11) NOT NULL,
                               `status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `cc_product_order`
--

CREATE TABLE `cc_product_order` (
                                    `id` int(11) NOT NULL,
                                    `id_group_variant` int(11) NOT NULL,
                                    `id_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Structure de la table `cc_product_term`
--

CREATE TABLE `cc_product_term` (
                                   `id` int(11) NOT NULL,
                                   `idProduct` int(11) NOT NULL,
                                   `idTerm` int(11) NOT NULL,
                                   `idGroup` int(11) NOT NULL,
                                   `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `cc_review`
--

CREATE TABLE `cc_review` (
                             `id` int(11) NOT NULL,
                             `commentary` longtext COLLATE utf8_bin,
                             `mark` float DEFAULT NULL,
                             `status` tinyint(4) NOT NULL,
                             `Products_id` int(11) NOT NULL,
                             `User_id` int(11) NOT NULL,
                             `createdAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `cc_role`
--

CREATE TABLE `cc_role` (
                           `id` int(11) NOT NULL,
                           `name` varchar(255) NOT NULL,
                           `roles` tinyint(1) NOT NULL DEFAULT '0',
                           `users` tinyint(1) NOT NULL DEFAULT '0',
                           `customers` tinyint(1) NOT NULL DEFAULT '0',
                           `products` tinyint(1) NOT NULL DEFAULT '0',
                           `categories` tinyint(1) NOT NULL DEFAULT '0',
                           `orders` tinyint(1) NOT NULL DEFAULT '0',
                           `opinions` tinyint(1) NOT NULL DEFAULT '0',
                           `pages` tinyint(1) NOT NULL DEFAULT '0',
                           `settingsCms` tinyint(1) NOT NULL DEFAULT '0',
                           `settingsSite` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `cc_role`
--

INSERT INTO `cc_role` (`id`, `name`, `roles`, `users`, `customers`, `products`, `categories`, `orders`, `opinions`, `pages`, `settingsCms`, `settingsSite`) VALUES
(1, 'Admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 'Client', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `cc_shop`
--

CREATE TABLE `cc_shop` (
                           `id` int(11) NOT NULL,
                           `name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
                           `address` varchar(255) COLLATE utf8_bin NOT NULL,
                           `city` varchar(150) COLLATE utf8_bin NOT NULL,
                           `zipCode` varchar(5) COLLATE utf8_bin NOT NULL,
                           `phoneNumber` varchar(10) COLLATE utf8_bin NOT NULL,
                           `description` longtext COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `cc_terms`
--

CREATE TABLE `cc_terms` (
                            `id` int(11) NOT NULL,
                            `name` varchar(30) COLLATE utf8_bin NOT NULL,
                            `idAttributes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `cc_product_term`
--

INSERT INTO `cc_terms` (`id`, `name`, `idAttributes`) VALUES ('1', 'Aucun attribut', '1');

-- --------------------------------------------------------

--
-- Structure de la table `cc_user`
--

CREATE TABLE `cc_user` (
                           `id` int(11) NOT NULL,
                           `firstname` varchar(50) COLLATE utf8_bin NOT NULL,
                           `lastname` varchar(100) COLLATE utf8_bin NOT NULL,
                           `email` varchar(350) COLLATE utf8_bin NOT NULL,
                           `pwd` varchar(255) COLLATE utf8_bin NOT NULL,
                           `token` varchar(255) COLLATE utf8_bin NOT NULL,
                           `country` char(2) COLLATE utf8_bin DEFAULT NULL,
                           `status` tinyint(1) NOT NULL,
                           `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                           `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                           `id_role` int(11) NOT NULL,
                           `address` varchar(350) COLLATE utf8_bin DEFAULT NULL,
                           `city` varchar(45) COLLATE utf8_bin DEFAULT NULL,
                           `zipcode` varchar(45) COLLATE utf8_bin DEFAULT NULL,
                           `phoneNumber` varchar(10) COLLATE utf8_bin DEFAULT NULL,
                           `isConfirmed` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- -------------------------------------------------------

--
-- Structure de la table `cc_navbar`
--

CREATE TABLE `cc_navbar` (
                             `id` int(11) NOT NULL,
                             `name` varchar(50) COLLATE utf8_bin NOT NULL,
                             `sort` int(11) NOT NULL,
                             `page` int(11) DEFAULT NULL,
                             `category` int(11) DEFAULT NULL,
                             `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- -------------------------------------------------------

--
-- Structure de la table `cc_tab_navbar`
--

CREATE TABLE `cc_tab_navbar` (
                                 `id` int(11) NOT NULL,
                                 `name` varchar(50) COLLATE utf8_bin NOT NULL,
                                 `page` int(11) DEFAULT NULL,
                                 `category` int(11) DEFAULT NULL,
                                 `navbar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- -------------------------------------------------------

--
-- Structure de la table `cc_themes`
--

CREATE TABLE `cc_themes` (
                             `id` int(11) NOT NULL,
                             `name` varchar(20) COLLATE utf8_bin NOT NULL,
                             `file` varchar(255) COLLATE utf8_bin NOT NULL,
                             `status` int(11) NOT NULL,
                             `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------------------


--
-- Index pour la table `cc_attributes`
--
ALTER TABLE `cc_attributes`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cc_category`
--
ALTER TABLE `cc_category`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cc_group_variant`
--
ALTER TABLE `cc_group_variant`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cc_orders`
--
ALTER TABLE `cc_orders`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Orders_User1_idx` (`User_id`);

--
-- Index pour la table `cc_pages`
--
ALTER TABLE `cc_pages`
    ADD PRIMARY KEY (`id`,`User_id`),
  ADD KEY `fk_Pages_User1_idx` (`User_id`);

--
-- Index pour la table `cc_products`
--
ALTER TABLE `cc_products`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_category` (`idCategory`);

--
-- Index pour la table `cc_product_order`
--
ALTER TABLE `cc_product_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_group_variant` (`id_group_variant`);

--
-- Index pour la table `cc_product_term`
--
ALTER TABLE `cc_product_term`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_term` (`idTerm`),
  ADD KEY `FK_product` (`idProduct`),
  ADD KEY `FK_group_variant` (`idGroup`);

--
-- Index pour la table `cc_review`
--
ALTER TABLE `cc_review`
    ADD PRIMARY KEY (`id`,`Products_id`,`User_id`),
  ADD KEY `fk_Review_Products1_idx` (`Products_id`),
  ADD KEY `fk_Review_User1_idx` (`User_id`);

--
-- Index pour la table `cc_role`
--
ALTER TABLE `cc_role`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cc_shop`
--
ALTER TABLE `cc_shop`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cc_terms`
--
ALTER TABLE `cc_terms`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_attributes` (`idAttributes`);

--
-- Index pour la table `cc_user`
--
ALTER TABLE `cc_user`
    ADD PRIMARY KEY (`id`,`id_role`),
  ADD KEY `fk_User_role1_idx` (`id_role`);

--
-- Index pour la table `cc_navbar`
--
ALTER TABLE `cc_navbar`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_page` (`page`),
  ADD KEY `FK_cate` (`category`);

--
-- Index pour la table `cc_tab_navbar`
--
ALTER TABLE `cc_tab_navbar`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_page_tab` (`page`),
  ADD KEY `FK_cate_tab` (`category`),
  ADD KEY `FK_navbar` (`navbar`);

--
-- Index pour la table `cc_themes`
--
ALTER TABLE `cc_themes`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user` (`admin`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cc_attributes`
--
ALTER TABLE `cc_attributes`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `cc_category`
--
ALTER TABLE `cc_category`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cc_group_variant`
--
ALTER TABLE `cc_group_variant`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cc_pages`
--
ALTER TABLE `cc_pages`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cc_products`
--
ALTER TABLE `cc_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cc_product_order`
--
ALTER TABLE `cc_product_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cc_product_term`
--
ALTER TABLE `cc_product_term`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cc_review`
--
ALTER TABLE `cc_review`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cc_role`
--
ALTER TABLE `cc_role`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `cc_shop`
--
ALTER TABLE `cc_shop`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cc_terms`
--
ALTER TABLE `cc_terms`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cc_user`
--
ALTER TABLE `cc_user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cc_navbar`
--
ALTER TABLE `cc_navbar`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cc_tab_navbar`
--
ALTER TABLE `cc_tab_navbar`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cc_themes`
--
ALTER TABLE `cc_themes`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cc_orders`
--
ALTER TABLE `cc_orders`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cc_orders`
--
ALTER TABLE `cc_orders`
  ADD CONSTRAINT `fk_Orders_User1` FOREIGN KEY (`User_id`) REFERENCES `cc_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `cc_pages`
--
ALTER TABLE `cc_pages`
    ADD CONSTRAINT `fk_Pages_User1` FOREIGN KEY (`User_id`) REFERENCES `cc_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `cc_products`
--
ALTER TABLE `cc_products`
    ADD CONSTRAINT `FK_category` FOREIGN KEY (`idCategory`) REFERENCES `cc_category` (`id`);

--
-- Contraintes pour la table `cc_product_order`
--
ALTER TABLE `cc_product_order`
  ADD CONSTRAINT `cc_product_order_ibfk_2` FOREIGN KEY (`id_order`) REFERENCES `cc_orders` (`id`),
  ADD CONSTRAINT `cc_product_order_ibfk_3` FOREIGN KEY (`id_group_variant`) REFERENCES `cc_group_variant` (`id`);

--
-- Contraintes pour la table `cc_product_term`
--
ALTER TABLE `cc_product_term`
    ADD CONSTRAINT `FK_group_variant` FOREIGN KEY (`idGroup`) REFERENCES `cc_group_variant` (`id`),
  ADD CONSTRAINT `FK_product` FOREIGN KEY (`idProduct`) REFERENCES `cc_products` (`id`),
  ADD CONSTRAINT `FK_term` FOREIGN KEY (`idTerm`) REFERENCES `cc_terms` (`id`);

--
-- Contraintes pour la table `cc_review`
--
ALTER TABLE `cc_review`
    ADD CONSTRAINT `fk_Review_Products1` FOREIGN KEY (`Products_id`) REFERENCES `cc_products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Review_User1` FOREIGN KEY (`User_id`) REFERENCES `cc_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `cc_terms`
--
ALTER TABLE `cc_terms`
    ADD CONSTRAINT `FK_attributes` FOREIGN KEY (`idAttributes`) REFERENCES `cc_attributes` (`id`);

--
-- Contraintes pour la table `cc_user`
--
ALTER TABLE `cc_user`
    ADD CONSTRAINT `fk_User_role1` FOREIGN KEY (`id_role`) REFERENCES `cc_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

--
-- Contraintes pour la table `cc_navbar`
--
ALTER TABLE `cc_navbar`
    ADD CONSTRAINT `FK_cate` FOREIGN KEY (`category`) REFERENCES `cc_category` (`id`),
  ADD CONSTRAINT `FK_page` FOREIGN KEY (`page`) REFERENCES `cc_pages` (`id`);
COMMIT;

--
-- Contraintes pour la table `cc_tab_navbar`
--
ALTER TABLE `cc_tab_navbar`
    ADD CONSTRAINT `FK_cate_tab` FOREIGN KEY (`category`) REFERENCES `cc_category` (`id`),
  ADD CONSTRAINT `FK_navbar` FOREIGN KEY (`navbar`) REFERENCES `cc_navbar` (`id`),
  ADD CONSTRAINT `FK_page_tab` FOREIGN KEY (`page`) REFERENCES `cc_pages` (`id`);
COMMIT;

--
-- Contraintes pour la table `cc_themes`
--
ALTER TABLE `cc_themes`
    ADD CONSTRAINT `FK_user` FOREIGN KEY (`admin`) REFERENCES `cc_user` (`id`);
COMMIT;


SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));