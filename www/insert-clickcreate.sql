INSERT INTO `cc_pages` (`id`, `name`, `slug`, `publication`, `User_id`) VALUES
(1, 'Accueil', '/', 1, 1);

INSERT INTO `cc_themes` (`id`, `name`, `file`, `status`, `admin`) VALUES
(1, 'Default', 'pageFronts.css', 1, 1),
(2, 'Onizuka', 'theme-1.css', 0, 1);

INSERT INTO `cc_attributes` (`id`, `name`, `description`) VALUES
(2, 'Couleur', ''),
(3, 'Taille', ''),
(8, 'Style', ''),
(9, 'Motif', ''),
(10, 'Energie', ''),
(11, 'Autonomie', ''),
(12, 'Connectivite', ''),
(13, 'Poids', ''),
(14, 'Dimensions', ''),
(15, 'Batterie', ''),
(16, 'DAS', '');

INSERT INTO `cc_category` (`id`, `name`, `description`, `status`) VALUES
(1, 'chapeau', '', 1),
(2, 'casquette', '', 1),
(3, 'pantalon', '', 1),
(5, 'tee shirt', '', 1),
(6, 'outils', '', 1),
(7, 'medias', '', 1),
(8, 'sports', '', 1);

INSERT INTO `cc_group_variant` (`id`, `price`, `stock`, `picture`) VALUES
(116, 21.99, 100, NULL),
(117, 19.99, 90, NULL),
(118, 15.99, 50, NULL),
(119, 49.99, 200, NULL),
(120, 48.99, 160, NULL),
(121, 509.99, 200, NULL),
(122, 619.99, 299, NULL),
(123, 79.99, 500, NULL),
(124, 60.99, 450, NULL),
(125, 78.99, 600, NULL),
(126, 54.99, 99, NULL);

INSERT INTO `cc_navbar` (`id`, `name`, `sort`, `page`, `category`, `status`) VALUES
(5, 'Collections', 1, NULL, NULL, 1);

INSERT INTO `cc_orders` (`id`, `montant`, `payment_intent`, `User_id`, `CreatedAt`, `status`) VALUES
(26, 619.99, 'pi_1JHwZrGueu1Z1r2SkWyNEFB5', 1, '2021-07-27 20:08:55', 1),
(27, 54.99, 'pi_1JHwbXGueu1Z1r2SXxthDO6A', 1, '2021-07-27 20:10:41', 0);

INSERT INTO `cc_products` (`id`, `name`, `description`, `type`, `isPublished`, `idCategory`, `status`) VALUES
(42, 'Chapeau Rouge', '', 1, 1, 1, 1),
(43, 'Chapeau Vert', '', 1, 1, 1, 1),
(44, 'Jean', 'Beau jean de diffÃ©rentes tailles et couleurs', 1, 1, 3, 1),
(45, 'Samsung Galaxy S8', 'Beau samsung galaxy S8 venu tout droit de Chine', 1, 1, 7, 1),
(46, 'Crampon Adidas', 'Crampon Adidas de diffÃ©rentes tailles', 1, 1, 8, 1),
(47, 'Marteau', 'Marteau piqueur', 0, 1, 6, 1);

INSERT INTO `cc_product_order` (`id`, `id_group_variant`, `id_order`) VALUES
(139, 122, 26),
(140, 126, 27);

INSERT INTO `cc_terms` (`id`, `name`, `idAttributes`) VALUES
(2, 'Bleu', 2),
(3, 'Vert', 2),
(4, 'Rouge', 2),
(5, 'L', 3),
(6, 'S', 3),
(7, 'M', 3),
(8, 'XS', 3),
(9, 'Blanc', 2),
(10, 'style1', 8),
(11, 'style2', 8),
(12, 'style3', 8),
(13, 'style4', 8),
(14, 'Motif1', 9),
(15, 'Motif2', 9),
(16, 'Motif3', 9),
(17, 'Motif4', 9),
(18, 'Energie1', 10),
(19, 'Energie2', 10),
(20, 'Energie3', 10),
(21, 'Energie4', 10),
(22, 'Autonomie1', 11),
(23, 'Autonomie2', 11),
(24, 'Autonomie3', 11),
(25, 'Autonomie4', 11),
(26, 'Connectivite1', 12),
(27, 'Connectivite2', 12),
(28, 'Connectivite3', 12),
(29, 'Connectivite4', 12),
(30, 'Poids1', 13),
(31, 'Poids2', 13),
(32, 'Poids3', 13),
(33, 'Poids4', 13),
(34, '15pouces', 14),
(35, '16pouces', 14),
(36, '17pouces', 14),
(37, '24pouces', 14),
(38, '13pouces', 14),
(39, 'Batterie1', 15),
(40, 'Batterie2', 15),
(41, 'Batterie4', 15),
(42, 'Batterie3', 15),
(43, 'DAS1', 16),
(44, 'DAS2', 16),
(45, 'NiHM', 16),
(46, 'DAS3', 16);

INSERT INTO `cc_product_term` (`id`, `idProduct`, `idTerm`, `idGroup`, `status`) VALUES
(179, 42, 5, 116, 1),
(180, 42, 4, 116, 1),
(181, 42, 6, 117, 1),
(182, 42, 4, 117, 1),
(183, 43, 3, 118, 1),
(184, 44, 5, 119, 1),
(185, 44, 2, 119, 1),
(186, 44, 7, 120, 1),
(187, 44, 2, 120, 1),
(188, 45, 24, 121, 1),
(189, 45, 30, 121, 1),
(190, 45, 34, 121, 1),
(191, 45, 24, 122, 1),
(192, 45, 30, 122, 1),
(193, 45, 35, 122, 1),
(194, 46, 9, 123, 1),
(195, 46, 5, 123, 1),
(196, 46, 9, 124, 1),
(197, 46, 6, 124, 1),
(198, 46, 9, 125, 1),
(199, 46, 7, 125, 1),
(200, 47, 1, 126, 1);

INSERT INTO `cc_review` (`id`, `commentary`, `mark`, `status`, `Products_id`, `User_id`, `createdAt`) VALUES
(2, 'Salut', 1, 1, 47, 1, '2021-07-27 20:15:10');

INSERT INTO `cc_tab_navbar` (`id`, `name`, `page`, `category`, `navbar`) VALUES
(4, 'Chapeau', NULL, 1, 5),
(5, 'Outils', NULL, 6, 5),
(6, 'Sports', NULL, 8, 5),
(7, 'Pantalon', NULL, 3, 5);