-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/05/2026 às 16:38
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `paleo_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `geotime_images`
--

CREATE TABLE `geotime_images` (
  `geotime_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `geo_time`
--

CREATE TABLE `geo_time` (
  `id` int(11) NOT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `type` enum('era','periodo','epoca','idade') DEFAULT NULL,
  `begin_year` decimal(8,2) DEFAULT NULL,
  `end_year` decimal(8,2) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `geo_time`
--

INSERT INTO `geo_time` (`id`, `slug`, `name`, `type`, `begin_year`, `end_year`, `parent_id`) VALUES
(1, 'cretaceo', 'Cretáceo', 'periodo', 145.00, 66.00, NULL),
(2, 'cretaceo-superior', 'Cretáceo Superior', 'epoca', 100.50, 66.00, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `_path` varchar(255) DEFAULT NULL,
  `legenda` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `images`
--

INSERT INTO `images` (`id`, `_path`, `legenda`) VALUES
(1, 'assets/images/species/trex-main.png', 'Reconstrução artística do Tyrannosaurus rex'),
(2, 'assets/images/species/trex-skeleton.png', 'Esqueleto fossilizado de Tyrannosaurus rex'),
(3, 'assets/images/species/trex-size.png', 'Comparação de tamanho entre um Tyrannosaurus rex e um humano');

-- --------------------------------------------------------

--
-- Estrutura para tabela `species`
--

CREATE TABLE `species` (
  `id` int(11) NOT NULL,
  `taxon_id` int(11) DEFAULT NULL,
  `scientific_name` varchar(150) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `diet` enum('carnivoro','herbivoro','onivoro','piscivoro','insetivoro') DEFAULT NULL,
  `length` decimal(6,2) DEFAULT NULL,
  `height` decimal(6,2) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `behavior` text DEFAULT NULL,
  `ecology` text DEFAULT NULL,
  `curiosities` text DEFAULT NULL,
  `discovery_year` int(11) DEFAULT NULL,
  `discovery_local` varchar(150) DEFAULT NULL,
  `formation` varchar(150) DEFAULT NULL,
  `discovered_by` varchar(150) DEFAULT NULL,
  `habitat` varchar(150) DEFAULT NULL,
  `region` varchar(150) DEFAULT NULL,
  `biome` varchar(150) DEFAULT NULL,
  `climate` varchar(150) DEFAULT NULL,
  `continent` varchar(150) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `geotime_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `species`
--

INSERT INTO `species` (`id`, `taxon_id`, `scientific_name`, `name`, `slug`, `summary`, `diet`, `length`, `height`, `weight`, `behavior`, `ecology`, `curiosities`, `discovery_year`, `discovery_local`, `formation`, `discovered_by`, `habitat`, `region`, `biome`, `climate`, `continent`, `image_id`, `geotime_id`) VALUES
(1, 6, 'Tyrannosaurus rex', 'Tiranossauro Rex', 'tyrannosaurus-rex', 'O Tyrannosaurus rex foi um dos maiores predadores terrestres da história. Viveu no final do período Cretáceo e possuía mandíbula extremamente poderosa, dentes serrilhados e sentidos muito desenvolvidos.', 'carnivoro', 12.30, 4.00, 9000, 'Provavelmente era um predador ativo, mas também poderia se alimentar de carcaças.', 'Habitava ambientes florestais e planícies alagadas próximas a rios.', 'Seu nome significa \"rei dos lagartos tiranos\". É um dos dinossauros mais famosos do mundo.', 1902, 'Montana, Estados Unidos', 'Hell Creek Formation', 'Barnum Brown', 'Florestas subtropicais e planícies úmidas', 'América do Norte', 'Florestal', 'Subtropical', 'América do Norte', 1, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `species_images`
--

CREATE TABLE `species_images` (
  `species_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `species_images`
--

INSERT INTO `species_images` (`species_id`, `image_id`) VALUES
(1, 1),
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `species_relations`
--

CREATE TABLE `species_relations` (
  `species_id` int(11) NOT NULL,
  `related_species_id` int(11) NOT NULL,
  `relation_type` enum('coexistiu') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tax`
--

CREATE TABLE `tax` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `rank` enum('reino','filo','classe','ordem','familia','genero') DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tax`
--

INSERT INTO `tax` (`id`, `name`, `slug`, `rank`, `parent_id`, `descricao`) VALUES
(1, 'Animalia', 'animalia', 'reino', NULL, 'Reino dos animais'),
(2, 'Chordata', 'chordata', 'filo', 1, 'Filo dos animais com corda dorsal'),
(3, 'Reptilia', 'reptilia', 'classe', 2, 'Classe dos répteis'),
(4, 'Saurischia', 'saurischia', 'ordem', 3, 'Ordem dos dinossauros de quadril semelhante ao de lagartos'),
(5, 'Tyrannosauridae', 'tyrannosauridae', 'familia', 4, 'Família dos grandes dinossauros carnívoros'),
(6, 'Tyrannosaurus', 'tyrannosaurus', 'genero', 5, 'Gênero do Tyrannosaurus rex');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `geotime_images`
--
ALTER TABLE `geotime_images`
  ADD PRIMARY KEY (`geotime_id`,`image_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Índices de tabela `geo_time`
--
ALTER TABLE `geo_time`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Índices de tabela `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `species`
--
ALTER TABLE `species`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `scientific_name` (`scientific_name`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `taxon_id` (`taxon_id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `geotime_id` (`geotime_id`);

--
-- Índices de tabela `species_images`
--
ALTER TABLE `species_images`
  ADD PRIMARY KEY (`species_id`,`image_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Índices de tabela `species_relations`
--
ALTER TABLE `species_relations`
  ADD PRIMARY KEY (`species_id`,`related_species_id`),
  ADD KEY `related_species_id` (`related_species_id`);

--
-- Índices de tabela `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `geo_time`
--
ALTER TABLE `geo_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `species`
--
ALTER TABLE `species`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tax`
--
ALTER TABLE `tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `geotime_images`
--
ALTER TABLE `geotime_images`
  ADD CONSTRAINT `geotime_images_ibfk_1` FOREIGN KEY (`geotime_id`) REFERENCES `geo_time` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `geotime_images_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `geo_time`
--
ALTER TABLE `geo_time`
  ADD CONSTRAINT `geo_time_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `geo_time` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `species`
--
ALTER TABLE `species`
  ADD CONSTRAINT `species_ibfk_1` FOREIGN KEY (`taxon_id`) REFERENCES `tax` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `species_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `species_ibfk_3` FOREIGN KEY (`geotime_id`) REFERENCES `geo_time` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `species_images`
--
ALTER TABLE `species_images`
  ADD CONSTRAINT `species_images_ibfk_1` FOREIGN KEY (`species_id`) REFERENCES `species` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `species_images_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `species_relations`
--
ALTER TABLE `species_relations`
  ADD CONSTRAINT `species_relations_ibfk_1` FOREIGN KEY (`species_id`) REFERENCES `species` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `species_relations_ibfk_2` FOREIGN KEY (`related_species_id`) REFERENCES `species` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tax`
--
ALTER TABLE `tax`
  ADD CONSTRAINT `tax_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `tax` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
