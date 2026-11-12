-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12/11/2026 às 18:15
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
  `image_id` int(11) NOT NULL,
  `purpose` enum('banner','environment') NOT NULL DEFAULT 'banner'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `geo_time`
--

CREATE TABLE `geo_time` (
  `id` int(11) NOT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `type` enum('eon','era','periodo','epoca','idade') DEFAULT NULL,
  `begin_year` decimal(10,4) DEFAULT NULL,
  `end_year` decimal(10,4) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `continental_configuration` text DEFAULT NULL,
  `climate` text DEFAULT NULL,
  `oceans` text DEFAULT NULL,
  `vegetation` text DEFAULT NULL,
  `environments` text DEFAULT NULL,
  `biodiversity` text DEFAULT NULL,
  `curiosities` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `geo_time`
--

INSERT INTO `geo_time` (`id`, `slug`, `name`, `type`, `begin_year`, `end_year`, `parent_id`, `summary`, `continental_configuration`, `climate`, `oceans`, `vegetation`, `environments`, `biodiversity`, `curiosities`) VALUES
(1, 'cretaceo', 'Cretáceo', 'periodo', 145.0000, 66.0000, 24, 'O Cretáceo foi o último período da Era Mesozoica, iniciado há aproximadamente 145 milhões de anos e encerrado há 66 milhões de anos. Foi marcado pela diversificação dos dinossauros, expansão das plantas com flores e fragmentação dos continentes. Terminou com uma extinção em massa que eliminou os dinossauros não avianos.', 'Os continentes continuavam se separando devido à movimentação das placas tectônicas. A América do Sul e a África se afastavam, enquanto o Oceano Atlântico se expandia. A Índia ainda era uma massa continental isolada, deslocando-se em direção ao norte.', 'O clima global era predominantemente quente, sem grandes calotas polares permanentes. Existiam regiões tropicais, subtropicais e temperadas, com variações de umidade entre os continentes.', 'O nível dos mares era elevado, provocando a formação de extensos mares rasos sobre áreas continentais. Os oceanos apresentavam grande diversidade de organismos, incluindo amonites, moluscos, peixes e répteis marinhos.', 'As coníferas, cicadáceas, samambaias e outras plantas sem flores eram comuns. As angiospermas, ou plantas com flores, surgiram e se diversificaram significativamente durante esse período.', 'Os ambientes terrestres incluíam florestas, planícies aluviais, regiões áridas e áreas pantanosas. Os ambientes aquáticos abrangiam rios, lagos, mares rasos e oceanos.', 'Os dinossauros dominaram muitos ecossistemas terrestres, incluindo grandes predadores, herbívoros e pequenos terópodes emplumados. Pterossauros ocupavam os céus, enquanto répteis marinhos, amonites, peixes, aves primitivas e mamíferos também diversificavam os ecossistemas.', 'O Cretáceo terminou há aproximadamente 66 milhões de anos, durante um dos maiores eventos de extinção da história da Terra. O impacto de um asteroide na região da atual Península de Yucatán, associado a intensas mudanças ambientais, contribuiu para o desaparecimento dos dinossauros não avianos. Apesar disso, aves, descendentes de dinossauros terópodes, sobreviveram.'),
(2, 'cretaceo-superior', 'Cretáceo Superior', 'epoca', 100.5000, 66.0000, 1, 'O Cretáceo Superior corresponde à última época do Cretáceo, entre aproximadamente 100,5 e 66 milhões de anos atrás. Foi marcado pela grande diversidade de dinossauros, expansão das plantas com flores e mudanças na configuração dos continentes e dos oceanos.', 'A fragmentação de Gondwana continuava, com a separação progressiva da América do Sul, África, Antártida, Austrália e Índia. A América do Norte apresentava uma extensa via marítima interior que dividia o continente em regiões ocidental e oriental.', 'O clima era predominantemente quente, embora apresentasse variações regionais e oscilações ao longo da época. As regiões polares eram mais amenas que atualmente e não possuíam grandes calotas de gelo permanentes.', 'Os mares apresentavam níveis elevados e extensas áreas continentais estavam inundadas. A vida marinha incluía amonites, rudistas, peixes ósseos, tubarões e grandes répteis marinhos, como mosassauros e plesiossauros.', 'As plantas com flores se diversificaram e passaram a ocupar diferentes ambientes. Coníferas, samambaias e cicadáceas continuavam presentes, formando florestas e outras comunidades vegetais.', 'Existiam florestas, planícies aluviais, pântanos, regiões costeiras e ambientes desérticos. Grandes rios e mares interiores criavam ecossistemas variados em diferentes continentes.', 'Tyrannosaurus rex, Triceratops, Ankylosaurus e diversos outros dinossauros viveram durante essa época. Aves primitivas, pequenos mamíferos, pterossauros, crocodilianos e uma grande variedade de animais marinhos também estavam presentes.', 'Durante o Cretáceo Superior, os dinossauros alcançaram grande diversidade. Tyrannosaurus rex, Triceratops e Ankylosaurus viveram nessa época. Também ocorreu a expansão e diversificação das plantas com flores, que passaram a desempenhar um papel cada vez mais importante nos ecossistemas terrestres.'),
(3, 'permiano', 'Permiano', 'periodo', 298.9000, 251.9000, 23, 'O Permiano foi o último período da Era Paleozoica, iniciado há aproximadamente 298,9 milhões de anos e encerrado há 251,9 milhões de anos. Foi caracterizado pela formação de Pangeia, expansão de ambientes continentais secos e diversificação dos sinapsídeos e répteis. Terminou com a maior extinção em massa conhecida.', 'Quase todas as grandes massas continentais estavam reunidas no supercontinente Pangeia, cercado pelo imenso oceano Panthalassa. O mar de Tétis ocupava uma região entre as porções setentrionais e meridionais do supercontinente.', 'O clima apresentava grandes contrastes regionais. O interior de Pangeia era predominantemente árido e sujeito a temperaturas extremas, enquanto regiões costeiras apresentavam maior umidade. As condições glaciais herdadas do Carbonífero diminuíram progressivamente.', 'O Panthalassa dominava a superfície oceânica, enquanto o mar de Tétis ocupava uma importante região tropical. Os oceanos abrigavam braquiópodes, moluscos, amonites, equinodermos, peixes e diversos organismos recifais.', 'As coníferas, ginkgófitas, cicadáceas primitivas e samambaias com sementes ganharam importância. Em regiões úmidas ainda existiam comunidades de plantas adaptadas a solos alagados.', 'Os ambientes incluíam desertos, planícies áridas, florestas sazonais, regiões costeiras e ambientes aquáticos continentais. Lagos e rios eram importantes em diferentes regiões de Pangeia.', 'Os ecossistemas terrestres apresentavam grande diversidade de sinapsídeos, como pelicossauros e terápsidos, além de répteis, anfíbios e insetos. Nos oceanos existiam peixes, moluscos, braquiópodes e outros invertebrados.', 'O Permiano terminou com a maior extinção em massa conhecida da história da Terra, há aproximadamente 252 milhões de anos. Esse evento provocou o desaparecimento de uma enorme quantidade de espécies marinhas e terrestres. Entre os animais que viveram nesse período estavam os terápsidos, grupo que inclui os ancestrais dos mamíferos.'),
(4, 'pleistoceno', 'Pleistoceno', 'epoca', 2.5800, 0.0117, 5, 'O Pleistoceno foi uma época do Quaternário iniciada há aproximadamente 2,58 milhões de anos e encerrada há cerca de 11.700 anos. Foi marcado por sucessivas glaciações, grandes oscilações climáticas e pela presença de uma megafauna diversificada. Também ocorreu a expansão de diferentes espécies humanas pelo planeta.', 'Os continentes já apresentavam posições próximas das atuais. Entretanto, durante as glaciações, grandes quantidades de água ficavam retidas nas geleiras, provocando a redução do nível dos mares e a exposição de pontes terrestres, como a região de Bering.', 'O clima alternava entre períodos glaciais frios e períodos interglaciais mais quentes. Grandes geleiras avançavam sobre partes da América do Norte, Europa e Ásia, enquanto regiões tropicais também apresentavam mudanças de temperatura e precipitação.', 'O nível dos oceanos oscilava significativamente conforme a quantidade de água armazenada nas geleiras. Durante os períodos glaciais, extensas áreas de plataformas continentais ficavam expostas, modificando os ambientes costeiros e a distribuição dos organismos marinhos.', 'A vegetação variava conforme as mudanças climáticas. Gramíneas e ervas dominavam muitas estepes frias, enquanto tundras, florestas de coníferas e florestas temperadas ocupavam diferentes regiões do planeta.', 'Os ambientes incluíam estepes, tundras, florestas, desertos e regiões cobertas por geleiras. Grandes planícies abertas eram comuns em várias regiões, oferecendo condições favoráveis para grandes herbívoros.', 'A megafauna incluía mamutes, mastodontes, rinocerontes-lanosos, preguiças-gigantes, tigres-dentes-de-sabre e outros grandes mamíferos. Também existiam aves, répteis, pequenos mamíferos e diferentes espécies humanas, incluindo Homo sapiens.', 'O Pleistoceno ficou conhecido pelas diversas glaciações, períodos em que grandes extensões dos continentes foram cobertas por geleiras. Também foi a época de muitos animais da chamada megafauna, como mamutes, tigres-dentes-de-sabre e preguiças-gigantes. A espécie humana também se espalhou por diferentes regiões do planeta.'),
(5, 'quaternario', 'Quaternário', 'periodo', 2.5800, 0.0000, 25, 'O Quaternário é o período geológico mais recente da Era Cenozoica, iniciado há aproximadamente 2,58 milhões de anos e que continua até os dias atuais. É caracterizado por importantes oscilações climáticas, expansão das espécies humanas e transformações nos ecossistemas terrestres e marinhos.', 'Os continentes apresentam configurações próximas das atuais, embora o nível dos oceanos tenha variado bastante ao longo do período. As placas tectônicas continuam se movimentando, modificando lentamente a superfície terrestre.', 'O clima foi marcado por ciclos de glaciações e períodos interglaciais durante o Pleistoceno, seguidos pelo clima relativamente estável do Holoceno. As atividades humanas passaram a exercer influência crescente sobre o clima e os ecossistemas.', 'Os oceanos sofreram oscilações no nível do mar relacionadas às mudanças no volume das geleiras. No Holoceno, o nível marinho tornou-se relativamente estável, permitindo a formação e transformação de diversas regiões costeiras.', 'A vegetação apresenta os principais grupos de plantas atuais, incluindo gramíneas, coníferas, angiospermas e diferentes formações florestais. Sua distribuição foi influenciada pelas mudanças climáticas e, mais recentemente, pelas atividades humanas.', 'Os ambientes incluem florestas tropicais e temperadas, savanas, pradarias, desertos, tundras, regiões polares, rios, lagos e oceanos. Muitos ecossistemas foram modificados pela expansão da agricultura, urbanização e outras atividades humanas.', 'O período apresenta grande diversidade de mamíferos, aves, répteis, anfíbios, peixes e invertebrados. A evolução e dispersão humana transformaram os ecossistemas, enquanto diversas espécies de megafauna foram extintas durante o Pleistoceno e o início do Holoceno.', 'O Quaternário é o período geológico atual. Ele inclui o Pleistoceno e o Holoceno, época em que vivemos. É marcado por importantes oscilações climáticas, pela expansão da humanidade e pelo desenvolvimento das sociedades humanas.'),
(6, 'cretaceo-inferior', 'Cretáceo Inferior', 'epoca', 145.0000, 100.5000, 1, 'O Cretáceo Inferior corresponde à primeira época do Cretáceo, iniciada há aproximadamente 145 milhões de anos e encerrada há 100,5 milhões de anos. Foi marcado pela fragmentação dos continentes, diversificação dos dinossauros e surgimento das primeiras plantas com flores conhecidas.', 'Gondwana e Laurásia continuavam em processo de fragmentação. A América do Sul e a África iniciavam sua separação, enquanto o Oceano Atlântico Sul começava a se desenvolver. Outras massas continentais também apresentavam movimentação progressiva.', 'O clima era geralmente quente, com variações regionais de umidade. Algumas regiões apresentavam condições áridas e semiáridas, enquanto outras possuíam ambientes úmidos e florestais.', 'Os oceanos estavam em expansão devido à separação dos continentes. Mares rasos ocupavam algumas regiões continentais, abrigando amonites, moluscos, peixes, répteis marinhos e diversos organismos planctônicos.', 'Coníferas, cicadáceas, samambaias e outras plantas sem flores eram predominantes. As primeiras angiospermas surgiram durante o Cretáceo Inferior e começaram sua diversificação.', 'Os ambientes terrestres incluíam florestas, planícies fluviais, lagos, pântanos e regiões áridas. Ambientes costeiros e marinhos rasos também estavam presentes em diferentes partes dos continentes.', 'Diversos grupos de dinossauros estavam presentes, incluindo saurópodes, terópodes e ornitópodes. Pterossauros, aves primitivas, pequenos mamíferos, anfíbios, répteis e organismos marinhos também apresentavam grande diversidade.', 'O Cretáceo Inferior foi marcado pela fragmentação gradual dos continentes e pela diversificação de diversos grupos de dinossauros. As primeiras plantas com flores conhecidas também surgiram durante esse intervalo, transformando progressivamente os ambientes terrestres.'),
(7, 'maastrichtiano', 'Maastrichtiano', 'idade', 72.2000, 66.0000, 2, 'O Maastrichtiano foi a última idade do Cretáceo, entre aproximadamente 72,2 e 66 milhões de anos atrás. Representa os últimos milhões de anos da Era dos Dinossauros não avianos e terminou com a extinção em massa do final do Cretáceo.', 'Os continentes estavam relativamente separados, com a América do Sul e a África em processo avançado de afastamento. A América do Norte apresentava uma extensa via marítima interior, enquanto a Índia continuava sua trajetória em direção à Ásia.', 'O clima era predominantemente quente, embora apresentasse mudanças de temperatura e umidade entre as regiões. Próximo ao final da idade, alterações ambientais ocorreram em associação ao evento de extinção em massa.', 'Os mares continuavam elevados em muitas regiões. A vida marinha incluía amonites, mosassauros, plesiossauros, peixes, tubarões e invertebrados. O impacto do asteroide no final do Maastrichtiano provocou alterações profundas nos ecossistemas oceânicos.', 'As angiospermas estavam amplamente diversificadas, formando parte importante da vegetação terrestre. Coníferas, samambaias e outras plantas também compunham as florestas e planícies.', 'Existiam planícies aluviais, florestas, pântanos, ambientes costeiros e regiões semiáridas. Na América do Norte, extensos sistemas fluviais e planícies úmidas sustentavam grandes comunidades de dinossauros.', 'Tyrannosaurus rex, Triceratops, Ankylosaurus e outros dinossauros viveram nesse intervalo. Também existiam aves, mamíferos, pterossauros, crocodilianos, tartarugas, amonites e répteis marinhos. A extinção do final do Maastrichtiano eliminou os dinossauros não avianos.', 'O Maastrichtiano foi a última idade do Cretáceo e terminou com a extinção em massa de aproximadamente 66 milhões de anos atrás. Tyrannosaurus rex, Triceratops e Ankylosaurus estão entre os dinossauros conhecidos desse intervalo.'),
(8, 'campaniano', 'Campaniano', 'idade', 83.6000, 72.2000, 2, 'O Campaniano ocorreu entre aproximadamente 83,6 e 72,2 milhões de anos atrás, durante o Cretáceo Superior. Foi um intervalo de grande diversidade de dinossauros e outros vertebrados, além de importantes transformações nos ambientes marinhos e terrestres.', 'Os continentes continuavam se afastando, com a expansão do Atlântico e a separação progressiva das massas continentais de Gondwana. A América do Norte ainda possuía uma extensa via marítima interior.', 'O clima era predominantemente quente, com diferenças regionais de precipitação. Muitas regiões apresentavam condições úmidas favoráveis ao desenvolvimento de florestas e planícies vegetadas.', 'Os mares apresentavam níveis relativamente elevados e abrigavam amonites, moluscos, peixes, tubarões e répteis marinhos. Depósitos de sedimentos marinhos desse intervalo são encontrados em diferentes continentes.', 'As plantas com flores estavam cada vez mais diversificadas. Coníferas, samambaias e cicadáceas continuavam presentes, compondo diferentes tipos de florestas e formações vegetais.', 'Os ambientes incluíam florestas subtropicais, planícies fluviais, pântanos, regiões costeiras e mares rasos. Grandes sistemas de rios favoreciam a presença de diversos herbívoros e predadores.', 'Dinossauros ceratopsianos, hadrossauros, anquilossauros e terópodes apresentavam grande diversidade. Aves primitivas, mamíferos, pterossauros, tartarugas, crocodilianos e répteis marinhos também habitavam os ecossistemas.', 'Durante o Campaniano, grandes dinossauros herbívoros e carnívoros habitavam diferentes regiões do planeta. Fósseis desse intervalo ajudam a compreender a diversidade dos ecossistemas que existiam pouco antes da extinção do final do Cretáceo.'),
(9, 'santoniano', 'Santoniano', 'idade', 85.7000, 83.6000, 2, 'O Santoniano ocorreu entre aproximadamente 85,7 e 83,6 milhões de anos atrás e corresponde a uma idade do Cretáceo Superior. Seus registros geológicos preservam evidências de ecossistemas terrestres e marinhos diversificados.', 'Gondwana continuava se fragmentando e o Oceano Atlântico se expandia. A América do Norte permanecia parcialmente dividida por uma via marítima interior, enquanto outras massas continentais seguiam em movimento.', 'O clima global era relativamente quente, com diferenças regionais de temperatura e precipitação. Regiões costeiras e tropicais apresentavam condições favoráveis à existência de ambientes úmidos e vegetados.', 'Os mares rasos ocupavam grandes áreas e apresentavam diversidade de amonites, moluscos, peixes, tubarões e répteis marinhos. Os depósitos marinhos são importantes para a identificação desse intervalo geológico.', 'Angiospermas continuavam se diversificando e ocupando diferentes ambientes. Coníferas, samambaias e cicadáceas também permaneciam comuns em diversas regiões.', 'Os ambientes terrestres incluíam florestas, planícies aluviais, pântanos e áreas costeiras. Os mares rasos e ambientes continentais de água doce também sustentavam comunidades diversificadas.', 'A fauna incluía diferentes dinossauros, crocodilianos, tartarugas, aves primitivas, mamíferos e pterossauros. Nos oceanos, amonites, peixes e grandes répteis marinhos estavam entre os principais representantes.', 'O Santoniano faz parte do Cretáceo Superior e foi um intervalo de diversificação de diferentes grupos de animais marinhos e terrestres. Seus registros fósseis ajudam a reconstruir os ambientes e a distribuição dos organismos naquele período.'),
(10, 'coniaciano', 'Coniaciano', 'idade', 89.8000, 85.7000, 2, 'O Coniaciano ocorreu entre aproximadamente 89,8 e 85,7 milhões de anos atrás, durante o Cretáceo Superior. Foi marcado pela continuidade da diversificação dos organismos marinhos e terrestres em um planeta com temperaturas relativamente elevadas.', 'A separação dos continentes continuava, acompanhada pela expansão do Oceano Atlântico. Grandes áreas da América do Norte permaneciam cobertas por mares interiores, enquanto Gondwana avançava em sua fragmentação.', 'As condições climáticas eram geralmente quentes, com variações regionais de umidade. Algumas regiões apresentavam florestas e planícies úmidas, enquanto outras possuíam condições mais secas.', 'Os mares apresentavam grande diversidade de organismos, incluindo amonites, peixes, tubarões e répteis marinhos. A expansão de ambientes marinhos rasos favorecia o desenvolvimento de diferentes comunidades aquáticas.', 'As angiospermas continuavam sua expansão e diversificação, convivendo com coníferas, samambaias e cicadáceas. A composição da vegetação variava conforme as condições climáticas e geográficas.', 'Existiam ambientes fluviais, planícies costeiras, florestas, pântanos e mares rasos. Os ambientes aquáticos continentais também eram importantes para diferentes grupos de vertebrados.', 'Os ecossistemas terrestres eram ocupados por dinossauros, crocodilianos, tartarugas, mamíferos e aves primitivas. Nos ambientes marinhos, amonites, peixes e répteis marinhos apresentavam grande diversidade.', 'O Coniaciano foi um intervalo em que os mares ainda ocupavam grandes áreas continentais em diversas regiões. Fósseis marinhos, como os de amonites e répteis marinhos, são importantes para reconhecer e estudar rochas dessa idade.'),
(11, 'turoniano', 'Turoniano', 'idade', 93.9000, 89.8000, 2, 'O Turoniano ocorreu entre aproximadamente 93,9 e 89,8 milhões de anos atrás. Foi uma idade do Cretáceo Superior caracterizada por temperaturas elevadas, altos níveis dos oceanos e grande diversidade de organismos marinhos.', 'Os continentes continuavam sua separação gradual. O Oceano Atlântico se expandia e extensos mares interiores cobriam regiões da América do Norte, enquanto a África e a América do Sul continuavam se afastando.', 'O Turoniano foi um intervalo de clima globalmente quente, associado ao período de efeito estufa do Cretáceo. Não existiam grandes calotas polares permanentes e as temperaturas oceânicas eram relativamente elevadas.', 'Os níveis dos mares eram muito elevados, formando extensos ambientes marinhos rasos. Amonites, peixes, tubarões, moluscos e grandes répteis marinhos, como mosassauros e plesiossauros, habitavam os oceanos.', 'As plantas com flores estavam em processo de diversificação, enquanto coníferas, samambaias e cicadáceas continuavam compondo a vegetação terrestre.', 'As paisagens incluíam florestas, planícies costeiras, rios, lagos e extensos mares rasos. Grandes áreas continentais apresentavam condições úmidas e ambientes favoráveis à diversidade de vertebrados.', 'Os ecossistemas terrestres abrigavam dinossauros, pterossauros, aves primitivas e pequenos mamíferos. Os ambientes marinhos apresentavam grande diversidade de peixes, amonites e répteis marinhos.', 'O Turoniano ocorreu em um momento de temperaturas globalmente elevadas e de expansão dos mares sobre áreas continentais. Os oceanos abrigavam uma grande diversidade de organismos, incluindo amonites, peixes e grandes répteis marinhos.'),
(12, 'cenomaniano', 'Cenomaniano', 'idade', 100.5000, 93.9000, 2, 'O Cenomaniano ocorreu entre aproximadamente 100,5 e 93,9 milhões de anos atrás e representa a primeira idade do Cretáceo Superior. Foi marcado por temperaturas elevadas, níveis marinhos muito altos e mudanças importantes nos ecossistemas terrestres e marinhos.', 'Gondwana continuava sua fragmentação e o Oceano Atlântico se expandia. A América do Norte e outras regiões continentais apresentavam grandes áreas inundadas por mares interiores.', 'O clima era predominantemente quente, com temperaturas elevadas nos oceanos e ausência de grandes calotas polares permanentes. O intervalo também apresenta evidências de importantes alterações na circulação oceânica e no ciclo do carbono.', 'O nível dos mares atingiu valores muito elevados, criando extensos mares rasos. Amonites, moluscos, peixes, tubarões e répteis marinhos eram abundantes. O Cenomaniano também inclui o início do evento anóxico Cenomaniano-Turoniano, marcado pela redução de oxigênio em importantes regiões oceânicas.', 'As angiospermas apresentavam diversificação crescente, enquanto coníferas, samambaias e cicadáceas continuavam comuns em diferentes regiões.', 'Os ambientes incluíam florestas, planícies fluviais, regiões costeiras, lagos e mares interiores. As áreas inundadas pelos oceanos criavam extensos ecossistemas marinhos rasos.', 'Dinossauros, pterossauros, aves primitivas e mamíferos ocupavam os ambientes terrestres. Nos oceanos, amonites, peixes ósseos, tubarões, tartarugas e répteis marinhos apresentavam grande diversidade.', 'O Cenomaniano foi marcado por níveis elevados do mar e pela existência de extensos ambientes marinhos rasos. Também corresponde ao início do Cretáceo Superior e apresenta importantes registros fósseis de organismos marinhos e terrestres.'),
(13, 'albiano', 'Albiano', 'idade', 113.2000, 100.5000, 6, 'O Albiano ocorreu entre aproximadamente 113,2 e 100,5 milhões de anos atrás, durante o Cretáceo Inferior. Foi um intervalo de expansão dos ambientes marinhos, mudanças na configuração continental e diversificação das plantas com flores.', 'Os continentes continuavam se separando, especialmente as massas continentais que formavam Gondwana. O Oceano Atlântico Sul começava a se expandir, enquanto a Índia ainda permanecia separada de outras massas continentais.', 'O clima era geralmente quente, com variações regionais de temperatura e precipitação. Algumas regiões apresentavam ambientes áridos e semiáridos, enquanto outras possuíam florestas e planícies úmidas.', 'Os mares estavam em expansão e apresentavam grande diversidade de amonites, moluscos, peixes e répteis marinhos. Os sedimentos oceânicos registram importantes mudanças na circulação e na oxigenação das águas.', 'As primeiras angiospermas já estavam presentes e se diversificavam progressivamente. Coníferas, samambaias e cicadáceas continuavam predominantes em muitas comunidades vegetais.', 'Existiam florestas, planícies fluviais, lagos, pântanos, regiões áridas e ambientes costeiros. Os mares rasos ocupavam áreas continentais em diferentes regiões.', 'Dinossauros saurópodes, terópodes e ornitópodes estavam presentes em diferentes continentes. Pterossauros, aves primitivas, mamíferos, anfíbios e organismos marinhos também compunham os ecossistemas.', 'O Albiano foi um intervalo de grande importância para a diversificação das plantas com flores. Nos ambientes marinhos, amonites e outros organismos deixaram fósseis que atualmente auxiliam na identificação e datação de rochas.'),
(14, 'aptiano', 'Aptiano', 'idade', 121.4000, 113.2000, 6, 'O Aptiano ocorreu entre aproximadamente 121,4 e 113,2 milhões de anos atrás e corresponde a uma idade do Cretáceo Inferior. Foi marcado por importantes mudanças ambientais, episódios de atividade vulcânica e alterações na oxigenação dos oceanos.', 'A fragmentação de Gondwana avançava e a separação entre a África e a América do Sul se tornava mais evidente. O Oceano Atlântico Sul continuava seu desenvolvimento, enquanto outras massas continentais também se afastavam.', 'O clima era geralmente quente, com episódios de alterações na temperatura e na umidade. Durante o Aptiano ocorreram importantes perturbações ambientais relacionadas a eventos de vulcanismo e mudanças no ciclo do carbono.', 'Os oceanos passaram por episódios de redução da oxigenação em determinadas regiões, incluindo o evento anóxico do Aptiano. Os mares abrigavam amonites, moluscos, peixes e diferentes répteis marinhos.', 'Coníferas, samambaias e cicadáceas compunham grande parte da vegetação. As angiospermas começaram a apresentar maior diversificação, ocupando progressivamente novos ambientes.', 'Os ambientes terrestres incluíam florestas, planícies aluviais, lagos e regiões semiáridas. Sistemas fluviais e áreas costeiras também eram importantes para a fauna da época.', 'Diversos dinossauros, incluindo grandes saurópodes e terópodes, habitavam os continentes. Pterossauros, aves primitivas, mamíferos, anfíbios e uma grande variedade de organismos marinhos também estavam presentes.', 'Durante o Aptiano, ocorreram importantes mudanças nos ecossistemas terrestres e marinhos. Alguns grupos de dinossauros apresentaram grande diversificação, enquanto os registros geológicos indicam episódios de alterações na oxigenação dos oceanos.'),
(15, 'barremiano', 'Barremiano', 'idade', 125.7700, 121.4000, 6, 'O Barremiano ocorreu entre aproximadamente 125,77 e 121,4 milhões de anos atrás, durante o Cretáceo Inferior. Seus depósitos fossilíferos preservam importantes registros de dinossauros, répteis voadores, plantas e organismos marinhos.', 'Gondwana continuava se fragmentando, com a separação progressiva das massas continentais que futuramente formariam a América do Sul, África, Antártida e Austrália. A Laurásia também apresentava mudanças geográficas.', 'O clima era relativamente quente, embora apresentasse diferenças regionais de precipitação. Ambientes úmidos e florestais coexistiam com regiões mais secas e sazonais.', 'Os oceanos apresentavam amonites, moluscos, peixes, tubarões e répteis marinhos. A expansão gradual das bacias oceânicas modificava a distribuição dos mares e dos ambientes costeiros.', 'A vegetação era composta principalmente por coníferas, samambaias, cicadáceas e outras plantas sem flores. As primeiras angiospermas já estavam presentes em algumas regiões.', 'Os ambientes incluíam florestas, planícies aluviais, rios, lagos, pântanos e regiões costeiras. Alguns depósitos sedimentares preservam evidências de ecossistemas continentais bastante diversificados.', 'Dinossauros terópodes, saurópodes e ornitópodes estavam presentes. Pterossauros, aves primitivas, pequenos mamíferos, crocodilianos e organismos marinhos também compunham a biodiversidade.', 'O Barremiano preserva registros de diversos dinossauros e outros animais do Cretáceo Inferior. Fósseis encontrados em diferentes continentes ajudam a compreender como os organismos se distribuíam em um planeta que passava por mudanças geográficas.'),
(16, 'hauteriviano', 'Hauteriviano', 'idade', 132.6000, 125.7700, 6, 'O Hauteriviano ocorreu entre aproximadamente 132,6 e 125,77 milhões de anos atrás, durante o Cretáceo Inferior. Foi um intervalo de transformações geográficas e diversificação de diferentes grupos de animais terrestres e marinhos.', 'Os continentes continuavam se afastando lentamente. A fragmentação de Gondwana avançava e as bacias oceânicas se expandiam, modificando a distribuição das regiões costeiras.', 'O clima apresentava condições geralmente quentes, com variações regionais de umidade. Regiões florestais e planícies úmidas coexistiam com áreas de clima mais seco.', 'Os mares apresentavam amonites, moluscos, peixes, tubarões e répteis marinhos. A movimentação das placas tectônicas favorecia a expansão de diferentes bacias oceânicas.', 'Coníferas, samambaias e cicadáceas eram comuns, formando florestas e outras comunidades vegetais. As angiospermas ainda estavam em suas primeiras etapas de evolução e diversificação.', 'Os ambientes terrestres incluíam florestas, planícies fluviais, lagos e áreas pantanosas. Regiões costeiras e ambientes marinhos rasos também estavam presentes.', 'A fauna incluía diversos dinossauros, pterossauros, crocodilianos, tartarugas, pequenos mamíferos e aves primitivas. Os ambientes marinhos eram habitados por peixes, amonites e répteis aquáticos.', 'O Hauteriviano integra o Cretáceo Inferior e apresenta registros fósseis de dinossauros, répteis voadores e organismos marinhos. Os depósitos sedimentares dessa idade são importantes para o estudo dos antigos ambientes terrestres e oceânicos.'),
(17, 'valanginiano', 'Valanginiano', 'idade', 137.0500, 132.6000, 6, 'O Valanginiano ocorreu entre aproximadamente 137,05 e 132,6 milhões de anos atrás, durante o Cretáceo Inferior. Foi marcado pela continuidade da fragmentação continental e pela presença de diversos grupos de dinossauros e organismos marinhos.', 'Gondwana continuava em processo de fragmentação e o Oceano Atlântico começava a se desenvolver entre as massas continentais. Laurásia também apresentava mudanças relacionadas à movimentação tectônica.', 'O clima era relativamente quente, com variações regionais de temperatura e precipitação. Algumas regiões apresentavam florestas úmidas, enquanto outras possuíam condições sazonais mais secas.', 'Os oceanos abrigavam amonites, moluscos, peixes e répteis marinhos. Os mares rasos e as regiões costeiras ofereciam diferentes habitats para organismos aquáticos.', 'Coníferas, samambaias e cicadáceas dominavam a vegetação em muitas regiões. Plantas com sementes eram importantes componentes das comunidades vegetais.', 'Os ambientes incluíam florestas, planícies, sistemas fluviais, lagos e regiões costeiras. Também existiam ambientes marinhos rasos e bacias sedimentares em expansão.', 'Dinossauros saurópodes, terópodes e ornitópodes habitavam diferentes continentes. Pterossauros, crocodilianos, tartarugas, mamíferos primitivos e organismos marinhos também estavam presentes.', 'Durante o Valanginiano, os continentes continuavam se afastando gradualmente devido à movimentação das placas tectônicas. Os fósseis desse intervalo registram diferentes grupos de organismos que habitavam os ambientes terrestres e marinhos.'),
(18, 'berriasiano', 'Berriasiano', 'idade', 143.1000, 137.0500, 6, 'O Berriasiano representa a primeira idade do Cretáceo, iniciada há aproximadamente 143,1 milhões de anos e encerrada há 137,05 milhões de anos. Começou após o final do Jurássico e preserva registros importantes da continuidade e diversificação dos ecossistemas mesozoicos.', 'Os continentes ainda estavam relativamente próximos em comparação com suas posições atuais, mas a fragmentação da Pangeia avançava. Laurásia e Gondwana já representavam grandes conjuntos continentais separados por bacias oceânicas em desenvolvimento.', 'O clima era geralmente quente, com variações regionais de temperatura e umidade. Ambientes úmidos e florestais coexistiam com regiões mais secas e sazonais.', 'Os mares abrigavam amonites, moluscos, peixes, tubarões e répteis marinhos. A movimentação tectônica continuava modificando as bacias oceânicas e as regiões costeiras.', 'Coníferas, cicadáceas, samambaias e outras plantas sem flores eram predominantes. As plantas com flores ainda não apresentavam a grande diversificação que ocorreria posteriormente no Cretáceo.', 'Existiam florestas, planícies fluviais, lagos, pântanos, regiões costeiras e ambientes marinhos rasos. A diversidade de paisagens favorecia diferentes comunidades de vertebrados.', 'Dinossauros, pterossauros, crocodilianos, tartarugas, aves primitivas e pequenos mamíferos estavam presentes. Muitos grupos de animais já estabelecidos no Jurássico continuaram a se diversificar.', 'O Berriasiano representa a primeira idade do Cretáceo. Ele começou após o final do Jurássico, período em que muitos grupos de dinossauros já estavam estabelecidos. Seus registros ajudam a compreender as primeiras etapas da história cretácea.'),
(19, 'cisuraliano', 'Cisuraliano', 'epoca', 298.9000, 273.0100, 3, 'O Cisuraliano foi a primeira época do Permiano, iniciada há aproximadamente 298,9 milhões de anos e encerrada há 273,01 milhões de anos. Durante esse intervalo, os ambientes terrestres passaram por transformações após as glaciações do Carbonífero e os vertebrados terrestres apresentaram grande diversificação.', 'As grandes massas continentais estavam reunidas no supercontinente Pangeia. O oceano Panthalassa ocupava a maior parte da superfície oceânica, enquanto o mar de Tétis começava a se desenvolver em regiões tropicais.', 'O clima apresentava grande diversidade regional. O interior de Pangeia começava a desenvolver condições mais secas, enquanto algumas regiões ainda preservavam ambientes úmidos e evidências de condições glaciais herdadas do período anterior.', 'O Panthalassa e os mares associados abrigavam braquiópodes, moluscos, equinodermos, peixes e outros organismos marinhos. Os recifes e comunidades marinhas apresentavam mudanças em relação ao Carbonífero.', 'Florestas de coníferas e outras gimnospermas começaram a se expandir em regiões mais secas. Samambaias e plantas com sementes também eram importantes, especialmente em ambientes úmidos.', 'Os ambientes incluíam florestas, planícies, pântanos, rios, lagos e regiões progressivamente mais áridas. A expansão de ambientes continentais secos influenciou a distribuição dos organismos.', 'Os vertebrados terrestres apresentavam sinapsídeos, incluindo pelicossauros, além de répteis e anfíbios. Insetos e diferentes invertebrados também eram abundantes, enquanto os oceanos abrigavam peixes e diversos organismos marinhos.', 'O Cisuraliano corresponde à primeira época do Permiano. Durante esse intervalo, os ambientes terrestres apresentavam extensas áreas continentais e uma fauna diversificada, incluindo sinapsídeos e outros grupos de vertebrados que antecederam os mamíferos.'),
(20, 'guadalupiano', 'Guadalupiano', 'epoca', 273.0100, 259.5100, 3, 'O Guadalupiano foi a segunda época do Permiano, ocorrida entre aproximadamente 273,01 e 259,51 milhões de anos atrás. Foi marcada por mudanças climáticas e ambientais, além da diversificação dos terápsidos, grupo importante na evolução dos mamíferos.', 'Pangeia permanecia como o principal supercontinente da Terra, cercado pelo oceano Panthalassa. O mar de Tétis ocupava regiões tropicais e as áreas interiores continentais apresentavam condições geográficas bastante distintas das regiões costeiras.', 'O clima era predominantemente quente e seco no interior de Pangeia, com grandes diferenças regionais de precipitação. A aridez de algumas regiões aumentava e mudanças ambientais afetavam diferentes ecossistemas.', 'Os oceanos abrigavam amonites, braquiópodes, moluscos, peixes e outros invertebrados. O final dessa época foi marcado por importantes crises ambientais, incluindo a extinção do Capitaniano.', 'As coníferas e outras gimnospermas estavam bem estabelecidas em regiões mais secas. Samambaias e outras plantas continuavam presentes em ambientes úmidos e próximos a rios e lagos.', 'Os ambientes incluíam extensos desertos, planícies áridas, florestas sazonais, rios e lagos. Regiões costeiras apresentavam condições mais úmidas e diferentes comunidades vegetais.', 'Os terápsidos começaram a apresentar maior diversificação, enquanto outros sinapsídeos e répteis continuavam presentes. Os ambientes aquáticos abrigavam peixes e diversos invertebrados marinhos.', 'O Guadalupiano foi marcado por mudanças ambientais e climáticas que afetaram diferentes ecossistemas. Nesse intervalo, os terápsidos começaram a ganhar importância entre os vertebrados terrestres, enquanto diversos grupos de animais marinhos continuavam presentes nos oceanos.'),
(21, 'lopingiano', 'Lopingiano', 'epoca', 259.5100, 251.9000, 3, 'O Lopingiano foi a última época do Permiano, iniciada há aproximadamente 259,51 milhões de anos e encerrada há 251,9 milhões de anos. Foi marcado pela diversificação de diferentes grupos de terápsidos e terminou com a maior extinção em massa conhecida da história da Terra.', 'Pangeia permanecia reunida como um único supercontinente, cercado pelo oceano Panthalassa. O mar de Tétis ocupava regiões entre as porções setentrionais e meridionais do supercontinente.', 'O clima era predominantemente quente e muitas regiões interiores de Pangeia apresentavam condições áridas. No final da época, mudanças ambientais intensas, associadas à atividade vulcânica, provocaram alterações climáticas globais.', 'Os oceanos abrigavam amonites, braquiópodes, moluscos, peixes e diversos invertebrados. No final do Permiano, alterações na temperatura, acidificação e redução da oxigenação das águas contribuíram para uma extinção marinha em grande escala.', 'Coníferas, samambaias com sementes e outras gimnospermas compunham a vegetação. As comunidades vegetais sofreram grandes alterações durante a crise ambiental do final do Permiano.', 'Os ambientes incluíam desertos, planícies áridas, florestas sazonais, rios, lagos e regiões costeiras. A crise ambiental do final da época transformou profundamente os ecossistemas terrestres e aquáticos.', 'Os terápsidos, incluindo formas herbívoras e predadoras, eram importantes componentes da fauna terrestre. Anfíbios, répteis, insetos e diversos organismos marinhos também estavam presentes. A extinção do final do Permiano eliminou grande parte das espécies existentes.', 'O Lopingiano foi a última época do Permiano e terminou com a maior extinção em massa da história da Terra. Mudanças climáticas intensas, atividade vulcânica em grande escala e alterações nos oceanos estão entre os fatores associados a esse evento.'),
(22, 'holoceno', 'Holoceno', 'epoca', 0.0117, 0.0000, 5, 'O Holoceno é a época geológica atual, iniciada há aproximadamente 11.700 anos, após o final da última grande glaciação. É caracterizado pela relativa estabilidade climática, expansão das sociedades humanas, desenvolvimento da agricultura e profundas transformações nos ecossistemas.', 'Os continentes apresentam configurações muito próximas das atuais. O nível dos oceanos aumentou após o derretimento das grandes geleiras do Pleistoceno, modificando linhas costeiras e formando diferentes paisagens.', 'O clima tornou-se relativamente mais quente e estável em comparação com os períodos glaciais anteriores. Entretanto, apresenta variações naturais e, mais recentemente, um aquecimento global intensificado pelas atividades humanas.', 'O nível dos oceanos aumentou significativamente após o final da última glaciação e posteriormente apresentou relativa estabilidade. Os ecossistemas marinhos e costeiros desenvolveram-se em condições próximas das atuais.', 'As angiospermas, gramíneas, coníferas e outras plantas atuais ocupam diferentes regiões do planeta. Florestas, savanas, pradarias e outras formações vegetais apresentam distribuição influenciada pelo clima e pelas atividades humanas.', 'Os ambientes incluem florestas tropicais e temperadas, savanas, pradarias, desertos, tundras, rios, lagos, oceanos e regiões costeiras. A agricultura, a urbanização e o desmatamento transformaram significativamente muitas paisagens.', 'A biodiversidade apresenta os principais grupos de organismos atuais, incluindo mamíferos, aves, répteis, anfíbios, peixes, insetos e plantas. A atividade humana provocou extinções, alterações na distribuição das espécies e mudanças nos ecossistemas.', 'O Holoceno é a época em que surgiram e se desenvolveram as primeiras grandes civilizações humanas. A agricultura, a domesticação de animais e a formação das cidades transformaram profundamente a relação entre os seres humanos e o ambiente.'),
(23, 'paleozoico', 'Paleozoica', 'era', 538.8000, 251.9000, NULL, 'A Era Paleozoica foi um intervalo da história da Terra marcado pela diversificação da vida marinha, colonização dos ambientes terrestres por plantas e animais e surgimento de grandes ecossistemas continentais. Terminou com a maior extinção em massa conhecida, no final do Permiano.', NULL, NULL, NULL, NULL, NULL, NULL, 'Durante a Era Paleozoica surgiram os primeiros peixes com mandíbulas, anfíbios e répteis. Também ocorreu a formação de extensas florestas e a diversificação de muitos grupos de invertebrados marinhos.'),
(24, 'mesozoico', 'Mesozoica', 'era', 251.9000, 66.0000, NULL, 'A Era Mesozoica ficou conhecida como a Era dos Répteis, sendo marcada pela diversificação e domínio dos dinossauros em muitos ambientes terrestres. Também surgiram os primeiros mamíferos e aves, enquanto os continentes continuavam se fragmentando.', NULL, NULL, NULL, NULL, NULL, NULL, 'A Mesozoica é tradicionalmente conhecida como a Era dos Dinossauros. Ela também foi marcada pelo surgimento das primeiras aves e plantas com flores.'),
(25, 'cenozoico', 'Cenozoica', 'era', 66.0000, 0.0000, NULL, 'A Era Cenozoica começou após a extinção do final do Cretáceo e é marcada pela diversificação dos mamíferos e aves. Durante esse intervalo, os continentes assumiram posições próximas das atuais, os ecossistemas modernos se desenvolveram e ocorreu a evolução e expansão da humanidade.', NULL, NULL, NULL, NULL, NULL, NULL, 'A Cenozoica é frequentemente chamada de Era dos Mamíferos, devido à grande diversificação desse grupo após a extinção dos dinossauros não avianos.');

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
(1, 'assets/images/species/trex/principal.png', 'Imagem principal trex'),
(4, 'assets/images/species/triceratops/principal.png', 'Imagem principal triceratops'),
(7, 'assets/images/species/velociraptor/principal.png', 'Imagem principal velociraptor'),
(10, 'assets/images/species/ankylosaurus/principal.png', 'Imagem principal ankylosaurus'),
(13, 'assets/images/species/mamute/principal.png', 'Imagem principal mamute'),
(15, 'assets/images/species/diplocaulus/card.png', 'imagem para card diplocaulus'),
(37, 'assets/images/species/diplocaulus/principal.png', 'Imagem principal diplocaulus'),
(38, 'assets/images/species/trex/discovery.png', 'Imagem de Fóssil de trex'),
(39, 'assets/images/species/trex/behavior.png', 'Imagem de comportamento trex'),
(40, 'assets/images/species/trex/ecology.png', 'Imagem de ecologia trex'),
(41, 'assets/images/species/trex/curiosities.png', 'Imagem de cusiosidades trex'),
(42, 'assets/images/species/trex/card.png', 'Imagem para card trex');

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
(10, 37, 'principal'),
(1, 38, 'discovery'),
(1, 39, 'behavior'),
(1, 40, 'ecology'),
(1, 41, 'curiosities'),
(1, 42, 'card');

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
  ADD PRIMARY KEY (`geotime_id`,`image_id`,`purpose`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
-- Restrições para tabelas `tax`
--
ALTER TABLE `tax`
  ADD CONSTRAINT `tax_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `tax` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
