-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/04/2026 às 14:08
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
-- Estrutura para tabela `geo_time`
--

CREATE TABLE `geo_time` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `tipo` enum('era','periodo','epoca','idade') DEFAULT NULL,
  `begin_year` decimal(8,2) DEFAULT NULL,
  `end_year` decimal(8,2) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `legenda` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `species`
--

CREATE TABLE `species` (
  `id` int(11) NOT NULL,
  `taxon_id` int(11) DEFAULT NULL,
  `cientific_name` varchar(150) DEFAULT NULL,
  `nome` varchar(150) DEFAULT NULL,
  `autor` varchar(150) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `diet` enum('carnivore','herbivore','omnivorous') DEFAULT NULL,
  `comprimento` decimal(6,2) DEFAULT NULL,
  `peso` int(11) DEFAULT NULL,
  `discovery_year` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `geotime_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `species_images`
--

CREATE TABLE `species_images` (
  `species_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tax`
--

CREATE TABLE `tax` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `rank` enum('reino','filo','classe','ordem','familia','genero') DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tax`
--

INSERT INTO `tax` (`id`, `nome`, `slug`, `rank`, `parent_id`, `descricao`) VALUES
(1, 'Tyranosaurus', 'tyranosaurus', 'genero', NULL, 'Tyrannosaurus (em português Tiranossauro é um gênero de grandes dinossauros terópodes. A espécie-tipo do gênero é Tyrannosaurus rex, que ganhou o epíteto específico de rex, por ser o maior dinossauro carnívoro conhecido quando foi descoberto. Viveu na região onde hoje é a América do Norte, no antigo continente insular de Laramidia. Seus fósseis são encontrados em uma variedade de formações geológicas datando das últimas idades do Campaniano ao Maastrichtiano do período Cretáceo Superior, entre 73,2 a 66 milhões de anos atrás. Foi o último representante conhecido do grupo dos tiranossaurídeos e um dos últimos dinossauros não-avianos a existirem antes do evento de extinção Cretáceo-Paleogeno.');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `geo_time`
--
ALTER TABLE `geo_time`
  ADD PRIMARY KEY (`id`),
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
  ADD UNIQUE KEY `cientific_name` (`cientific_name`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `species`
--
ALTER TABLE `species`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tax`
--
ALTER TABLE `tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `geo_time`
--
ALTER TABLE `geo_time`
  ADD CONSTRAINT `geo_time_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `geo_time` (`id`);

--
-- Restrições para tabelas `species`
--
ALTER TABLE `species`
  ADD CONSTRAINT `species_ibfk_1` FOREIGN KEY (`taxon_id`) REFERENCES `tax` (`id`),
  ADD CONSTRAINT `species_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  ADD CONSTRAINT `species_ibfk_3` FOREIGN KEY (`geotime_id`) REFERENCES `geo_time` (`id`);

--
-- Restrições para tabelas `species_images`
--
ALTER TABLE `species_images`
  ADD CONSTRAINT `species_images_ibfk_1` FOREIGN KEY (`species_id`) REFERENCES `species` (`id`),
  ADD CONSTRAINT `species_images_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`);

--
-- Restrições para tabelas `tax`
--
ALTER TABLE `tax`
  ADD CONSTRAINT `tax_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `tax` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
