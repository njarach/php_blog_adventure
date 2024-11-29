-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 29 nov. 2024 à 11:26
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `php_blog_adventure`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'php'),
(2, 'symfony'),
(3, 'javascript'),
(4, 'technos'),
(5, 'autres');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reviewed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `intro` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `intro`, `author_id`, `category_id`, `created_at`, `updated_at`) VALUES
(37, 'Mon premier article PHP', '\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec viverra, eros et ultrices dignissim, enim tortor scelerisque purus, vitae sagittis magna odio ac tortor. Etiam ac dapibus nulla. In at consequat nisl. Nulla lobortis lacus eu posuere laoreet. Vivamus placerat mauris ac lacinia eleifend. Nulla facilisi. Nam quis nisi sit amet purus convallis luctus ac eu elit. Ut eu laoreet libero.\r\n\r\nNullam fermentum at lorem eget scelerisque. Duis pulvinar ante gravida, eleifend urna ac, lacinia est. Donec sed laoreet velit. In molestie nibh vitae convallis fringilla. Ut rhoncus turpis ac convallis laoreet. Maecenas facilisis est quis lorem fringilla tempus. Morbi id eleifend nibh. Nam facilisis, magna sit amet commodo laoreet, elit augue hendrerit dui, porta dapibus sapien odio vitae leo. Integer dictum maximus nisl, id pharetra mi fermentum eget. Etiam finibus, tellus eu venenatis imperdiet, orci felis mattis turpis, tincidunt dignissim neque ligula quis arcu. Sed id mollis est.\r\n\r\nProin tellus turpis, luctus non leo sed, lobortis imperdiet purus. Nulla sed congue lacus. Etiam non sem neque. Vestibulum a finibus nibh, eu egestas metus. Vestibulum congue ante nec quam congue, quis maximus massa finibus. Pellentesque dictum vel dolor nec rhoncus. Sed nisi nibh, viverra non enim nec, posuere feugiat velit. Pellentesque eleifend nisi a mauris blandit, eu dapibus nisl posuere.\r\n\r\nIn elementum pretium arcu, at posuere massa. Pellentesque scelerisque malesuada nisi ut sodales. Donec in metus quis orci tempor dapibus ut at nisi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed eu ultrices elit. Nam aliquam diam dapibus finibus egestas. Vestibulum rutrum, justo nec dictum consectetur, risus ante molestie metus, vel laoreet tortor tortor non leo. Aenean dictum vitae mi quis porttitor. Pellentesque mattis nibh non erat congue laoreet. Phasellus eget mattis lorem. Donec rhoncus eget dolor mollis dignissim.\r\n\r\nQuisque hendrerit dui nec ante aliquam dapibus. Morbi eget pretium libero. Integer sit amet nisi non turpis placerat efficitur in eu orci. Ut nisl diam, lacinia a placerat eget, pulvinar ut leo. Nam pretium interdum urna eget pellentesque. Sed vitae ornare ipsum, ac venenatis dolor. Ut sit amet massa congue, pellentesque eros vitae, hendrerit nulla. Nam et finibus velit. Quisque ac massa sed sem dictum condimentum. Duis commodo, libero nec fermentum cursus, lorem leo placerat tortor, vel convallis augue mauris vitae purus. Nulla volutpat a est a consectetur. Sed scelerisque risus nec ipsum egestas, a posuere odio cursus. Curabitur porta dui in pretium varius. ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec viverra, eros et ultrices dignissim, enim tortor scelerisque purus, vitae sagittis magna odio ac tortor. Etiam ac dapibus nulla. In at consequat nisl. Nulla lobortis lacus eu posuere laoreet. ', 8, 1, '2024-11-29 10:25:57', '2024-11-29 10:25:57');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `isAdmin`, `password`, `created_at`) VALUES
(8, 'admin', 'admin@mail.com', 1, '$2y$10$WxBJ1fr..qMrvwjnDCxwWe9LxDEMHjtt7BxovpZlPm32byT9Fc9Qq', '2024-11-29 10:22:17');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comment_ibfk_1` (`post_id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
