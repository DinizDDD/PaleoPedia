-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30/10/2026 às 19:02
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
(2, 'cretaceo-superior', 'Cretáceo Superior', 'epoca', 100.50, 66.00, 1),
(3, 'permiano', 'Permiano', 'periodo', 298.90, 251.90, NULL),
(4, 'pleistoceno', 'Pleistoceno', 'epoca', 2.58, 0.01, 5),
(5, 'quaternario', 'Quaternário', 'periodo', 2.58, 0.00, NULL),
(6, 'cretaceo-inferior', 'Cretáceo Inferior', 'epoca', 145.00, 100.50, 1),
(7, 'maastrichtiano', 'Maastrichtiano', 'idade', 72.20, 66.00, 2),
(8, 'campaniano', 'Campaniano', 'idade', 83.60, 72.20, 2),
(9, 'santoniano', 'Santoniano', 'idade', 85.70, 83.60, 2),
(10, 'coniaciano', 'Coniaciano', 'idade', 89.80, 85.70, 2),
(11, 'turoniano', 'Turoniano', 'idade', 93.90, 89.80, 2),
(12, 'cenomaniano', 'Cenomaniano', 'idade', 100.50, 93.90, 2),
(13, 'albiano', 'Albiano', 'idade', 113.20, 100.50, 6),
(14, 'aptiano', 'Aptiano', 'idade', 121.40, 113.20, 6),
(15, 'barremiano', 'Barremiano', 'idade', 125.77, 121.40, 6),
(16, 'hauteriviano', 'Hauteriviano', 'idade', 132.60, 125.77, 6),
(17, 'valanginiano', 'Valanginiano', 'idade', 137.05, 132.60, 6),
(18, 'berriasiano', 'Berriasiano', 'idade', 143.10, 137.05, 6),
(19, 'cisuraliano', 'Cisuraliano', 'epoca', 298.90, 273.01, 3),
(20, 'guadalupiano', 'Guadalupiano', 'epoca', 273.01, 259.51, 3),
(21, 'lopingiano', 'Lopingiano', 'epoca', 259.51, 251.90, 3);

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
(1, 'assets/images/species/trex/principal.png', 'Reconstrução do Tyrannosaurus rex'),
(4, 'assets/images/species/triceratops/principal.png', 'Reconstrução do Tricerátops'),
(7, 'assets/images/species/velociraptor/principal.png', 'Reconstrução do Velociraptor'),
(10, 'assets/images/species/ankylosaurus/principal.png', 'Reconstrução do Ankylosaurus'),
(13, 'assets/images/species/mamute/principal.png', 'Reconstrução do Mammuthus'),
(15, 'assets/images/species/diplocaulus/card.png', 'Reconstrução do Diplocaulus para o card de espécies'),
(37, 'assets/images/species/diplocaulus/principal.png', 'Reconstrução do Diplocaulus - imagem principal');

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
  `diet` enum('carnívoro','herbívoro','onívoro','piscívoro','insetívoro') DEFAULT NULL,
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
(1, 6, 'Tyrannosaurus rex', 'Tiranossauro Rex', 'tyrannosaurus-rex', 'O Tyrannosaurus rex foi um dos maiores predadores terrestres da história. Viveu no final do período Cretáceo e possuía mandíbula extremamente poderosa, dentes serrilhados e sentidos muito desenvolvidos.', 'carnívoro', 12.30, 4.00, 9000, 'Provavelmente era um predador ativo, mas também poderia se alimentar de carcaças.', 'Habitava ambientes florestais e planícies alagadas próximas a rios.', 'Seu nome significa \"rei dos lagartos tiranos\". É um dos dinossauros mais famosos do mundo.', 1902, 'Montana, Estados Unidos', 'Hell Creek Formation', 'Barnum Brown', 'Florestas subtropicais e planícies úmidas', 'América do Norte', 'Florestal', 'Subtropical', 'América do Norte', 1, 7),
(2, 12, 'Triceratops horridus', 'Tricerátops', 'triceratops', 'O Tricerátops foi um dos maiores dinossauros herbívoros do final do Cretáceo. Possuía três chifres e uma grande gola óssea que provavelmente servia para defesa, exibição visual e reconhecimento entre indivíduos da mesma espécie.', 'herbívoro', 9.00, 3.00, 12000, 'Possivelmente vivia em grupos e utilizava seus chifres para defesa contra predadores e disputas entre membros da espécie.', 'Alimentava-se de vegetação rasteira, arbustos e samambaias em ambientes de planícies aluviais.', 'É um dos dinossauros mais conhecidos e frequentemente encontrado nos mesmos depósitos fossilíferos do Tyrannosaurus rex.', 1887, 'Colorado, Estados Unidos', 'Lance Formation', 'Othniel Charles Marsh', 'Planícies abertas e florestas subtropicais', 'América do Norte Ocidental', 'Florestal e Campestre', 'Subtropical', 'América do Norte', 4, 7),
(3, 14, 'Velociraptor mongoliensis', 'Velociraptor', 'velociraptor', 'O Velociraptor foi um pequeno dinossauro carnívoro coberto por penas que viveu durante o final do Cretáceo. Apesar de sua fama nos filmes, era muito menor do que geralmente é retratado.', 'carnívoro', 2.00, 0.70, 15, 'Provavelmente caçava pequenos vertebrados utilizando sua velocidade, inteligência e a grande garra curva presente nos pés.', 'Habitava ambientes áridos e semiáridos compostos por dunas e planícies secas.', 'Fósseis encontrados mostram evidências diretas de combate entre Velociraptor e Protoceratops.', 1923, 'Deserto de Gobi, Mongólia', 'Djadochta Formation', 'Peter Kaisen', 'Desertos e regiões semiáridas', 'Ásia Central', 'Desértico', 'Árido', 'Ásia', 7, 2),
(4, 17, 'Ankylosaurus magniventris', 'Anquilossauro', 'ankylosaurus', 'O Ankylosaurus foi um grande dinossauro herbívoro blindado que viveu durante o final do período Cretáceo. Seu corpo era protegido por placas ósseas e possuía uma poderosa clava na ponta da cauda.', 'herbívoro', 8.00, 1.70, 6000, 'Possivelmente vivia de forma solitária ou em pequenos grupos, utilizando sua armadura para se defender de grandes predadores.', 'Alimentava-se de vegetação rasteira encontrada em áreas florestadas e planícies úmidas.', 'Sua clava caudal poderia gerar impactos extremamente fortes contra predadores.', 1906, 'Montana, Estados Unidos', 'Hell Creek Formation', 'Barnum Brown', 'Planícies úmidas e florestas', 'América do Norte Ocidental', 'Florestal', 'Subtropical', 'América do Norte', 10, 7),
(5, 21, 'Mammuthus primigenius', 'Mamute-lanoso', 'mammuthus-primigenius', 'O mamute-lanoso foi um grande mamífero herbívoro que viveu durante o Pleistoceno. Possuía uma espessa camada de pelos, grandes presas curvas e adaptações para sobreviver em ambientes extremamente frios.', 'herbívoro', 3.40, 3.40, 6000, 'Vivia em grupos sociais, semelhantes aos dos elefantes atuais, provavelmente liderados por fêmeas adultas. Os machos adultos tendiam a viver de maneira mais solitária.', 'Alimentava-se principalmente de gramíneas, ervas e outras plantas encontradas nas estepes frias do norte da Eurásia e da América do Norte.', 'Alguns exemplares foram preservados no permafrost da Sibéria com pelos, pele e outros tecidos moles. Suas grandes presas eram utilizadas para alimentação, defesa e movimentação de neve.', 0, 'Sibéria, Rússia', 'Depósitos do Pleistoceno', 'Pesquisadores e habitantes locais da Sibéria', 'Estepes frias e tundras', 'Europa, Ásia e América do Norte', 'Estepe-tundra', 'Frio e glacial', 'Europa, Ásia e América do Norte', 13, 4),
(10, 25, 'Diplocaulus magnicornis', 'Diplocaulus', 'diplocaulus', 'O Diplocaulus foi um anfíbio pré-histórico que viveu durante o período Permiano. Ficou conhecido por seu crânio extremamente largo e achatado, com prolongamentos laterais que formavam uma estrutura semelhante a um bumerangue. Possuía corpo alongado, cauda achatada e adaptações que indicam um estilo de vida predominantemente aquático.', 'carnívoro', 1.00, NULL, NULL, 'Provavelmente era um animal predominantemente aquático que se movimentava em rios e lagoas. Possivelmente permanecia próximo ao fundo dos ambientes aquáticos, capturando pequenos animais. Seu crânio peculiar também pode ter contribuído para sua proteção contra predadores.', 'Habitava ambientes de água doce, como rios, lagoas e áreas alagadas. Alimentava-se de pequenos animais aquáticos, incluindo peixes e outros organismos. Fazia parte dos ecossistemas continentais do Permiano, compartilhando seu ambiente com outros anfíbios e vertebrados primitivos.', 'Sua característica mais marcante era o crânio em formato de bumerangue, com duas grandes projeções laterais. Essa estrutura pode ter auxiliado na proteção contra predadores e na movimentação dentro da água. Seu nome científico faz referência à aparência peculiar de sua estrutura craniana.', 1882, 'Baylor County, Texas, Estados Unidos', 'Arroyo Formation', 'Edward Drinker Cope', 'Rios, lagoas e ambientes de água doce', 'América do Norte', 'Aquático de água doce', 'Quente e sazonal, com períodos secos', 'América do Norte', 37, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `species_images`
--

CREATE TABLE `species_images` (
  `species_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `purpose` enum('principal','spotlight','card','behavior','ecology','curiosities','discovery') NOT NULL DEFAULT 'principal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `species_images`
--

INSERT INTO `species_images` (`species_id`, `image_id`, `purpose`) VALUES
(1, 1, 'principal'),
(2, 4, 'principal'),
(3, 7, 'principal'),
(4, 10, 'principal'),
(5, 13, 'principal'),
(10, 15, 'card'),
(10, 37, 'principal');

-- --------------------------------------------------------

--
-- Estrutura para tabela `species_relations`
--

CREATE TABLE `species_relations` (
  `species_id` int(11) NOT NULL,
  `related_species_id` int(11) NOT NULL,
  `relation_type` enum('coexistiu') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `species_relations`
--

INSERT INTO `species_relations` (`species_id`, `related_species_id`, `relation_type`) VALUES
(1, 2, 'coexistiu'),
(2, 1, 'coexistiu');

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
(5, 'Tyrannosauridae', 'tyrannosauridae', 'familia', 8, 'Família dos grandes dinossauros carnívoros'),
(6, 'Tyrannosaurus', 'tyrannosaurus', 'genero', 5, 'Gênero do Tyrannosaurus rex'),
(7, 'Dinosauria', 'dinosauria', 'ordem', 3, 'Clado que reúne todos os dinossauros'),
(8, 'Theropoda', 'theropoda', 'familia', 7, 'Grupo de dinossauros bípedes predominantemente carnívoros'),
(9, 'Ornithischia', 'ornithischia', 'ordem', 7, 'Dinossauros com quadril semelhante ao das aves'),
(10, 'Ceratopsia', 'ceratopsia', 'familia', 9, 'Grupo de dinossauros herbívoros com bicos e chifres'),
(11, 'Ceratopsidae', 'ceratopsidae', 'familia', 10, 'Família dos grandes dinossauros ceratopsianos'),
(12, 'Triceratops', 'triceratops', 'genero', 11, 'Gênero dos Tricerátops'),
(13, 'Dromaeosauridae', 'dromaeosauridae', 'familia', 8, 'Família dos dinossauros dromeossaurídeos, conhecidos por sua agilidade e garras especializadas'),
(14, 'Velociraptor', 'velociraptor', 'genero', 13, 'Gênero dos Velociraptores'),
(15, 'Ankylosauria', 'ankylosauria', 'familia', 9, 'Grupo de dinossauros blindados'),
(16, 'Ankylosauridae', 'ankylosauridae', 'familia', 15, 'Família dos anquilossaurídeos'),
(17, 'Ankylosaurus', 'ankylosaurus', 'genero', 16, 'Gênero do Ankylosaurus'),
(18, 'Mammalia', 'mammalia', 'classe', 2, 'Classe dos mamíferos'),
(19, 'Proboscidea', 'proboscidea', 'ordem', 18, 'Ordem que inclui elefantes modernos e seus parentes extintos'),
(20, 'Elephantidae', 'elephantidae', 'familia', 19, 'Família que inclui os elefantes e mamutes'),
(21, 'Mammuthus', 'mammuthus', 'genero', 20, 'Gênero que reúne diversas espécies de mamutes'),
(22, 'Amphibia', 'amphibia', 'classe', 2, 'Classe dos anfíbios'),
(23, 'Lepospondyli', 'lepospondyli', 'ordem', 22, 'Grupo de anfíbios paleozoicos'),
(24, 'Diplocaulidae', 'diplocaulidae', 'familia', 23, 'Família de anfíbios lepospôndilos caracterizados por crânios alongados'),
(25, 'Diplocaulus', 'diplocaulus', 'genero', 24, 'Gênero de anfíbios extintos do Permiano');

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
  ADD PRIMARY KEY (`species_id`,`purpose`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `species`
--
ALTER TABLE `species`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tax`
--
ALTER TABLE `tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
