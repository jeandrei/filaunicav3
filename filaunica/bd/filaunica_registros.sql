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


-- --------------------------------------------------------



--
-- Despejando dados para a tabela `fila`
--

INSERT INTO `fila` (`id`, `registro`, `responsavel`, `email`, `telefone`, `celular`, `bairro_id`, `logradouro`, `numero`, `complemento`, `nomecrianca`, `nascimento`, `certidaonascimento`, `deficiencia`, `opcao1_id`, `opcao2_id`, `opcao3_id`, `opcao_turno`, `observacao`, `cpfresponsavel`, `protocolo`) VALUES
(1, '2019-11-05 17:32:00', '	 Vânia Cardoso 	', NULL, '	98426-3516	', NULL, NULL, NULL, NULL, NULL, '	Paula pyetra Cardoso reinert 	', '2017-06-20', '	109	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '12020'),
(2, '2019-11-13 12:38:00', '	 Elisangela Teodoro Correia 	', NULL, '	3398-6049 	', NULL, NULL, NULL, NULL, NULL, '	Mariana Vitória Correia 	', '2018-11-04', '	1	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '22020'),
(3, '2019-11-13 19:29:00', '	 Nergelande Coleus 	', NULL, '	99720-0015	', NULL, NULL, NULL, NULL, NULL, '	Daniel Marseille 	', '2019-10-22', '	2	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '32020'),
(4, '2019-11-18 21:36:00', '	 Suerica de Oliveira dos Santos 	', NULL, '	99193-6240	', NULL, NULL, NULL, NULL, NULL, '	Calebe Oliveira dos Santos 	', '2019-11-18', '	3	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '42020'),
(5, '2019-11-26 16:18:00', '	 PALOMA APARECIDA PONTES DIAS 	', NULL, '	99615-3296	', NULL, NULL, NULL, NULL, NULL, '	JOAQUIM PONTES DE NOVAIS 	', '2019-06-04', '	4	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '52020'),
(6, '2019-11-27 02:09:00', '	 Adriana Fortunato Possidonio 	', NULL, '	3345-3980 	', NULL, NULL, NULL, NULL, NULL, '	Alícia Fortunato 	', '2018-12-21', '	5	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '62020'),
(7, '2019-11-28 15:23:00', '	 Monica Camargo 	', NULL, '	9716-9623 	', NULL, NULL, NULL, NULL, NULL, '	Megan Camargo Machado 	', '2018-09-22', '	6	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '72020'),
(8, '2019-11-29 13:26:00', '	 MARIA EDUARDA NUNES DE SOUZA 	', NULL, '	99658-4853	', NULL, NULL, NULL, NULL, NULL, '	BRAYAN ALEKSANDER DE SOUZA 	', '2017-09-05', '	110	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '82020'),
(9, '2019-11-29 16:08:00', '	 EDUARDA DOS SANTOS DE SOUZA 	', NULL, '	99606-7889	', NULL, NULL, NULL, NULL, NULL, '	HELOÍSA DOS SANTOS 	', '2018-03-02', '	7	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '92020'),
(10, '2019-12-01 17:13:00', '	 Monalisa de Jesus de Oliveira 	', NULL, '	99757-4099	', NULL, NULL, NULL, NULL, NULL, '	LEBRON JESUS OLIVEIRA MERILAS 	', '2017-07-15', '	111	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '102020'),
(11, '2019-12-02 15:53:00', '	 Janaina Pereira 	', NULL, '	9848-3034 	', NULL, NULL, NULL, NULL, NULL, '	Esther Pereira Ramalho 	', '2017-08-15', '	112	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '112020'),
(12, '2019-12-02 16:03:00', '	 Cássia Regina de Camargo Oliveira 	', NULL, '	99659-2950	', NULL, NULL, NULL, NULL, NULL, '	Bernardo de Oliveira 	', '2017-05-11', '	113	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '122020'),
(13, '2019-12-02 16:24:00', '	 PRISCILA VIEIRA PAVAO 	', NULL, '	99227-8993	', NULL, NULL, NULL, NULL, NULL, '	HUDSON MIGUEL VIEIRA PAVAO 	', '2019-07-29', '	8	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '132020'),
(14, '2019-12-02 17:02:00', '	 Milene 	', NULL, '	9235-1989 	', NULL, NULL, NULL, NULL, NULL, '	Rebeca maiara de souza Santos 	', '2018-08-05', '	9	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '142020'),
(15, '2019-12-03 14:20:00', '	 carolina andrea parra valdivia 	', NULL, '	99910-4449	', NULL, NULL, NULL, NULL, NULL, '	matheus felipe valdivia 	', '2019-02-27', '	10	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '152020'),
(16, '2019-12-03 14:24:00', '	 ana carolina franco albino 	', NULL, '	99910-4449	', NULL, NULL, NULL, NULL, NULL, '	lorenzo albino martins 	', '2018-04-05', '	11	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '162020'),
(17, '2019-12-04 10:49:00', '	 Ekaterina Smirnova 	', NULL, '	99725-6694	', NULL, NULL, NULL, NULL, NULL, '	Helena Smirnova 	', '2017-11-12', '	114	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '172020'),
(18, '2019-12-05 09:32:00', '	 Patricia Xavier 	', NULL, '	99667-6424	', NULL, NULL, NULL, NULL, NULL, '	Amanda Xavier Provesi 	', '2018-03-27', '	12	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '182020'),
(19, '2019-12-05 19:17:00', '	 Rosangela Teixeira 	', NULL, '	99626-2494	', NULL, NULL, NULL, NULL, NULL, '	Heryka da Cunha 	', '2018-02-15', '	115	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '192020'),
(20, '2019-12-06 12:40:00', '	 JENIFER DE AGUIAR ANSELMO 	', NULL, '	98911-7801	', NULL, NULL, NULL, NULL, NULL, '	LIVIA ANSELMO FONSECA 	', '2017-06-27', '	116	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '202020'),
(21, '2019-12-06 15:04:00', '	 joice furlaneto leite 	', NULL, '	3398-1675 	', NULL, NULL, NULL, NULL, NULL, '	Angélica Furlaneto Leite 	', '2017-09-01', '	117	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '212020'),
(22, '2019-12-06 19:59:00', '	 Aline Ranghett 	', NULL, '	99198-6302	', NULL, NULL, NULL, NULL, NULL, '	Gabriel Schumacker da Silva 	', '2019-01-02', '	13	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '222020'),
(23, '2019-12-08 18:28:00', '	 mayara flores da luz 	', NULL, '	9292-7431 	', NULL, NULL, NULL, NULL, NULL, '	cecília da luz 	', '2017-10-10', '	118	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '232020'),
(24, '2019-12-09 10:24:00', '	 EDINEIA TEIXEIRA NUNES 	', NULL, '	99636-2990	', NULL, NULL, NULL, NULL, NULL, '	AGATHA ISABELY NUNES DE SOUZA 	', '2019-10-17', '	14	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '242020'),
(25, '2019-12-09 10:31:00', '	 EDINEIA TEIXEIRA NUNES 	', NULL, '	99636-2990	', NULL, NULL, NULL, NULL, NULL, '	LEANDRO JOSEPH NUNES DE SOUZA 	', '2017-03-25', '	119	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '252020'),
(26, '2019-12-10 09:36:00', '	 ELAINE CRISTINA GODRI DA LUZ ROMAO 	', NULL, '	99133-3083	', NULL, NULL, NULL, NULL, NULL, '	ANTONELLA SCHWARTZ ROMAO 	', '2018-07-23', '	15	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '262020'),
(27, '2019-12-10 14:40:00', '	 RENATA DE SOUZA MARQUES 	', NULL, '	99166-6564	', NULL, NULL, NULL, NULL, NULL, '	ROBERTA DE SOUZA MARQUES 	', '2019-08-04', '	16	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '272020'),
(28, '2019-12-10 19:23:00', '	 Walnice Branco Jorge 	', NULL, '	99604-2414	', NULL, NULL, NULL, NULL, NULL, '	Bryan Da Silveira 	', '2019-07-15', '	17	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '282020'),
(29, '2019-12-11 18:23:00', '	 Luana Manfroi 	', NULL, '	3342-4025 	', NULL, NULL, NULL, NULL, NULL, '	Dylan Manfroi Mianes 	', '2018-03-03', '	18	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '292020'),
(30, '2019-12-15 20:06:00', '	 Luciana de Oliveira Carvalho 	', NULL, '	99701-7737	', NULL, NULL, NULL, NULL, NULL, '	Anne de Carvalho Camargo 	', '2017-07-04', '	120	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '302020'),
(31, '2019-12-19 09:46:00', '	 DAIANE MARIA BENTO 	', NULL, '	99107-3473	', NULL, NULL, NULL, NULL, NULL, '	VYCTOR MYSAEL VIEIRA 	', '2017-06-23', '	121	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '312020'),
(32, '2019-12-19 14:55:00', '	 Franciele dos santos fiorin 	', NULL, '	3342-7873 	', NULL, NULL, NULL, NULL, NULL, '	Hagatha Monaliza Fiorin Pereira 	', '2019-01-29', '	19	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '322020'),
(33, '2019-12-19 14:59:00', '	 Eliania Maria Costa de Souza 	', NULL, '	99715-0841	', NULL, NULL, NULL, NULL, NULL, '	João Arthur Lima de Souza 	', '2019-08-19', '	20	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '332020'),
(34, '2019-12-30 11:42:00', '	 Janaina Pereira 	', NULL, '	98483-0340	', NULL, NULL, NULL, NULL, NULL, '	Isabella Pereira Ramalho 	', '2019-08-19', '	21	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '342020'),
(35, '2019-12-30 16:13:00', '	 Jovana Demarch 	', NULL, '	99128-4777	', NULL, NULL, NULL, NULL, NULL, '	Emanuel José Demarch 	', '2019-07-12', '	0	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '352020'),
(36, '2020-01-06 16:16:00', '	 Patricia Antunes da Luz de Souza 	', NULL, '	99755-8306	', NULL, NULL, NULL, NULL, NULL, '	Helena Vitória Antunes da Luz de Souza 	', '2018-05-13', '	22	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '362020'),
(37, '2020-01-06 18:08:00', '	 marcia reinert 	', NULL, '	98482-2805	', NULL, NULL, NULL, NULL, NULL, '	henrique gabriel reinert dos santos 	', '2019-01-15', '	23	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '372020'),
(38, '2020-01-07 11:07:00', '	 Rosiane Adelina Celista 	', NULL, '	99661-8279	', NULL, NULL, NULL, NULL, NULL, '	José Anthony de Lira 	', '2019-10-05', '	24	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '382020'),
(39, '2020-01-07 11:37:00', '	 Crislaine Kelly da Silva Baptista 	', NULL, '	98830-8286	', NULL, NULL, NULL, NULL, NULL, '	Lorena Baptista da Silva 	', '2018-10-02', '	25	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '392020'),
(40, '2020-01-07 16:43:00', '	 KAUANA CUBAS 	', NULL, '	99608-2440	', NULL, NULL, NULL, NULL, NULL, '	ELOAH SCHNEIDER 	', '2018-06-20', '	26	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '402020'),
(41, '2020-01-07 20:47:00', '	 LUCIANA PETROSKI 	', NULL, '	8828-2139 	', NULL, NULL, NULL, NULL, NULL, '	EMANUEL ANACLETO 	', '2018-03-09', '	27	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '412020'),
(42, '2020-01-08 13:08:00', '	 itamara carla gouveia da silva 	', NULL, '	99626-8279	', NULL, NULL, NULL, NULL, NULL, '	Thaina da silva salvador 	', '2018-10-19', '	28	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '422020'),
(43, '2020-01-08 15:12:00', '	 VANESSA CAMPOS PAES CARNEIRO 	', NULL, '	98493-2624	', NULL, NULL, NULL, NULL, NULL, '	MILENA CAMPOS DOMINGOS 	', '2019-09-28', '	29	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '432020'),
(44, '2020-01-08 16:14:00', '	0/1/1900	', NULL, '	99268-7405	', NULL, NULL, NULL, NULL, NULL, '	ALICE ISABELLA DE LIMA SOUZA 	', '2019-04-24', '	30	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '442020'),
(45, '2020-01-09 17:38:00', '	 KARLA MACCARI FERMINO FIGUEIREDO 	', NULL, '	3345-2726 	', NULL, NULL, NULL, NULL, NULL, '	ELOÁ MACCARI FERMINO FIGUEIREDO 	', '2018-10-18', '	31	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '452020'),
(46, '2020-01-09 17:39:00', '	 TATIANA CAROLINA COSTA SANTANA 	', NULL, '	99119-5152	', NULL, NULL, NULL, NULL, NULL, '	kaio yude santana bezerra 	', '2017-08-16', '	122	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '462020'),
(47, '2020-01-09 18:13:00', '	 Bruna Aparecida Martins Prado 	', NULL, '	99260-5064	', NULL, NULL, NULL, NULL, NULL, '	Pietro Martins Benete 	', '2018-10-07', '	32	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '472020'),
(48, '2020-01-10 09:10:00', '	 Geane Jacob da Silva 	', NULL, '	9968-4738 	', NULL, NULL, NULL, NULL, NULL, '	Théo Lucca de Andrades 	', '2019-06-16', '	33	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '482020'),
(49, '2020-01-10 11:15:00', '	 daniele dos santos de souza 	', NULL, '	99633-6201	', NULL, NULL, NULL, NULL, NULL, '	Miguel Natanael Berdardo De Souza 	', '2019-11-10', '	34	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '492020'),
(50, '2020-01-10 17:29:00', '	 Aline Capraro Espindola 	', NULL, '	99682-9042	', NULL, NULL, NULL, NULL, NULL, '	Lívia Capraro Espindola 	', '2017-12-04', '	123	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '502020'),
(51, '2020-01-11 09:21:00', '	 Thaís Regina da Silva 	', NULL, '	99951-8537	', NULL, NULL, NULL, NULL, NULL, '	Álvaro da Silva Fraga 	', '2019-11-28', '	35	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '512020'),
(52, '2020-01-11 15:32:00', '	 Francine Verissimo Adão Emmerich 	', NULL, '	98849-2602	', NULL, NULL, NULL, NULL, NULL, '	Davi Verissimo Emmerich 	', '2017-03-21', '	124	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '522020'),
(53, '2020-01-13 12:29:00', '	 Damares carvavalho de jesus 	', NULL, '	98841-4804	', NULL, NULL, NULL, NULL, NULL, '	LUIZ HENRIQUE CARVALHO MARIANA 	', '2019-09-18', '	36	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '532020'),
(54, '2020-01-13 15:37:00', '	 Vanessa valcaringhi 	', NULL, '	98423-5153	', NULL, NULL, NULL, NULL, NULL, '	Annalú Valcaringhi Possamai 	', '2019-04-03', '	37	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '542020'),
(55, '2020-01-13 15:38:00', '	 cintia mara moser dos anjos 	', NULL, '	99913-1703	', NULL, NULL, NULL, NULL, NULL, '	helena mackenzie dos anjos 	', '2019-12-12', '	38	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '552020'),
(56, '2020-01-13 18:17:00', '	 ERIKA REGINA VIEIRA DE OLIVEIRA 	', NULL, '	99999-4003	', NULL, NULL, NULL, NULL, NULL, '	MARIA EMILIA VIEIRA 	', '2019-10-30', '	39	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '562020'),
(57, '2020-01-14 09:55:00', '	 JANAINA CRISPIM DA VEIGA 	', NULL, '	3342-0435 	', NULL, NULL, NULL, NULL, NULL, '	PIETRO CRISPIM FANTINEL 	', '2018-01-18', '	125	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '572020'),
(58, '2020-01-14 13:50:00', '	 ariana gomes 	', NULL, '	99282-7653	', NULL, NULL, NULL, NULL, NULL, '	~samuel fernando de souza 	', '2017-03-02', '	126	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '582020'),
(59, '2020-01-14 17:47:00', '	 Vanessa Souza de Negreiros 	', NULL, '	99111-6946	', NULL, NULL, NULL, NULL, NULL, '	Gabriele vitoria dos Santos Negreiros 	', '2018-11-23', '	40	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '592020'),
(60, '2020-01-15 09:54:00', '	 Ingraca maria da costa 	', NULL, '	3348-7968 	', NULL, NULL, NULL, NULL, NULL, '	Alice Maria Sporny 	', '2017-10-03', '	127	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '602020'),
(61, '2020-01-15 12:37:00', '	0/1/1900	', NULL, '	99677-1825	', NULL, NULL, NULL, NULL, NULL, '	NATHAN ADLER NELCY 	', '2019-10-12', '	41	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '612020'),
(62, '2020-01-15 14:00:00', '	 michelle shaiane nunes 	', NULL, '	99684-8876	', NULL, NULL, NULL, NULL, NULL, '	nikolas gabriel nunes dos reis 	', '2019-07-17', '	42	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '622020'),
(63, '2020-01-15 18:59:00', '	 Giselly de Freitas Castro 	', NULL, '	7440-1235 	', NULL, NULL, NULL, NULL, NULL, '	Elise de Freitas Miranda 	', '2018-04-24', '	43	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '632020'),
(64, '2020-01-15 19:07:00', '	 Raianne de Freitas Castro 	', NULL, '	97305-8359	', NULL, NULL, NULL, NULL, NULL, '	Joao Pedro Gomes Freitas 	', '2018-06-11', '	44	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '642020'),
(65, '2020-01-15 22:56:00', '	 JESSICA DOS SANTOS NUNES 	', NULL, '	99254-2700	', NULL, NULL, NULL, NULL, NULL, '	MARIA EDUARDA NUNES NORONHA 	', '2017-12-15', '	128	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '652020'),
(66, '2020-01-16 10:00:00', '	 MICHELLE KARINA DE SOUZA 	', NULL, '	99150-9720	', NULL, NULL, NULL, NULL, NULL, '	MATEUS JOÃO PAULINA 	', '2019-01-04', '	45	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '662020'),
(67, '2020-01-16 12:59:00', '	 Marcia Maria Volpato de Mattos 	', NULL, '	3345-8436 	', NULL, NULL, NULL, NULL, NULL, '	Marcos Paulo Volpato de Mattos 	', '2018-08-31', '	46	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '672020'),
(68, '2020-01-16 14:07:00', '	 AMANDA PELOIA 	', NULL, '	98488-9790	', NULL, NULL, NULL, NULL, NULL, '	FERNANDO PELOIA STEFANI 	', '2019-06-23', '	47	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '682020'),
(69, '2020-01-16 14:53:00', '	 Bruna Adriana Cardoso 	', NULL, '	9288-9016 	', NULL, NULL, NULL, NULL, NULL, '	Nathaniel Cardoso Sutil 	', '2019-02-01', '	48	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '692020'),
(70, '2020-01-16 15:49:00', '	 Luana de Oliveira Metzger 	', NULL, '	98474-2462	', NULL, NULL, NULL, NULL, NULL, '	Helena Flor de Oliveira Maçaneiro 	', '2018-08-29', '	49	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '702020'),
(71, '2020-01-16 17:28:00', '	 Aline Maria Siqueira 	', NULL, '	99150-0889	', NULL, NULL, NULL, NULL, NULL, '	estefania margarete siqueira hang 	', '2018-01-23', '	50	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '712020'),
(72, '2020-01-16 18:45:00', '	 Dhenifer Aline Da Silva 	', NULL, '	99119-8947	', NULL, NULL, NULL, NULL, NULL, '	Ana Alice da Silva pinto 	', '2018-12-26', '	51	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '722020'),
(73, '2020-01-16 19:34:00', '	 Maria Carolina Lima De Almeida 	', NULL, '	99289-2063	', NULL, NULL, NULL, NULL, NULL, '	Thayla Manuelli Vieira Lima 	', '2018-11-12', '	52	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '732020'),
(74, '2020-01-16 20:02:00', '	 Beatriz Ferreira de Souza 	', NULL, '	9914-3230 	', NULL, NULL, NULL, NULL, NULL, '	Miguel Augusto de Souza Correa 	', '2019-04-28', '	53	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '742020'),
(75, '2020-01-17 15:30:00', '	 LUIZA CARLA NUNES TEIXEIRA 	', NULL, '	3360-8432 	', NULL, NULL, NULL, NULL, NULL, '	MARIA LUIZA TEIXEIRA CIRINEU 	', '2018-01-10', '	129	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '752020'),
(76, '2020-01-17 15:36:00', '	 Suzana Cardoso Alexandre 	', NULL, '	99925-1072	', NULL, NULL, NULL, NULL, NULL, '	Luiz Gustavo Cardoso dos Santos 	', '2020-01-17', '	54	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '762020'),
(77, '2020-01-17 16:04:00', '	 Luciane Schutter Mafra 	', NULL, '	99687-4470	', NULL, NULL, NULL, NULL, NULL, '	Helena Schutter Mafra 	', '2019-02-20', '	55	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '772020'),
(78, '2020-01-18 10:38:00', '	 JESSICA DAYANE DE OLIVEIRA CARVALHO 	', NULL, '	99215-0929	', NULL, NULL, NULL, NULL, NULL, '	THÉO GABRIEL CORREIA CARVALHO 	', '2018-07-10', '	56	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '782020'),
(79, '2020-01-20 11:49:00', '	 pamela joelma de oliveira balduino 	', NULL, '	99213-8838	', NULL, NULL, NULL, NULL, NULL, '	SERGIO EMANOEL CARVALHO 	', '2018-05-17', '	57	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '792020'),
(80, '2020-01-20 12:38:00', '	0/1/1900	', NULL, '	3345-0084 	', NULL, NULL, NULL, NULL, NULL, '	Perolla Magally de Sousa 	', '2018-12-04', '	58	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '802020'),
(81, '2020-01-20 13:51:00', '	 ROULIA COULANGES 	', NULL, '	99951-2099	', NULL, NULL, NULL, NULL, NULL, '	NATHAN ADLER NELCY 	', '2019-10-12', '	59	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '812020'),
(82, '2020-01-20 14:04:00', '	 Sandrieli Telles da Silva 	', NULL, '	99734-6680	', NULL, NULL, NULL, NULL, NULL, '	Henrique Gabriel Da Silva Bento 	', '2019-04-17', '	60	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '822020'),
(83, '2020-01-20 15:24:00', '	 tainara fernandes pascoal 	', NULL, '	99294-3159	', NULL, NULL, NULL, NULL, NULL, '	Daniel Batista da Silva Fernandes 	', '2019-07-13', '	61	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '832020'),
(84, '2020-01-20 15:34:00', '	 LYANDRA SOUZA SILVEIRA 	', NULL, '	99935-6579	', NULL, NULL, NULL, NULL, NULL, '	SAID JUMA LUGOGO NETO 	', '2018-11-26', '	62	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '842020'),
(85, '2020-01-20 16:11:00', '	 MARINES IRMA DA SILVA 	', NULL, '	99271-8236	', NULL, NULL, NULL, NULL, NULL, '	ESTER CRISTINA DE SOUZA 	', '2019-09-28', '	63	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '852020'),
(86, '2020-01-20 18:50:00', '	 Thayna Gabriela Alves 	', NULL, '	99910-0380	', NULL, NULL, NULL, NULL, NULL, '	Luiz Henrique Wilbert 	', '2019-05-06', '	64	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '862020'),
(87, '2020-01-21 01:16:00', '	 Josiane Schmitt Euriques Provesi 	', NULL, '	99972-8742	', NULL, NULL, NULL, NULL, NULL, '	Laura Provesi 	', '2019-02-19', '	65	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '872020'),
(88, '2020-01-21 08:02:00', '	 JAILA SOARES 	', NULL, '	99147-0548	', NULL, NULL, NULL, NULL, NULL, '	LORENA SOARES 	', '2019-12-19', '	66	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '882020'),
(89, '2020-01-21 08:27:00', '	 FATIMA LIRACI DOS SANTOS 	', NULL, '	99103-4941	', NULL, NULL, NULL, NULL, NULL, '	ÉVILYN LAVÍNIA DOS SANTOS 	', '2019-10-31', '	67	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '892020'),
(90, '2020-01-21 09:06:00', '	 MARILENE ANACLETO TOMAZ 	', NULL, '	99117-0135	', NULL, NULL, NULL, NULL, NULL, '	MARIA ISABEL IDALINA 	', '2018-11-06', '	68	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '902020'),
(91, '2020-01-21 11:58:00', '	 CAMILA DA SILVA 	', NULL, '	9657-6960 	', NULL, NULL, NULL, NULL, NULL, '	LORENZO LUZ 	', '2019-03-21', '	69	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '912020'),
(92, '2020-01-21 15:22:00', '	 bruna angelica rodrigues 	', NULL, '	99108-2124	', NULL, NULL, NULL, NULL, NULL, '	mateus rodrigues castro 	', '2019-09-18', '	70	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '922020'),
(93, '2020-01-21 20:48:00', '	 Talita Vicente Anacleto 	', NULL, '	3345-5310 	', NULL, NULL, NULL, NULL, NULL, '	Lavínia Macedo 	', '2019-07-28', '	71	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '932020'),
(94, '2020-01-22 11:39:00', '	 MARIANE REGINA BERNARDO 	', NULL, '	99160-7786	', NULL, NULL, NULL, NULL, NULL, '	NATHAN BERNARDO VICTORINO 	', '2018-09-28', '	72	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '942020'),
(95, '2020-01-22 12:07:00', '	 Célia Vergilino 	', NULL, '	99664-1085	', NULL, NULL, NULL, NULL, NULL, '	Heloysa Vitória Alves 	', '2018-11-01', '	73	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '952020'),
(96, '2020-01-22 15:37:00', '	 sandrieli telles da silva 	', NULL, '	3345-0809 	', NULL, NULL, NULL, NULL, NULL, '	Henrique Gabriel Da Silva Bento 	', '2019-04-17', '	74	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '962020'),
(97, '2020-01-22 17:27:00', '	 Larissa Sousa Gomes Oliveira 	', NULL, '	98175-5951	', NULL, NULL, NULL, NULL, NULL, '	Cristal da Lua Gomes da Silva 	', '2019-01-15', '	75	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '972020'),
(98, '2020-01-23 15:04:00', '	 bruna angelica rodrigues 	', NULL, '	99108-2124	', NULL, NULL, NULL, NULL, NULL, '	mateus rodrigues castro 	', '2019-09-23', '	76	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '982020'),
(99, '2020-01-24 10:00:00', '	 Thais Solange Galvão 	', NULL, '	99712-1571	', NULL, NULL, NULL, NULL, NULL, '	Yasmin Galvão Peniche 	', '2018-04-06', '	77	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '992020'),
(100, '2020-01-24 15:12:00', '	 Iana Carla Pinto Santos 	', NULL, '	3361-9703 	', NULL, NULL, NULL, NULL, NULL, '	Sofia Santos 	', '2017-06-02', '	130	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1002020'),
(101, '2020-01-25 00:01:00', '	 Pablícia de Araujo Porcincula 	', NULL, '	98844-1967	', NULL, NULL, NULL, NULL, NULL, '	Esther Porcincula de Brito 	', '2017-08-11', '	131	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1012020'),
(102, '2020-01-25 12:37:00', '	 Leonela de Sousa Nascimento Romão 	', NULL, '	99663-0124	', NULL, NULL, NULL, NULL, NULL, '	Maria Rita Nascimento Romão 	', '2017-09-06', '	132	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1022020'),
(103, '2020-01-25 14:04:00', '	 Jenifer Aline da Cunha Gums 	', NULL, '	99860-9826	', NULL, NULL, NULL, NULL, NULL, '	Joaquim da Cunha Gums 	', '2019-05-08', '	78	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1032020'),
(104, '2020-01-26 15:15:00', '	 rute de fatima reimer 	', NULL, '	99955-0986	', NULL, NULL, NULL, NULL, NULL, '	joão vitor reimer 	', '2017-08-22', '	133	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1042020'),
(105, '2020-01-27 12:44:00', '	 ROSIMERE PEREIRA DE ANDRADE 	', NULL, '	98488-8255	', NULL, NULL, NULL, NULL, NULL, '	EMANUELY DE ANDRADE DOMINGUES 	', '2017-11-03', '	134	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1052020'),
(106, '2020-01-27 12:54:00', '	 GISLAINE GAMBA 	', NULL, '	99213-4489	', NULL, NULL, NULL, NULL, NULL, '	SARA EUNICE GAMBA LONGEN 	', '2017-03-14', '	135	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1062020'),
(107, '2020-01-27 13:33:00', '	 KASSIELE FRANCINE DA SILVA 	', NULL, '	3345-5060 	', NULL, NULL, NULL, NULL, NULL, '	LORENZO COSTA 	', '2019-08-14', '	79	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1072020'),
(108, '2020-01-27 13:44:00', '	 Jeniffer Pereira da Silva 	', NULL, '	3319-3622 	', NULL, NULL, NULL, NULL, NULL, '	lucas emanuel da silva 	', '2017-07-11', '	136	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1082020'),
(109, '2020-01-27 14:46:00', '	 BARBARA DOMECIANO PARRADO 	', NULL, '	99275-9066	', NULL, NULL, NULL, NULL, NULL, '	DAVI JONATAN SCHUTTEL 	', '2017-04-14', '	137	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1092020'),
(110, '2020-01-27 15:45:00', '	 Patricia de Andrade Novak Pereira 	', NULL, '	99918-3256	', NULL, NULL, NULL, NULL, NULL, '	Marina Novak Pereira 	', '2018-04-23', '	80	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1102020'),
(111, '2020-01-27 15:48:00', '	 PRISCILA FLORES BRUCALE 	', NULL, '	99245-0036	', NULL, NULL, NULL, NULL, NULL, '	BERNARDO BRUCALE 	', '2019-03-19', '	81	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1112020'),
(112, '2020-01-27 17:42:00', '	 JAQUELINE JACOBI DA LUZ 	', NULL, '	98411-3011	', NULL, NULL, NULL, NULL, NULL, '	PIETRA JACOBI DA LUZ 	', '2019-07-15', '	82	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1122020'),
(113, '2020-01-27 18:25:00', '	 Daniela de Abreu Pacheco 	', NULL, '	3398-3113 	', NULL, NULL, NULL, NULL, NULL, '	Ana Laura Pacheco Costa 	', '2018-07-18', '	83	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1132020'),
(114, '2020-01-27 18:26:00', '	 LIANDRA PINHEIRO RITA 	', NULL, '	99694-5983	', NULL, NULL, NULL, NULL, NULL, '	Miguel Henrique Pinheiro Rita 	', '2018-11-15', '	84	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1142020'),
(115, '2020-01-27 19:22:00', '	 Ediani Bento 	', NULL, '	3319-3488 	', NULL, NULL, NULL, NULL, NULL, '	Bernardo Ladewig 	', '2018-06-28', '	85	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1152020'),
(116, '2020-01-28 09:30:00', '	 LISIANE NUNES FERNANDES 	', NULL, '	99156-8257	', NULL, NULL, NULL, NULL, NULL, '	EMANUEL NUNES BITENCOURT 	', '2019-08-19', '	86	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1162020'),
(117, '2020-01-28 09:42:00', '	 tatiana carolina costa santana 	', NULL, '	99292-4347	', NULL, NULL, NULL, NULL, NULL, '	kaio yude santana bezerra 	', '2017-08-16', '	138	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1172020'),
(118, '2020-01-28 13:56:00', '	 Graziela Jasper 	', NULL, '	99693-1717	', NULL, NULL, NULL, NULL, NULL, '	Adryan Jasper Girardi 	', '2018-02-12', '	139	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1182020'),
(119, '2020-01-28 15:25:00', '	 ADRIANA APARECIDA OLIVEIRA SANTAREM DOS SANTOS	', NULL, '	99251-6211	', NULL, NULL, NULL, NULL, NULL, '	Lorenzo Pietro Oliveira dos Santos 	', '2017-03-04', '	140	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1192020'),
(120, '2020-01-28 15:55:00', '	 Evelin Karine Leal Dos Santos Borges 	', NULL, '	3319-1050 	', NULL, NULL, NULL, NULL, NULL, '	Heitor Leal Borges 	', '2019-01-25', '	87	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1202020'),
(121, '2020-01-28 17:34:00', '	 pamela da silva oliveira 	', NULL, '	99686-8360	', NULL, NULL, NULL, NULL, NULL, '	emily maisa oliveira pereira 	', '2019-07-17', '	88	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1212020'),
(122, '2020-01-28 17:58:00', '	 PATRICIA PERES GONCALVES 	', NULL, '	99273-2997	', NULL, NULL, NULL, NULL, NULL, '	JONATHAN DAVI GONCALVES PERES 	', '2020-01-07', '	89	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1222020'),
(123, '2020-01-28 18:22:00', '	 Barbara Mendes Clariano da Silva 	', NULL, '	99660-0502	', NULL, NULL, NULL, NULL, NULL, '	Ana Lívia Mendes de Oliveira 	', '2018-11-25', '	90	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1232020'),
(124, '2020-01-28 20:09:00', '	 Elaine Cristina da Silva Souza 	', NULL, '	3319-1578 	', NULL, NULL, NULL, NULL, NULL, '	Gabriel da Silva Souza 	', '2019-03-08', '	91	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1242020'),
(125, '2020-01-29 08:20:00', '	 Larissa Pinheiro Fernandes 	', NULL, '	99130-6265	', NULL, NULL, NULL, NULL, NULL, '	Benjamin Teylor Padilha 	', '2019-01-03', '	92	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1252020'),
(126, '2020-01-29 09:05:00', '	 Rebeca Casagrande Portaleoni 	', NULL, '	99186-3108	', NULL, NULL, NULL, NULL, NULL, '	Leo Garrido Casagrande Portaleoni 	', '2019-11-09', '	93	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1262020'),
(127, '2020-01-29 13:16:00', '	 Suzana Cardoso Alexandre 	', NULL, '	99925-1072	', NULL, NULL, NULL, NULL, NULL, '	Luiz Gustavo Cardoso dos Santos 	', '2019-11-29', '	94	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1272020'),
(128, '2020-01-29 15:08:00', '	0/1/1900	', NULL, '	99902-3525	', NULL, NULL, NULL, NULL, NULL, '	kaylaine antonio ramos dos santos 	', '2017-06-26', '	141	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1282020'),
(129, '2020-01-29 15:35:00', '	 julia rosa carneiro berlim 	', NULL, '	99709-2862	', NULL, NULL, NULL, NULL, NULL, '	lucca eduardo santos berlim 	', '2019-08-15', '	95	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1292020'),
(130, '2020-01-29 17:12:00', '	 SASKIA MANNRICH RODRIGUES 	', NULL, '	99150-7655	', NULL, NULL, NULL, NULL, NULL, '	PEDRO MANNRICH MOURA 	', '2017-10-22', '	142	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1302020'),
(131, '2020-01-30 13:26:00', '	Nelsieli de Meira jacobi 	', NULL, '	9223-8688 	', NULL, NULL, NULL, NULL, NULL, '	arthur zimmermann 	', '2017-04-18', '	143	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1312020'),
(132, '2020-01-31 14:01:00', '	 Dalilian de Souaa Felicio 	', NULL, '	3345-2606 	', NULL, NULL, NULL, NULL, NULL, '	Bernardo de Sousa Silvano Felício 	', '2019-11-12', '	96	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1322020'),
(133, '2020-01-31 14:43:00', '	 Juliana De Azevedo Morgan 	', NULL, '	99602-1068	', NULL, NULL, NULL, NULL, NULL, '	Davi Emanuel Morgan 	', '2019-07-16', '	97	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1332020'),
(134, '2020-01-31 16:18:00', '	 Aline Maiara dos Santos de Santana 	', NULL, '	99911-5239	', NULL, NULL, NULL, NULL, NULL, '	Giovana de Santana 	', '2020-01-17', '	98	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1342020'),
(135, '2020-01-31 18:13:00', '	 Gislaine Soares 	', NULL, '	99787-9155	', NULL, NULL, NULL, NULL, NULL, '	gustavo silva 	', '2018-04-10', '	99	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1352020'),
(136, '2020-02-01 10:16:00', '	 JOICE WISBECKI 	', NULL, '	3342-5225 	', NULL, NULL, NULL, NULL, NULL, '	ELOÍSA DA COSTA WISBECKI 	', '2018-11-30', '	100	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1362020'),
(137, '2020-02-02 20:26:00', '	 DILSA DA CONCEIÇAO 	', NULL, '	99995-5286	', NULL, NULL, NULL, NULL, NULL, '	ELOÁ DA CONCEIÇAO SABINO 	', '2019-02-10', '	101	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1372020'),
(138, '2020-02-03 08:22:00', '	 JAQUELINE DA LUZ PEREIRA 	', NULL, '	99289-4558	', NULL, NULL, NULL, NULL, NULL, '	KAYKY FERNANDO DA LUZ ETUR 	', '2019-03-05', '	102	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1382020'),
(139, '2020-02-03 10:40:00', '	fabiane priscila da silva 	', NULL, '	99724-7031	', NULL, NULL, NULL, NULL, NULL, '	DAVI HERMENEGILDO 	', '2017-12-01', '	144	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1392020'),
(140, '2020-02-03 14:58:00', '	 mariaeloyza velloso 	', NULL, '	8418-9446 	', NULL, NULL, NULL, NULL, NULL, '	brayan velloso lamim 	', '2019-01-23', '	103	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1402020'),
(141, '2020-02-03 15:40:00', '	 Leliane Militão da Silva 	', NULL, '	99947-0536	', NULL, NULL, NULL, NULL, NULL, '	Guilherme Henrique da Silva 	', '2020-01-25', '	104	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1412020'),
(142, '2020-02-03 16:17:00', '	 Taylana melek 	', NULL, '	99680-5861	', NULL, NULL, NULL, NULL, NULL, '	Isabelly melek libório 	', '2018-10-09', '	105	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1422020'),
(143, '2020-02-03 16:41:00', '	 Talita Carvalho 	', NULL, '	99906-6225	', NULL, NULL, NULL, NULL, NULL, '	Leonardo Henrique da cunha 	', '2018-09-13', '	106	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1432020'),
(144, '2020-02-03 16:42:00', '	 Maria fabiani rosa 	', NULL, '	99987-0674	', NULL, NULL, NULL, NULL, NULL, '	arthur davi rosa schmidt 	', '2019-01-18', '	107	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1442020'),
(145, '2020-02-03 17:00:00', '	Vanessa Costa da sILVA 	', NULL, '	99229-7367	', NULL, NULL, NULL, NULL, NULL, '	Enrico Costa da Silva 	', '2018-04-26', '	108	', '0', NULL, NULL, NULL, NULL, NULL, NULL, '1452020');

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
