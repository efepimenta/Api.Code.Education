-- phpMyAdmin SQL Dump
-- version 4.3.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 14/01/2015 às 13:19
-- Versão do servidor: 5.6.22
-- Versão do PHP: 5.6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `site`
--

DROP SCHEMA IF EXISTS `site`;
CREATE SCHEMA `site`;
USE `site`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `descricao`) VALUES
(2, 'Hardware', 'coisas que da pra chutar com o pÃ©'),
(3, 'Software', 'coisas que da pra xingar');

-- --------------------------------------------------------

--
-- Estrutura para tabela `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `kind` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `sequencia` int(11) NOT NULL,
  `posicao` int(11) NOT NULL,
  `imagem` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fim` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `id_rota` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `menu`
--

INSERT INTO `menu` (`id`, `nome`, `kind`, `sequencia`, `posicao`, `imagem`, `fim`, `id_rota`) VALUES
(1, 'Produtos', 'M', 1, 1, NULL, 'N', NULL),
(2, 'Ajuda', 'M', 5, 1, NULL, 'N', NULL),
(3, 'Sobre a Api', 'I', 5, 2, NULL, 'S', 2),
(5, 'um link', 'L', 4, 1, NULL, 'N', 8),
(6, 'Listar', 'I', 1, 2, NULL, 'N', 6),
(7, 'Novo', 'I', 1, 4, '', 'N', 3),
(8, 'div', 'D', 1, 3, '', 'N', NULL),
(9, 'Editar', 'I', 1, 5, '', 'N', 4),
(10, 'Excluir', 'I', 1, 6, '', 'S', 5),
(11, 'Categorias', 'M', 2, 1, NULL, 'N', NULL),
(12, 'Listar', 'I', 2, 2, NULL, 'N', 9),
(13, 'div', 'D', 2, 3, NULL, 'N', NULL),
(14, 'Editar', 'I', 2, 5, NULL, 'N', 10),
(15, 'Excluir', 'I', 2, 6, NULL, 'S', 11),
(16, 'Nova', 'I', 2, 4, NULL, 'N', 12),
(17, 'Tags', 'M', 3, 1, NULL, 'N', NULL),
(18, 'Listar', 'I', 3, 2, NULL, 'N', 13),
(19, 'div', 'D', 3, 3, NULL, 'N', NULL),
(20, 'Editar', 'I', 3, 5, NULL, 'N', 14),
(21, 'Excluir', 'I', 3, 6, NULL, 'S', 15),
(22, 'Nova', 'I', 3, 4, NULL, 'N', 16);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `codigo` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` longtext COLLATE utf8_unicode_ci NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `imagem` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `produtos`
--

INSERT INTO `produtos` (`id`, `id_categoria`, `codigo`, `nome`, `descricao`, `valor`, `imagem`) VALUES
(1, 3, NULL, 'Produto bunito feio', 'descricao bunita', '158.33', NULL),
(2, 2, NULL, 'Produto bunito', 'uma descricao descritiva de novo', '32.33', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `rotas`
--

CREATE TABLE IF NOT EXISTS `rotas` (
  `id` int(11) NOT NULL,
  `rota` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `rotas`
--

INSERT INTO `rotas` (`id`, `rota`) VALUES
(1, 'index'),
(2, 'ajuda/sobre'),
(3, 'produto/novo'),
(4, 'produto/editar'),
(5, 'produto/excluir'),
(6, 'produto'),
(7, 'login'),
(8, 'link'),
(9, 'categoria'),
(10, 'categoria/editar'),
(11, 'categoria/excluir'),
(12, 'categoria/novo'),
(13, 'tag'),
(14, 'tag/editar'),
(15, 'tag/excluir'),
(16, 'tag/novo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL,
  `tag` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `tags`
--

INSERT INTO `tags` (`id`, `tag`) VALUES
(2, 'Mais Vendidos'),
(3, 'Menos Vendidos');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tags_produto`
--

CREATE TABLE IF NOT EXISTS `tags_produto` (
  `produto_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `tags_produto`
--

INSERT INTO `tags_produto` (`produto_id`, `tag_id`) VALUES
(1, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL,
  `login` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `sessao` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `login`, `senha`, `email`, `sessao`) VALUES
(1, 'user@email.com', '$2y$10$FErHdu.BDcLYI1bQnWVere/jiB7riG9n2xLi2yuo0fcQej/J76vRm', '', '');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`), ADD KEY `IDX_3E52435CE25AE0A` (`id_categoria`);

--
-- Índices de tabela `rotas`
--
ALTER TABLE `rotas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tags_produto`
--
ALTER TABLE `tags_produto`
  ADD PRIMARY KEY (`produto_id`,`tag_id`), ADD KEY `IDX_7A10A2C6105CFD56` (`produto_id`), ADD KEY `IDX_7A10A2C6BAD26311` (`tag_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de tabela `rotas`
--
ALTER TABLE `rotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de tabela `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
ADD CONSTRAINT `FK_3E52435CE25AE0A` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`);

--
-- Restrições para tabelas `tags_produto`
--
ALTER TABLE `tags_produto`
ADD CONSTRAINT `FK_7A10A2C6105CFD56` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
ADD CONSTRAINT `FK_7A10A2C6BAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;