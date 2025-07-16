-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2025 at 07:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipe_app_dump`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` varchar(40) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `descricao`) VALUES
('Gluten-Free', 'Dieta à base de alimentos que não contêm glúten, uma proteína encontrada em grãos como trigo, cevada e centeio.'),
('Moçambique', 'A gastronomia de Moçambique é rica, diversa e profundamente influenciada por suas raízes africanas, bem como pelas influências árabes, portuguesas e indianas. É marcada pelo uso generoso de especiarias, frutos do mar, amendoim, mandioca e coco.'),
('Prato Frio', 'Preparação culinária que se destaca por ser servido em temperatura ambiente ou refrigerado. Comumente associado a eventos sociais, como festas e coquetéis, esse tipo de prato é ideal para ser consumido em momentos de descontração. Os pratos frios podem incluir uma variedade de ingredientes, como carnes, queijos, vegetais e molhos, proporcionando uma experiência gastronômica diversificada e saborosa.'),
('Prato Quente', 'Preparações culinárias que são servidas a uma temperatura elevada, proporcionando uma experiência gastronômica que envolve não apenas o sabor, mas também a sensação de calor e conforto. Esses pratos podem incluir uma variedade de ingredientes, como carnes, vegetais, grãos e molhos, que são cozidos ou assados de maneiras que intensificam seus sabores e texturas.'),
('Rápido', 'Receitas com preparação menor a 30 minutos'),
('Salada', 'Prato composto por uma mistura de vegetais crus, cozidos ou grelhados, frutas, legumes, grãos, proteínas e molhos, que pode ser servido como entrada, acompanhamento ou prato principal.'),
('Sobremesa', 'Último prato que se faz em uma refeição, geralmente frutas, doces, chocolates, sorvetes etc. '),
('Sopa', 'Comida líquida ou pastosa, importante elemento da gastronomia. Os ingredientes da sopa são tão variados quanto as mais diversas culinárias, podendo incluir hortaliças (batata, cebola, couve, cenoura), farinhas ou féculas, gorduras vegetais ou animais, carnes ou peixes e mariscos.'),
('Tradicional', 'Um prato tradicional é mais do que simplesmente uma receita com ingredientes específicos. Ele carrega consigo toda uma história e significado cultural que o tornam único e especial. Muitas vezes, esses pratos são passados de geração em geração, preservando não apenas o sabor, mas também as tradições de um povo.'),
('Vegan', 'Dieta à base de plantas: excluem-se carne, leite e derivados, ovos, mel, ou qualquer outro produto proveniente de um animal.'),
('Vegetariano', 'Dieta à base de plantas e derivados como: leite, ovos, mel. Excluindo produtos diretos como: carne, peixe, marisco etc...');

-- --------------------------------------------------------

--
-- Table structure for table `ingredientes`
--

