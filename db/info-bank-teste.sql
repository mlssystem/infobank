-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Jul-2022 às 17:56
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `info-bank`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `bancos_dados`
--

CREATE TABLE `bancos_dados` (
  `id` int(11) NOT NULL,
  `nome_banco` varchar(220) NOT NULL,
  `usuario` varchar(220) NOT NULL,
  `senha` varchar(220) NOT NULL,
  `localhost` varchar(220) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `bancos_dados`
--

INSERT INTO `bancos_dados` (`id`, `nome_banco`, `usuario`, `senha`, `localhost`) VALUES
(1, 'dewhdygfhbclients', 'dewhdygfhbclients', 'dewhdygfhblients@list44', 'dewhdygfhb'),
(2, 'dewhdygfhbcttdt', 'dewhdygfhbcontato', 'dewhdygfhbadminContato', 'dewhdygfhb'),
(3, 'dewhdygfhbkey', 'dewhdygfhbkey', 'dewhdygfhbey@aleatory', 'dewhdygfhb'),
(4, 'dewhdygfhbsistema', 'dewhdygfhbsistema', 'dewhdygfhbistem23', 'dewhdygfhb'),
(5, 'dewhdygfhbidentidadeof', 'dewhdygfhbidentidadeof', 'dewhdygfhbistema3', 'dewhdygfhb'),
(6, 'dewhdygfhbidentidadesistema', 'dewhdygfhbidentidadesistema', 'dewhdygfhbiste23', 'dewhdygfhb'),
(7, 'dewhdygfhbenda-eletronicos', 'dewhdygfhboot', 'dewhdygfhb', 'dewhdygfhbampp'),
(8, 'dewhdygfhbenda-eletronicos8', 'dewhdygfhbaquel', 'dewhdygfhb875', 'dewhdygfhbamp'),
(9, 'dewhdygfhbenda-eletronicos9', 'dewhdygfhbock', 'dewhdygfhb0000', 'dewhdygfhbamp'),
(10, 'dewhdygfhbenda-eletronicos10', 'dewhdygfhbati', 'dewhdygfhb000', 'dewhdygfhbap'),
(11, 'dewhdygfhbenda-eletronicos11', 'dewhdygfhbita', 'dewhdygfhb000', 'dewhdygfhbp'),
(12, 'dewhdygfhbenda-eletronicos12', 'dewhdygfhbti', 'dewhdygfhb0', 'dewhdygfhboilo'),
(13, 'dewhdygfhbenda-eletronicos13', 'dewhdygfhbati', 'dewhdygfhb', 'dewhdygfhbamp');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sistemas`
--

CREATE TABLE `sistemas` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) NOT NULL,
  `linguagem` varchar(220) NOT NULL,
  `descricao` varchar(220) NOT NULL,
  `banco_dado_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `sistemas`
--

INSERT INTO `sistemas` (`id`, `nome`, `linguagem`, `descricao`, `banco_dado_id`, `created`, `modified`) VALUES
(1, 'Clients', 'PHP', 'Cadastro de clientes com busca otimizada.', 1, '2022-07-07 02:30:57', '2022-07-07 21:30:57'),
(2, 'Cttdt', 'PHP	', 'Mensagens do formulário de contato', 2, '2022-07-07 02:32:32', '2022-07-06 21:32:32'),
(3, 'Chave', 'PHP', 'Chave aleatória', 3, '2022-07-07 02:32:32', '2022-07-06 21:32:32'),
(4, 'aleatória', 'PHP', 'Compra e venda de produtos com controle de estoque', 4, '2022-07-07 02:33:41', '2022-07-06 21:33:42'),
(5, 'Sistema', 'PHP', 'Sistema Otimizado', 5, '2022-07-06 22:09:36', '2022-07-06 22:09:36'),
(6, 'Clients', 'PHP', 'Clients Otimizado', 6, '2022-07-06 22:22:49', '2022-07-06 22:22:49'),
(7, 'Venda', 'PHP', 'CRUD - jehfuh3ffb ', 7, '2022-07-06 22:38:34', '2022-07-07 22:38:34'),
(8, 'Venda2', 'PHP', 'CRUD - jehfuh3ffb2 ', 8, '2022-07-07 22:38:34', '2022-07-07 22:38:34'),
(9, 'Venda3', 'PHP', 'CRUD - jehfuh3ffb3 ', 9, '2022-07-07 22:38:34', '2022-07-07 22:38:34'),
(10, 'Venda4', 'PHP', 'CRUD - jehfuh3ffb3 ', 10, '2022-07-07 22:38:34', '2022-07-07 22:38:34'),
(11, 'Venda5', 'PHP', 'CRUD - jehfuh3ffb3 ', 11, '2022-07-07 22:38:34', '2022-07-07 22:38:34'),
(12, 'Venda6', 'PHP', 'CRUD - jehfuh3ffb3 ', 12, '2022-07-07 22:38:34', '2022-07-07 22:38:34'),
(13, 'Venda7', 'PHP', 'CRUD - jehfuh3ffb3 ', 13, '2022-07-07 22:38:34', '2022-07-07 22:38:34');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `bancos_dados`
--
ALTER TABLE `bancos_dados`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `sistemas`
--
ALTER TABLE `sistemas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banco_dado_id` (`banco_dado_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `bancos_dados`
--
ALTER TABLE `bancos_dados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `sistemas`
--
ALTER TABLE `sistemas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `sistemas`
--
ALTER TABLE `sistemas`
  ADD CONSTRAINT `sistemas_ibfk_1` FOREIGN KEY (`banco_dado_id`) REFERENCES `bancos_dados` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
