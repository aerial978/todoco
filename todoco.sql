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
-- Base de données : `todoco`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20231111144753', '2023-11-11 14:52:32', 43),
('DoctrineMigrations\\Version20231111191824', '2023-11-11 19:19:03', 32),
('DoctrineMigrations\\Version20231112181138', '2023-11-12 18:11:49', 75),
('DoctrineMigrations\\Version20231112192304', '2023-11-12 19:23:09', 79),
('DoctrineMigrations\\Version20231113174446', '2023-11-13 17:44:58', 205),
('DoctrineMigrations\\Version20231213084033', '2023-12-13 08:40:44', 98);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_done` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_527EDB25A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id`, `user_id`, `title`, `content`, `is_done`, `created_at`, `updated_at`) VALUES
(29, NULL, 'et', 'Dolores dolor quae sed neque molestias voluptates.', 0, '2023-12-13 08:48:01', '2025-03-12 15:31:16'),
(30, NULL, 'similiqua', 'Fugit minima quasi mollitia non.', 1, '2023-12-13 08:48:01', '2024-10-10 15:13:17'),
(31, NULL, 'rerum', 'Vel nihil deserunt dolores consectetur dolor in aut est.', 1, '2023-12-13 08:48:01', '2024-10-01 14:29:18'),
(33, NULL, 'consequuntur', 'Ut provident doloremque occaecati accusantium.', 1, '2023-12-13 08:48:01', '2024-10-06 14:24:43'),
(34, NULL, 'voluptate', 'Non blanditiis sed sit eos tempore et vitae non.', 0, '2023-12-13 08:48:01', '2023-12-13 08:48:01'),
(35, NULL, 'animi', 'Enim esse accusamus molestiae impedit autem.', 0, '2023-12-13 08:48:01', '2023-12-13 09:16:47'),
(36, NULL, 'adipisci', 'Fuga atque accusantium ut illum.', 0, '2023-12-13 08:48:01', '2023-12-13 08:48:01'),
(39, 5, 'Bonjour', 'Salut tout le monde', 0, '2024-11-03 14:18:37', '2025-03-11 14:42:06');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `roles`, `password`) VALUES
(5, 'john45*AC', 'jojo@yahoo.fr', '[\"ROLE_USER\"]', '$2y$13$D15yHyrD0BINJN914v7gCeTjBNfUqOSX7AViErPNcZWK8RAAjnOTW'),
(8, 'bouboul3W?', 'bouboul@gmail.com', '[\"ROLE_USER\"]', '$2y$13$Mv2ilTb5.X2myB9vyofXYe.mY9VUQ/38NfJAOVrn3L/7qyJiWQCDu'),
(9, 'biloute9g@K', 'tania@orange.fr', '[\"ROLE_USER\"]', '$2y$13$cyKMXExOjsLaN8f0UCqK7OoLiprqY8bW3kPP0LvhRy2WaM8TxzixO'),
(12, 'minetG!w2', 'minet@free.com', '[\"ROLE_USER\"]', '$2y$13$P1sJ9OS4twMkr..71kSNwO.L8muf2jKKpkWVQCrqrhIsYLCXZeuoW'),
(13, 'bruno0W$*', 'grizzly@hotmail.fr', '[\"ROLE_ADMIN\"]', '$2y$13$xcwdzqyZMjn/xJChS.KXVOlM6/fFwE/iDXXtHiqQ2xbEFV.8K6D6q'),
(14, 'orangeK1!', 'papa@hotmail.fr', '[\"ROLE_USER\"]', '$2y$13$3SJ8lmg5D.4B.t1379LQQuauq0nyqCQxznqHWRi6Sjk.3y8ZmD0h.'),
(19, 'core8*NP', 'dudul@gmail.com', '[\"ROLE_USER\"]', '$2y$13$Kw9FrL9kPB3B9ts/8e7ibucV/QqQu/Gtysxcawd.h9TrBEhXUL6KO');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `FK_527EDB25A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