CREATE TABLE `ingredientes` (
  `id_ingrediente` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredientes`
--

INSERT INTO `ingredientes` (`id_ingrediente`) VALUES
('Água'),
('Alface Iceberg'),
('Alho Inteiro'),
('Amendoim Pilado'),
('Batata'),
('Batata Doce'),
('Cebola'),
('Coco Ralado'),
('Dentes de Alho'),
('Farinha de Milho'),
('Folhas de Mandioca'),
('Oleo de Girasol'),
('Paprika'),
('Pimenta Cyanne'),
('Pimenta Preta'),
('Sal'),
('Tomate Cherry');

-- --------------------------------------------------------

--
-- Table structure for table `receitas`
--

CREATE TABLE `receitas` (
  `id_receita` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `descricao` text NOT NULL,
  `prep` time DEFAULT NULL,
  `dose` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receitas`
--

INSERT INTO `receitas` (`id_receita`, `nome`, `descricao`, `prep`, `dose`) VALUES
(1, 'Matapa de Moçambique', '1. Coloca-se a matapa numa panela com água e leva-se a cozinhar até a água desaparecer totalmente. A matapa tem de ficar bem sequinha. Este processo pode demorar entre 45 a 60 min. Reserva-se.\r\n\r\n2. Faz-se o leite de côco: ralam-se os côcos – ou usa-se côco já ralado – para um recipiente, junta-se 250ml de água morna e, com as duas mãos, espreme-se bem o côco juntamente com a água durante alguns segundos por forma a extraír o máximo conteúdo do côco para a água. Coa-se, com um pano fino, para outro recipiente. Volta-se a colocar o côco ralado, e já coado uma vez, no primeiro recipiente e acrescentam-se mais 500ml de água morna. Repete-se o processo e coa-se novamente para junto do primeiro leite coado e temos o nosso leite de côco feito de forma artesanal. Salta-se este passo se se usar leite de côco de compra.\r\n\r\n3. Faz-se o preparado de amendoim e côco: retira-se um pouco de leite de côco para outro recipiente (cerca de 1/3) e junta-se a farinha de amendoim aos poucos mexendo muito bem para diluír. Coa-se para dentro do nosso leite de côco e mexe-se. Retira-se a restante quantidade da farinha de amendoim que ficou no passador e volta-se a colocar no primeiro recipiente, juntando agora um pouco de água (+/-250ml) e mexendo novamente para continuar a diluir o bolo de farinha que ainda resta. Coa-se esta mistura novamente para dentro do leite de côco. Pode-se coar uma vez mais a farinha de amendoim com a mesma quantidade de água ou não. O objectivo deste processo é não deixar o prato muito denso da farinha de amendoim, mas desperdiçando o mínimo possível, por isso eu diria que se o bolo de amendoim coado 2 vezes ainda for significativo em termos de quantidade, deve-se coar uma vez mais, se não for despreza-se a restante farinha. Por fim mexe-se bem a mistura de leite de côco e amendoim, acrescenta-se o tomate e a cebola e leva-se a ferver, em lume brando, mexendo sempre para não colar ao fundo do tacho (cerca de 30 min.).\r\n\r\n3. Acrescenta-se a matapa e leva-se novamente ao lume – brando – para apurar, mexendo sempre. A Matapa vai engrossar e adquirir textura. Este processo demora cerca de 1/2h. A Matapa pode ter uma textura mais cremosa ou mais líquida consoante o gosto de quem a prepara. Combina com arroz ou fufu/xima/fuba.', '03:30:00', 4),
(2, 'Fufu, Xima, Farinha de Fubá: Sabores de ', '1. Ferver a água em uma panela.\r\n\r\n2. Assim que a água estiver fervendo, adicione lentamente o fubá de milho, mexendo constantemente para evitar a formação de grumos.\r\n\r\n3. Continue mexendo a mistura de milho e água em fogo baixo, até que a consistência da Xima esteja espessa e cozida.\r\n\r\n4.Uma vez que a Xima esteja pronta, ela pode ser servida quente como acompanhamento de pratos de carne, peixe ou vegetais. Sua consistência densa e neutra complementa maravilhosamente uma variedade de sabores e temperos!', '00:20:00', 9);

-- --------------------------------------------------------

--
-- Table structure for table `receita_categoria`
--

CREATE TABLE `receita_categoria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_receita` int(11) NOT NULL,
  `id_categoria` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receita_categoria`
--

INSERT INTO `receita_categoria` (`id`, `id_receita`, `id_categoria`) VALUES
(1, 1, 'Moçambique'),
(2, 1, 'Tradicional'),
(3, 1, 'Tradicional'),
(4, 1, 'Vegan'),
(5, 1, 'Vegetariano'),
(6, 1, 'Prato Quente'),
(7, 2, 'Moçambique'),
(8, 2, 'Tradicional'),
(9, 2, 'Vegan'),
(10, 2, 'Vegetariano'),
(11, 2, 'Gluten-Free'),
(12, 2, 'Rápido');

-- --------------------------------------------------------

--
-- Table structure for table `receita_ingrediente`
--

CREATE TABLE `receita_ingrediente` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quantidade` varchar(40) NOT NULL,
  `id_receita` int(11) NOT NULL,
  `id_ingrediente` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receita_ingrediente`
--

INSERT INTO `receita_ingrediente` (`id`, `quantidade`, `id_receita`, `id_ingrediente`) VALUES
(1, '500g', 1, 'Amendoim Pilado'),
(2, '250g', 1, 'Folhas de Mandioca'),
(3, '5', 1, 'Dentes de Alho'),
(4, '1', 1, 'Coco Ralado'),
(5, 'Pequena', 1, 'Cebola'),
(6, 'Colher de chá', 1, 'Sal'),
(7, 'Panela meio-Cheia', 1, 'Água'),
(8, 'Panela', 2, 'Água'),
(9, '500g', 2, 'Farinha de Milho'),
(10, '250g', 2, 'Coco Ralado'),
(11, 'Ao Gosto', 2, 'Sal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`id_ingrediente`);

--
-- Indexes for table `receitas`
--
ALTER TABLE `receitas`
  ADD PRIMARY KEY (`id_receita`);

--
-- Indexes for table `receita_categoria`
--
ALTER TABLE `receita_categoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_receita` (`id_receita`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indexes for table `receita_ingrediente`
--
ALTER TABLE `receita_ingrediente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_receita` (`id_receita`),
  ADD KEY `id_ingrediente` (`id_ingrediente`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `receitas`
--
ALTER TABLE `receitas`
  MODIFY `id_receita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `receita_categoria`
--
ALTER TABLE `receita_categoria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `receita_ingrediente`
--
ALTER TABLE `receita_ingrediente`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `receita_categoria`
--
ALTER TABLE `receita_categoria`
  ADD CONSTRAINT `receita_categoria_ibfk_1` FOREIGN KEY (`id_receita`) REFERENCES `receitas` (`id_receita`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `receita_categoria_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `receita_ingrediente`
--
ALTER TABLE `receita_ingrediente`
  ADD CONSTRAINT `receita_ingrediente_ibfk_1` FOREIGN KEY (`id_receita`) REFERENCES `receitas` (`id_receita`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `receita_ingrediente_ibfk_2` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id_ingrediente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;