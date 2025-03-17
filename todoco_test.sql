-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 17 mars 2025 à 14:48
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `todoco_test`
--

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_done` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_527EDB25A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=886 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id`, `user_id`, `title`, `content`, `created_at`, `updated_at`, `is_done`) VALUES
(1, 1, 'assumenda', 'Aspernatur cupiditate vel aliquid qui quasi rerum.', '2024-11-23 15:52:40', '2024-11-23 15:52:40', 1),
(2, NULL, 'rerum', 'Eaque sit quam sunt non.', '2024-11-23 15:52:40', '2024-11-23 15:52:40', 0),
(3, NULL, 'ipsa', 'Est quas qui perferendis omnis dolor quia doloremque.', '2024-11-23 15:52:40', '2024-11-23 15:52:40', 1),
(4, NULL, 'consequatur', 'Aperiam est aut mollitia.', '2024-11-23 15:52:40', '2024-11-23 15:52:40', 1),
(5, NULL, 'minima', 'Cum temporibus id aut aspernatur tenetur.', '2024-11-23 15:52:40', '2024-11-23 15:52:40', 1),
(6, NULL, 'voluptas', 'Veniam autem in repudiandae sit.', '2024-11-23 15:52:40', '2024-11-23 15:52:40', 1),
(7, NULL, 'ut', 'Et ab ea perspiciatis numquam.', '2024-11-23 15:52:40', '2024-11-23 15:52:40', 0),
(8, NULL, 'ut', 'Molestiae ipsa dolores et quis nihil.', '2024-11-23 15:52:40', '2024-11-23 15:52:40', 0),
(9, NULL, 'nemo', 'Ullam commodi repellendus nemo maxime et enim possimus.', '2024-11-23 15:52:40', '2024-11-23 15:52:40', 0),
(10, NULL, 'cumque', 'Labore cumque veniam eaque id dolorem.', '2024-11-23 15:52:40', '2024-11-23 15:52:40', 0),
(11, NULL, 'sed', 'Et quo vel deserunt deleniti aliquam.', '2024-11-23 15:52:40', '2024-11-23 15:52:40', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=829 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `roles`, `password`) VALUES
(1, 'Audrey Dijoux', 'cclerc@yahoo.fr', '[\"ROLE_ADMIN\"]', '$2y$04$5TXFZjPfY1ZhgHo5743G9ecKWopMq.2DkaGZH6eLHrLh7OfL.N8gi'),
(2, 'Martine Gregoire', 'lroger@wanadoo.fr', '[\"ROLE_USER\"]', '$2y$04$xVPBaTZCFEIwKxNhE7KsYuBAgKSW1IRq3TKo8NYvnxFZpNhG.9SFa'),
(3, 'Adrien du Boucher', 'danielle.arnaud@dumont.com', '[\"ROLE_USER\"]', '$2y$04$DMO.D/PtyGy5Yvf.UAqF4O7nvsRd6FEvRNSq7GvoblHVxyc5wkvem'),
(4, 'Laure Bonneau-Boutin', 'valerie.nguyen@hotmail.fr', '[\"ROLE_USER\"]', '$2y$04$D9lGyv9Vd93Gp.t47u/R3OLJdH/FCAOm6cd.Ole9YKpLnTWRP4Tou'),
(5, 'Lucie Moreau', 'mary.anne@sfr.fr', '[\"ROLE_USER\"]', '$2y$04$sApfZahw1mDMYYd7IHexI.8EAodA7ebTXxMb7vEFVkqb7yQyt/b/2'),
(6, 'Bertrand Marion', 'pierre.loiseau@pineau.org', '[\"ROLE_USER\"]', '$2y$04$lItwsaSUAYpwu3Xi7kq5AeVM8njHNOU5jCuto0oz7AWztJOGhVcZu'),
(7, 'Émile Letellier', 'zjoubert@pires.net', '[\"ROLE_USER\"]', '$2y$04$WRUwFB.mONVt7oWSx0rdIeTHFMq7rfrAj22/OZx.dblOpeYVN1iG6'),
(8, 'Tristan Aubert', 'vetienne@boulanger.fr', '[\"ROLE_USER\"]', '$2y$04$YDhlaUxx/C3Jaw3aNYlNguTYp5sn6SeH40sXdak1oXrjB/aqqoEFi'),
(9, 'Marianne Giraud', 'guyot.sylvie@live.com', '[\"ROLE_USER\"]', '$2y$04$R3SaQl.0Ag7n4L3Ym4URdOXggHkrN.2dMi2XiBKJTMyqTCCo9Zbd2');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `fk_task_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
