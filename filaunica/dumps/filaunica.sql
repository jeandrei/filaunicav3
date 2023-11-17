-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Tempo de geração: 01/07/2020 às 00:38
-- Versão do servidor: 5.7.30
-- Versão do PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `filaunica`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `bairro`
--

CREATE TABLE `bairro` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `bairro`
--

INSERT INTO `bairro` (`id`, `nome`) VALUES
(5, 'Armação'),
(6, 'Gravata'),
(7, 'Santa Lídia'),
(8, 'Praia Alegre'),
(9, 'Centro'),
(10, 'São Nicolau'),
(11, 'NSra de Fátima'),
(12, 'São Cristovão');

-- --------------------------------------------------------

CREATE TABLE `situacao` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `cor` varchar(30) NOT NULL,
  `ativonafila` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `bairro`
--

INSERT INTO `situacao` (`id`, `descricao`, `cor`, `ativonafila`) VALUES
(1, 'Aguradando', '#00BFFF',1),
(2, 'Matriculado', '#3CB371',0),
(3, 'Cancelado', '#EE4000',0),
(4, 'Protocolo Vencido', '#CDC1C5',0),
(5, 'Convocado', '#FFC125',1),
(6, 'Desistente', '#836FFF',0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `escola`
--

CREATE TABLE `escola` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `bairro_id` int(11) NOT NULL,
  `logradouro` varchar(255) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `escola`
--

INSERT INTO `escola` (`id`, `nome`, `bairro_id`, `logradouro`, `numero`) VALUES
(4, 'CEI ANJOS DO ITAPOCOROI', 1, 'Avenida São João', 445),
(5, 'CEI DONA BELINHA', 3, 'Rua Vereador Arnô Reinaldo da Silva', 0),
(6, 'CEI MARA LÚCIA DE SOUZA DE MELO', 1, 'Rua Vereador Arnô Reinaldo da Silva', 0),
(7, 'CEI PINGO DE GENTE', 1, 'RUA ABÍLIO DE SOUZA - TRAV. BARBACENA', 488),
(8, 'CEI PROFª ORLANDINA BENTO MENDES', 3, 'Rua Antônio João Caldeira', 0),
(9, 'CEI PROFESSORA SIMONE APARECIDA REIS DE SOUZA', 5, 'Rua Lauro Zimerman Filho', 200),
(10, 'CRECHE CASA DA AMIZADE', 5, 'Rua Artur Silvino dos Reis', 63),
(11, 'CRECHE MUNICIPAL JOÃO BATISTA DA CRUZ', 5, 'Rua João Carlos Alves', 40),
(12, 'CRECHE MUNICIPAL TEREZINHA MARLENE CORREIA', 5, 'Rua Maria Joaquina Bento', 85),
(13, 'CEI JULIO CORREA DE MELLO', 10, 'Rua Sebastião Schmitz', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `etapa`
--

CREATE TABLE `etapa` (
  `id` int(11) NOT NULL,
  `data_ini` date DEFAULT NULL,
  `data_fin` date DEFAULT NULL,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `etapa`
--

INSERT INTO `etapa` (`id`, `data_ini`, `data_fin`, `descricao`) VALUES
(1, '2020-04-01', '2021-12-31', 'BERÇÁRIO-I'),
(2, '2019-04-01', '2020-03-31', 'BERÇÁRIO-II'),
(3, '2018-04-01', '2019-03-31', 'MATERNAL'),
(4, '2017-04-01', '2018-03-31', 'PRÉ-I');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fila`
--

CREATE TABLE `fila` (
  `id` int(11) NOT NULL,
  `registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `responsavel` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefone` varchar(16) NOT NULL,
  `celular` varchar(16) DEFAULT NULL,
  `bairro_id` int(11) DEFAULT NULL,
  `logradouro` varchar(255) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `nomecrianca` varchar(255) NOT NULL,
  `nascimento` date NOT NULL,
  `certidaonascimento` varchar(50) NOT NULL,
  `deficiencia` varchar(1) NOT NULL DEFAULT '0',
  `opcao1_id` varchar(11) DEFAULT NULL,
  `opcao2_id` varchar(11) DEFAULT NULL,
  `opcao3_id` varchar(11) DEFAULT NULL,
  `opcao_matricula` varchar(11) DEFAULT NULL,  
  `opcao_turno` varchar(20) DEFAULT NULL,
  `turno_matricula` varchar(20) DEFAULT NULL,  
  `observacao` varchar(255) DEFAULT NULL,
  `cpfresponsavel` varchar(15) DEFAULT NULL,
  `protocolo` varchar(255) DEFAULT NULL,  
  `situacao_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_id_fila`
--

CREATE TABLE `historico_id_fila` (
  `id` int(11) NOT NULL,
  `fila_id` int(11) NOT NULL,
  `registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` varchar(255) DEFAULT NULL,  
  `situacao_id` int(11),
  `historico` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `role`
--

CREATE TABLE `role` (
  `id` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `userrole`
--

CREATE TABLE `userrole` (
  `userid` int(11) NOT NULL,
  `roleid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` char(5) DEFAULT 'user',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`,`type`, `created_at`) VALUES
(1, 'Jeandrei', 'jeandreiwalter@gmail.com', '$2y$10$lyyCqzV/cJw5A8TpddC47Ow8K2iVHOHbKl.Nzs0fm/CgjuDBRZoMq','admin','2018-11-23 10:19:18'),
(2, 'teste1', 'teste1r@gmail.com', '$2y$10$Y3Phy8lW7ACZ41qrXjqOjuS26Jzj5WEoWa3mjNrNwWcHpyPKnOtji','user', '2018-11-27 15:29:36'),
(3, 'teste', 'jean.walter@penha.sc.gov.br', '$2y$10$EwxO3Gf78AQdSoVhVf6yxefdZFR2n3ON2w.t9XnyXsZPLJTNXfTGi','user', '2019-01-09 16:46:20');


--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `bairro`
--
ALTER TABLE `bairro`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `situacao`
--
ALTER TABLE `situacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `escola`
--
ALTER TABLE `escola`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `etapa`
--
ALTER TABLE `etapa`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `fila`
--
ALTER TABLE `fila`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `historico_id_fila`
--
ALTER TABLE `historico_id_fila`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `bairro`
--
ALTER TABLE `bairro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

  --
-- AUTO_INCREMENT de tabela `situacao`
--
ALTER TABLE `situacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de tabela `escola`
--
ALTER TABLE `escola`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de tabela `etapa`
--
ALTER TABLE `etapa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de tabela `fila`
--
ALTER TABLE `fila`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `historico_id_fila`
--
ALTER TABLE `historico_id_fila`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
