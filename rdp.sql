-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20-Mar-2020 às 20:13
-- Versão do servidor: 10.4.10-MariaDB
-- versão do PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mega`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `rdp`
--

CREATE TABLE `rdp` (
  `id` int(11) NOT NULL,
  `quadro` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `qt` int(11) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `valor` varchar(20) NOT NULL,
  `total` varchar(20) NOT NULL,
  `num_processo` varchar(50) NOT NULL,
  `num_sinistro` varchar(100) NOT NULL,
  `seguradora` varchar(150) NOT NULL,
  `segurado` varchar(150) NOT NULL,
  `transportadora` varchar(150) NOT NULL,
  `id_user` int(11) NOT NULL,
  `dt_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `rdp`
--

INSERT INTO `rdp` (`id`, `quadro`, `type`, `qt`, `descricao`, `valor`, `total`, `num_processo`, `num_sinistro`, `seguradora`, `segurado`, `transportadora`, `id_user`, `dt_cadastro`) VALUES
(1, 1, 'km Ida', 12, 'teste', '2.00', '24.00', '19/1296', 'EstatÃ­stico', 'Allianz Seguros S/A', 'Sotran S/A LogÃ­stica e Transporte', 'Sotran S/A LogÃ­stica e Transporte', 9, '2020-03-20 14:58:38'),
(2, 2, 'Certificado de Vistoria', 1, 'Teste', '260.00', '260.00', '19/1296', 'EstatÃ­stico', 'Allianz Seguros S/A', 'Sotran S/A LogÃ­stica e Transporte', 'Sotran S/A LogÃ­stica e Transporte', 9, '2020-03-20 16:51:16'),
(3, 1, 'km Ida', 1, 'Teste 2', '13.60', '13.60', '19/1296', 'EstatÃ­stico', 'Allianz Seguros S/A', 'Sotran S/A LogÃ­stica e Transporte', 'Sotran S/A LogÃ­stica e Transporte', 9, '2020-03-20 18:48:10');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `rdp`
--
ALTER TABLE `rdp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `rdp`
--
ALTER TABLE `rdp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
