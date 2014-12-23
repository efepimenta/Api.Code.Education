-- phpMyAdmin SQL Dump
-- version 4.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 23-Dez-2014 às 18:25
-- Versão do servidor: 10.0.14-MariaDB
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `site`
--
DROP DATABASE IF EXISTS `site`;
CREATE DATABASE IF NOT EXISTS `site` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `site`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `descricao` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `descricao`) VALUES
(1, 'Hardware', 'coisas que da pra chutar'),
(2, 'Software', 'coisas que da pra xingar'),
(3, 'NadaWare', 'nao faz nada');

-- --------------------------------------------------------

--
-- Estrutura da tabela `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `kind` char(1) NOT NULL,
  `sequencia` int(11) NOT NULL,
  `posicao` int(11) DEFAULT NULL,
  `imagem` varchar(50) DEFAULT NULL,
  `fim` char(1) NOT NULL DEFAULT 'N',
  `id_rota` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `menu`
--

INSERT INTO `menu` (`id`, `nome`, `kind`, `sequencia`, `posicao`, `imagem`, `fim`, `id_rota`) VALUES
(1, 'Produtos', 'M', 1, 1, NULL, 'N', NULL),
(2, 'Ajuda', 'M', 3, 1, NULL, 'N', NULL),
(3, 'Sobre a Api', 'I', 3, 2, NULL, 'S', 1),
(5, 'um link', 'L', 2, 1, NULL, 'N', 9),
(6, 'Listar', 'I', 1, 2, NULL, 'N', 5),
(7, 'Novo', 'I', 1, 4, '', 'N', 2),
(8, 'div', 'D', 1, 3, '', 'N', NULL),
(9, 'Editar', 'I', 1, 5, '', 'N', 3),
(10, 'Excluir', 'I', 1, 6, '', 'S', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `imagem` varchar(50) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `codigo`, `nome`, `descricao`, `valor`, `imagem`, `id_categoria`) VALUES
(31, NULL, 'nome novo 1', 'uma descricao', '123.00', 'images/2.jpg', 2),
(33, NULL, 'nome novo 2', 'uma descricao', '123.00', 'images/1.jpg', 2),
(34, NULL, 'asdfasd', 'asdfasd', '1234.00', 'images/3.png', 1),
(40, NULL, 'nome novo de produto novo 3', 'uma descricao', '123.56', 'images/2.jpg', 2),
(41, NULL, 'nome novo de produto novo 4', 'uma descricao', '123.56', 'images/1.jpg', 3),
(42, NULL, 'nome editado via json 5', 'uma descricao descritiva', '258.00', 'images/3.png', 1),
(43, NULL, 'nome editado via json 6', 'uma descricao descritiva', '1235.25', 'images/1.jpg', 1),
(44, NULL, 'nome do registro 44', 'uma descricao sem descricao', '123.00', 'images/1.jpg', 2),
(46, NULL, 'um produto bom', 'realmente um produto bom, so que Ã© caro', '1593.00', 'images/1.jpg', 1),
(47, NULL, 'nome editado via json', 'uma descricao descritiva', '1235.25', 'images/2.jpg', 3),
(48, NULL, 'nome novo de produto novo', 'uma descricao', '123.56', 'images/3.png', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rotas`
--

DROP TABLE IF EXISTS `rotas`;
CREATE TABLE IF NOT EXISTS `rotas` (
  `id` int(11) NOT NULL,
  `rota` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `rotas`
--

INSERT INTO `rotas` (`id`, `rota`) VALUES
(0, 'index'),
(1, 'ajuda/sobre'),
(2, 'produto/novo'),
(3, 'produto/editar'),
(4, 'produto/excluir'),
(5, 'produto'),
(8, 'login'),
(9, 'link');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL,
  `login` varchar(32) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `email` varchar(120) NOT NULL,
  `sessao` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `login`, `senha`, `email`, `sessao`) VALUES
(1, 'user@email.com', '$2y$10$FErHdu.BDcLYI1bQnWVere/jiB7riG9n2xLi2yuo0fcQej/J76vRm', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD KEY `fk_rota` (`id_rota`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD KEY `id_categoria` (`id_categoria`);

--
-- Indexes for table `rotas`
--
ALTER TABLE `rotas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD UNIQUE KEY `login_UNIQUE` (`login`), ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `rotas`
--
ALTER TABLE `rotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `menu`
--
ALTER TABLE `menu`
ADD CONSTRAINT `fk_rota` FOREIGN KEY (`id_rota`) REFERENCES `rotas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
