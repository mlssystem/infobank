--
-- Banco de dados: `infobank`
--
DROP DATABASE IF EXISTS `infobank`;
CREATE DATABASE IF NOT EXISTS `infobank` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `infobank`;
-- --------------------------------------------------------

--
-- Estrutura da tabela `bancos_dados`
--

CREATE TABLE `bancos_dados` (
  `id` int(11) NOT NULL,
  `nome_banco` varchar(220) NOT NULL,
  `usuario` varchar(220) NOT NULL,
  `senha` varchar(220) NOT NULL,
  `localhost` varchar(220) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `bancos_dados`
--

INSERT INTO `bancos_dados` (`id`, `nome_banco`, `usuario`, `senha`, `localhost`, `created`, `modified`) VALUES
(1, 'banco_dados', 'banco_dados', 'banco_dados', 'banco_dados', '2023-04-04 09:48:16', '2023-04-04 09:48:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `descricao`
--

CREATE TABLE `descricao` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `descricao`
--

INSERT INTO `descricao` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Descriçao', '2023-04-04 17:29:45', '2023-04-04 17:29:45'),
(2, 'Sistema Cadastro', '2023-04-04 17:29:45', '2023-04-04 17:29:45'),
(3, 'Sistema Vendas', '2023-04-04 17:29:45', '2023-04-04 17:29:45'),
(4, 'Sistema Administrativo', '2023-04-04 17:29:45', '2023-04-04 17:29:45'),
(5, 'Loja Virtual', '2023-04-04 17:29:45', '2023-04-04 17:29:45'),
(6, 'Site', '2023-04-04 17:29:45', '2023-04-04 17:29:45'),
(7, 'Blog', '2023-04-06 21:20:10', '2023-04-06 21:20:10'),
(8, 'Alarme', '2023-04-06 21:31:53', '2023-04-06 21:31:53'),
(9, 'Sistema OS', '2023-04-06 21:33:55', '2023-04-06 21:33:55'),
(10, 'Tabuada', '2023-04-06 21:38:37', '2023-04-06 21:38:37');

-- --------------------------------------------------------

--
-- Estrutura da tabela `linguagem`
--

CREATE TABLE `linguagem` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `linguagem`
--

INSERT INTO `linguagem` (`id`, `name`, `created`, `modified`) VALUES
(1, 'LINGUAGEM', '2023-04-04 16:20:17', NULL),
(2, 'HTML', '2023-04-04 16:20:17', NULL),
(3, 'PHP', '2023-04-04 16:20:17', NULL),
(4, 'JAVASCRIPT', '2023-04-04 16:20:17', NULL),
(5, 'NODE.JS', '2023-04-04 16:20:17', NULL),
(6, 'WORDPRESS', '2023-04-06 21:14:03', NULL),
(7, 'BOOTSTRAP', '2023-04-06 21:20:32', NULL),
(8, 'JAVA', '2023-04-06 21:24:05', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sistemas`
--

CREATE TABLE `sistemas` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) NOT NULL,
  `banco_dado_id` int(11) DEFAULT 1,
  `linguagem_id` int(11) NOT NULL DEFAULT 1,
  `descricao_id` int(11) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `sistemas`
--

INSERT INTO `sistemas` (`id`, `nome`, `banco_dado_id`, `linguagem_id`, `descricao_id`, `created`, `modified`) VALUES
(1, 'Sistema', 1, 1, 1, '2023-04-07 14:33:24', '2023-04-07 14:33:24');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `bancos_dados`
--
ALTER TABLE `bancos_dados`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `descricao`
--
ALTER TABLE `descricao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `linguagem`
--
ALTER TABLE `linguagem`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `sistemas`
--
ALTER TABLE `sistemas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banco_dado_id` (`banco_dado_id`),
  ADD KEY `linguagem_id` (`linguagem_id`),
  ADD KEY `descricao_id` (`descricao_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `bancos_dados`
--
ALTER TABLE `bancos_dados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `descricao`
--
ALTER TABLE `descricao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `linguagem`
--
ALTER TABLE `linguagem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `sistemas`
--
ALTER TABLE `sistemas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `sistemas`
--
ALTER TABLE `sistemas`
  ADD CONSTRAINT `sistemas_ibfk_1` FOREIGN KEY (`banco_dado_id`) REFERENCES `bancos_dados` (`id`);
COMMIT;
