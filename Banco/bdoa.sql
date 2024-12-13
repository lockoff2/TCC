-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2024 at 01:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdoa`
--

-- --------------------------------------------------------

--
-- Table structure for table `aluno`
--

CREATE TABLE `aluno` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `senha` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aluno`
--

INSERT INTO `aluno` (`id`, `nome`, `email`, `cpf`, `senha`) VALUES
(1, 'JORGE GABRIEL PEREIRA STURZA', 'jorgegabrielsturza@gmail.com', '978', '123'),
(2, 'victoria', 'victoria@gmail.com', '1111', '123'),
(3, 'Lucas Leal', 'lucas@gmail.com', '55599922269', '123321');

-- --------------------------------------------------------

--
-- Table structure for table `opcoes`
--

CREATE TABLE `opcoes` (
  `id` int(11) NOT NULL,
  `conteudo` text NOT NULL,
  `resposta` tinyint(1) NOT NULL,
  `questaoid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `opcoes`
--

INSERT INTO `opcoes` (`id`, `conteudo`, `resposta`, `questaoid`) VALUES
(1, '123', 0, 1),
(2, '123', 0, 1),
(3, '123', 0, 1),
(4, '123', 0, 1),
(5, '123', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE `professor` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professor`
--

INSERT INTO `professor` (`id`, `nome`, `cpf`, `email`, `senha`) VALUES
(1, 'Daniel', '123', 'Daniel@gmail.com', '123'),
(2, 'gustavo', '12345', 'gustavo@gmail.com', '123'),
(3, 'teste', '02970588005', 'teste@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `questionario`
--

CREATE TABLE `questionario` (
  `id` int(11) NOT NULL,
  `titulo` varchar(40) NOT NULL,
  `descricao` text DEFAULT NULL,
  `professorid` int(11) NOT NULL,
  `turmaid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questionario`
--

INSERT INTO `questionario` (`id`, `titulo`, `descricao`, `professorid`, `turmaid`) VALUES
(5, 'patas', '123', 1, 5),
(7, 'patas132', 'asd123', 1, 1),
(10, '123', '123', 1, 5),
(11, '123412412', '12331241234231', 1, 3);

--
-- Triggers `questionario`
--
DELIMITER $$
CREATE TRIGGER `delete_questionario_cascade` BEFORE DELETE ON `questionario` FOR EACH ROW BEGIN
  
    DELETE FROM respostaalunos 
    WHERE questaoid IN (
        SELECT id FROM questoes WHERE questionarioid = OLD.id
    );


    DELETE FROM opcoes 
    WHERE questaoid IN (
        SELECT id FROM questoes WHERE questionarioid = OLD.id
    );


    DELETE FROM questoes 
    WHERE questionarioid = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `questoes`
--

CREATE TABLE `questoes` (
  `id` int(11) NOT NULL,
  `titulo` varchar(40) NOT NULL,
  `descricao` text DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `professorid` int(11) NOT NULL,
  `questionarioid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questoes`
--

INSERT INTO `questoes` (`id`, `titulo`, `descricao`, `tipo`, `professorid`, `questionarioid`) VALUES
(1, '123', '123', 1, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `respostaalunos`
--

CREATE TABLE `respostaalunos` (
  `id` int(11) NOT NULL,
  `alunoid` int(11) NOT NULL,
  `questaoid` int(11) NOT NULL,
  `resposta` text NOT NULL,
  `questionarioid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `turma`
--

CREATE TABLE `turma` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `descricao` varchar(40) DEFAULT NULL,
  `professorid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `turma`
--

INSERT INTO `turma` (`id`, `nome`, `descricao`, `professorid`) VALUES
(1, 'teste', NULL, 1),
(3, 'teste3', 'teste3', 1),
(5, 'ads12', '1234124', 1);

--
-- Triggers `turma`
--
DELIMITER $$
CREATE TRIGGER `delete_turma_cascade` BEFORE DELETE ON `turma` FOR EACH ROW BEGIN

    DELETE FROM turmaaluno
    WHERE turmaid = OLD.id;

    DELETE FROM questionario
    WHERE turmaid = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `turmaaluno`
--

CREATE TABLE `turmaaluno` (
  `id` int(11) NOT NULL,
  `alunoid` int(11) NOT NULL,
  `turmaid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `turmaaluno`
--

INSERT INTO `turmaaluno` (`id`, `alunoid`, `turmaid`) VALUES
(3, 1, 3),
(4, 2, 3),
(7, 1, 5),
(8, 2, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Indexes for table `opcoes`
--
ALTER TABLE `opcoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questaoid` (`questaoid`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `questionario`
--
ALTER TABLE `questionario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professorid` (`professorid`),
  ADD KEY `turmaid` (`turmaid`);

--
-- Indexes for table `questoes`
--
ALTER TABLE `questoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professorid` (`professorid`),
  ADD KEY `questionariofkq` (`questionarioid`);

--
-- Indexes for table `respostaalunos`
--
ALTER TABLE `respostaalunos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alunoid` (`alunoid`),
  ADD KEY `questaoid` (`questaoid`),
  ADD KEY `respostaalunos_ibfk_3` (`questionarioid`);

--
-- Indexes for table `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professorid` (`professorid`);

--
-- Indexes for table `turmaaluno`
--
ALTER TABLE `turmaaluno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_fkT` (`alunoid`),
  ADD KEY `turma_fkA` (`turmaid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aluno`
--
ALTER TABLE `aluno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `opcoes`
--
ALTER TABLE `opcoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `questionario`
--
ALTER TABLE `questionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `questoes`
--
ALTER TABLE `questoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `respostaalunos`
--
ALTER TABLE `respostaalunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `turma`
--
ALTER TABLE `turma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `turmaaluno`
--
ALTER TABLE `turmaaluno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `opcoes`
--
ALTER TABLE `opcoes`
  ADD CONSTRAINT `opcoes_ibfk_1` FOREIGN KEY (`questaoid`) REFERENCES `questoes` (`id`);

--
-- Constraints for table `questionario`
--
ALTER TABLE `questionario`
  ADD CONSTRAINT `questionario_ibfk_1` FOREIGN KEY (`professorid`) REFERENCES `professor` (`id`),
  ADD CONSTRAINT `questionario_ibfk_2` FOREIGN KEY (`turmaid`) REFERENCES `turma` (`id`);

--
-- Constraints for table `questoes`
--
ALTER TABLE `questoes`
  ADD CONSTRAINT `questionariofkq` FOREIGN KEY (`questionarioid`) REFERENCES `questionario` (`id`),
  ADD CONSTRAINT `questoes_ibfk_1` FOREIGN KEY (`professorid`) REFERENCES `professor` (`id`);

--
-- Constraints for table `respostaalunos`
--
ALTER TABLE `respostaalunos`
  ADD CONSTRAINT `respostaalunos_ibfk_1` FOREIGN KEY (`alunoid`) REFERENCES `aluno` (`id`),
  ADD CONSTRAINT `respostaalunos_ibfk_2` FOREIGN KEY (`questaoid`) REFERENCES `questoes` (`id`),
  ADD CONSTRAINT `respostaalunos_ibfk_3` FOREIGN KEY (`questionarioid`) REFERENCES `questionario` (`id`);

--
-- Constraints for table `turma`
--
ALTER TABLE `turma`
  ADD CONSTRAINT `turma_ibfk_1` FOREIGN KEY (`professorid`) REFERENCES `professor` (`id`);

--
-- Constraints for table `turmaaluno`
--
ALTER TABLE `turmaaluno`
  ADD CONSTRAINT `aluno_fkT` FOREIGN KEY (`alunoid`) REFERENCES `aluno` (`id`),
  ADD CONSTRAINT `turma_fkA` FOREIGN KEY (`turmaid`) REFERENCES `turma` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
