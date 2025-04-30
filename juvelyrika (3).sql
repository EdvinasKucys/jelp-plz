-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 06:41 PM
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
-- Database: `juvelyrika`
--

-- --------------------------------------------------------

--
-- Table structure for table `atsiliepimas`
--

CREATE TABLE `atsiliepimas` (
  `komentaras` varchar(255) DEFAULT NULL,
  `įvertinimas` int(11) NOT NULL,
  `data` date NOT NULL,
  `id_ATSILIEPIMAS` int(11) NOT NULL,
  `fk_KLIENTASasmens_kodas` varchar(32) NOT NULL,
  `fk_PREKEid` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamintojas`
--

CREATE TABLE `gamintojas` (
  `gamintojo_id` varchar(64) NOT NULL,
  `pavadinimas` varchar(200) NOT NULL,
  `salis` varchar(50) DEFAULT NULL,
  `kontaktai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `gamintojas`
--

INSERT INTO `gamintojas` (`gamintojo_id`, `pavadinimas`, `salis`, `kontaktai`) VALUES
('1', 'gall', 'Kinija', 'gall@gmail.com'),
('2', 'numero uno', 'Kinija', 'gall@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `kategorija`
--

CREATE TABLE `kategorija` (
  `pavadinimas` varchar(50) NOT NULL,
  `aprasymas` varchar(255) DEFAULT NULL,
  `id_KATEGORIJA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `klientas`
--

CREATE TABLE `klientas` (
  `asmens_kodas` varchar(32) NOT NULL,
  `vardas_pavardė` varchar(100) NOT NULL,
  `elpastas` varchar(254) NOT NULL,
  `telefonas` varchar(30) NOT NULL,
  `adresas` varchar(200) NOT NULL,
  `tipas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `klientas`
--

INSERT INTO `klientas` (`asmens_kodas`, `vardas_pavardė`, `elpastas`, `telefonas`, `adresas`, `tipas`) VALUES
('1', 'gan', 'gan@gmail.com', '8227367981', 'Kaunas, studentu 50', 2),
('2', 'gran', 'gran@gmail.com', '8527367981', 'Kaunas, studentu 50', 2);

-- --------------------------------------------------------

--
-- Table structure for table `kliento_tipas`
--

CREATE TABLE `kliento_tipas` (
  `id_kliento_tipas` int(11) NOT NULL,
  `name` char(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `kliento_tipas`
--

INSERT INTO `kliento_tipas` (`id_kliento_tipas`, `name`) VALUES
(1, 'judrinis'),
(2, 'fizinis'),
(556, 'auskarai'),
(5656, 'žiedai');

-- --------------------------------------------------------

--
-- Table structure for table `mokejimas`
--

CREATE TABLE `mokejimas` (
  `mokejimo_id` varchar(64) NOT NULL,
  `suma` float NOT NULL,
  `data` date NOT NULL,
  `busena` int(11) NOT NULL,
  `mokejimo_budas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mokejimo_budas`
--

CREATE TABLE `mokejimo_budas` (
  `id_mokejimo_budas` int(11) NOT NULL,
  `name` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `mokejimo_budas`
--

INSERT INTO `mokejimo_budas` (`id_mokejimo_budas`, `name`) VALUES
(1, 'kredito_kortele'),
(2, 'el.bankininkyste'),
(3, 'grynais');

-- --------------------------------------------------------

--
-- Table structure for table `mokejimo_busena`
--

CREATE TABLE `mokejimo_busena` (
  `id_mokejimo_busena` int(11) NOT NULL,
  `name` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `mokejimo_busena`
--

INSERT INTO `mokejimo_busena` (`id_mokejimo_busena`, `name`) VALUES
(1, 'vykdomas'),
(2, 'sėkmingas'),
(3, 'nepavykes');

-- --------------------------------------------------------

--
-- Table structure for table `preke`
--

CREATE TABLE `preke` (
  `id` varchar(64) NOT NULL,
  `pavadinimas` varchar(200) NOT NULL,
  `aprasymas` varchar(255) DEFAULT NULL,
  `kaina` float NOT NULL,
  `svoris` float NOT NULL,
  `medziaga` varchar(100) DEFAULT NULL,
  `fk_GAMINTOJASgamintojo_id` varchar(64) NOT NULL,
  `fk_KATEGORIJAid_KATEGORIJA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pristatymas`
--

CREATE TABLE `pristatymas` (
  `data` date NOT NULL,
  `pristatymo_budas` int(11) NOT NULL,
  `statusas` int(11) NOT NULL,
  `id_PRISTATYMAS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pristatymo_budas`
--

CREATE TABLE `pristatymo_budas` (
  `id_pristatymo_budas` int(11) NOT NULL,
  `name` char(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `pristatymo_budas`
--

INSERT INTO `pristatymo_budas` (`id_pristatymo_budas`, `name`) VALUES
(1, 'kurjeris'),
(2, 'pastas'),
(3, 'siuntu_terminalas'),
(4, 'atsiimimas_parduotuveje');

-- --------------------------------------------------------

--
-- Table structure for table `pristatymo_statusas`
--

CREATE TABLE `pristatymo_statusas` (
  `id_pristatymo_statusas` int(11) NOT NULL,
  `name` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `pristatymo_statusas`
--

INSERT INTO `pristatymo_statusas` (`id_pristatymo_statusas`, `name`) VALUES
(1, 'pristatytas'),
(2, 'atsauktas'),
(3, 'vykdomas');

-- --------------------------------------------------------

--
-- Table structure for table `sandelis`
--

CREATE TABLE `sandelis` (
  `sandelio_id` varchar(64) NOT NULL,
  `pavadinimas` varchar(100) NOT NULL,
  `adresas` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sandeliuojama_preke`
--

CREATE TABLE `sandeliuojama_preke` (
  `kiekis` int(11) NOT NULL,
  `id_SANDELIUOJAMA_PREKE` int(11) NOT NULL,
  `fk_SANDELISsandelio_id` varchar(64) DEFAULT NULL,
  `fk_PREKEid` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uzsakymas`
--

CREATE TABLE `uzsakymas` (
  `nr` int(11) NOT NULL,
  `data` date NOT NULL,
  `kaina` float NOT NULL,
  `busena` int(11) NOT NULL,
  `fk_PRISTATYMASid_PRISTATYMAS` int(11) NOT NULL,
  `fk_KLIENTASasmens_kodas` varchar(32) NOT NULL,
  `fk_MOKEJIMASmokejimo_id` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uzsakymo_preke`
--

CREATE TABLE `uzsakymo_preke` (
  `kiekis` int(11) NOT NULL,
  `kaina` float NOT NULL,
  `id_UZSAKYMO_PREKE` int(11) NOT NULL,
  `fk_PREKEid` varchar(64) NOT NULL,
  `fk_UZSAKYMASnr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `įvertinimas`
--

CREATE TABLE `įvertinimas` (
  `id_įvertinimas` int(11) NOT NULL,
  `name` char(0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atsiliepimas`
--
ALTER TABLE `atsiliepimas`
  ADD PRIMARY KEY (`id_ATSILIEPIMAS`),
  ADD KEY `palieka` (`fk_KLIENTASasmens_kodas`),
  ADD KEY `ivertina` (`fk_PREKEid`);

--
-- Indexes for table `gamintojas`
--
ALTER TABLE `gamintojas`
  ADD PRIMARY KEY (`gamintojo_id`);

--
-- Indexes for table `kategorija`
--
ALTER TABLE `kategorija`
  ADD PRIMARY KEY (`id_KATEGORIJA`);

--
-- Indexes for table `klientas`
--
ALTER TABLE `klientas`
  ADD PRIMARY KEY (`asmens_kodas`),
  ADD KEY `tipas` (`tipas`);

--
-- Indexes for table `kliento_tipas`
--
ALTER TABLE `kliento_tipas`
  ADD PRIMARY KEY (`id_kliento_tipas`);

--
-- Indexes for table `mokejimas`
--
ALTER TABLE `mokejimas`
  ADD PRIMARY KEY (`mokejimo_id`),
  ADD KEY `busena` (`busena`),
  ADD KEY `mokejimo_budas` (`mokejimo_budas`);

--
-- Indexes for table `mokejimo_budas`
--
ALTER TABLE `mokejimo_budas`
  ADD PRIMARY KEY (`id_mokejimo_budas`);

--
-- Indexes for table `mokejimo_busena`
--
ALTER TABLE `mokejimo_busena`
  ADD PRIMARY KEY (`id_mokejimo_busena`);

--
-- Indexes for table `preke`
--
ALTER TABLE `preke`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gamina` (`fk_GAMINTOJASgamintojo_id`),
  ADD KEY `priklauso` (`fk_KATEGORIJAid_KATEGORIJA`);

--
-- Indexes for table `pristatymas`
--
ALTER TABLE `pristatymas`
  ADD PRIMARY KEY (`id_PRISTATYMAS`),
  ADD KEY `pristatymo_budas` (`pristatymo_budas`),
  ADD KEY `statusas` (`statusas`);

--
-- Indexes for table `pristatymo_budas`
--
ALTER TABLE `pristatymo_budas`
  ADD PRIMARY KEY (`id_pristatymo_budas`);

--
-- Indexes for table `pristatymo_statusas`
--
ALTER TABLE `pristatymo_statusas`
  ADD PRIMARY KEY (`id_pristatymo_statusas`);

--
-- Indexes for table `sandelis`
--
ALTER TABLE `sandelis`
  ADD PRIMARY KEY (`sandelio_id`);

--
-- Indexes for table `sandeliuojama_preke`
--
ALTER TABLE `sandeliuojama_preke`
  ADD PRIMARY KEY (`id_SANDELIUOJAMA_PREKE`),
  ADD KEY `talpina` (`fk_SANDELISsandelio_id`),
  ADD KEY `sudaro` (`fk_PREKEid`);

--
-- Indexes for table `uzsakymas`
--
ALTER TABLE `uzsakymas`
  ADD PRIMARY KEY (`nr`),
  ADD KEY `busena` (`busena`),
  ADD KEY `ikydomas` (`fk_PRISTATYMASid_PRISTATYMAS`),
  ADD KEY `uzsako` (`fk_KLIENTASasmens_kodas`),
  ADD KEY `sumoka` (`fk_MOKEJIMASmokejimo_id`);

--
-- Indexes for table `uzsakymo_preke`
--
ALTER TABLE `uzsakymo_preke`
  ADD PRIMARY KEY (`id_UZSAKYMO_PREKE`),
  ADD KEY `turi` (`fk_PREKEid`),
  ADD KEY `sudarytas_is` (`fk_UZSAKYMASnr`);

--
-- Indexes for table `įvertinimas`
--
ALTER TABLE `įvertinimas`
  ADD PRIMARY KEY (`id_įvertinimas`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `atsiliepimas`
--
ALTER TABLE `atsiliepimas`
  ADD CONSTRAINT `ivertina` FOREIGN KEY (`fk_PREKEid`) REFERENCES `preke` (`id`),
  ADD CONSTRAINT `palieka` FOREIGN KEY (`fk_KLIENTASasmens_kodas`) REFERENCES `klientas` (`asmens_kodas`);

--
-- Constraints for table `klientas`
--
ALTER TABLE `klientas`
  ADD CONSTRAINT `klientas_ibfk_1` FOREIGN KEY (`tipas`) REFERENCES `kliento_tipas` (`id_kliento_tipas`);

--
-- Constraints for table `mokejimas`
--
ALTER TABLE `mokejimas`
  ADD CONSTRAINT `mokejimas_ibfk_1` FOREIGN KEY (`busena`) REFERENCES `mokejimo_busena` (`id_mokejimo_busena`),
  ADD CONSTRAINT `mokejimas_ibfk_2` FOREIGN KEY (`mokejimo_budas`) REFERENCES `mokejimo_budas` (`id_mokejimo_budas`);

--
-- Constraints for table `preke`
--
ALTER TABLE `preke`
  ADD CONSTRAINT `gamina` FOREIGN KEY (`fk_GAMINTOJASgamintojo_id`) REFERENCES `gamintojas` (`gamintojo_id`),
  ADD CONSTRAINT `priklauso` FOREIGN KEY (`fk_KATEGORIJAid_KATEGORIJA`) REFERENCES `kategorija` (`id_KATEGORIJA`);

--
-- Constraints for table `pristatymas`
--
ALTER TABLE `pristatymas`
  ADD CONSTRAINT `pristatymas_ibfk_1` FOREIGN KEY (`pristatymo_budas`) REFERENCES `pristatymo_budas` (`id_pristatymo_budas`),
  ADD CONSTRAINT `pristatymas_ibfk_2` FOREIGN KEY (`statusas`) REFERENCES `pristatymo_statusas` (`id_pristatymo_statusas`);

--
-- Constraints for table `sandeliuojama_preke`
--
ALTER TABLE `sandeliuojama_preke`
  ADD CONSTRAINT `sudaro` FOREIGN KEY (`fk_PREKEid`) REFERENCES `preke` (`id`),
  ADD CONSTRAINT `talpina` FOREIGN KEY (`fk_SANDELISsandelio_id`) REFERENCES `sandelis` (`sandelio_id`);

--
-- Constraints for table `uzsakymas`
--
ALTER TABLE `uzsakymas`
  ADD CONSTRAINT `ikydomas` FOREIGN KEY (`fk_PRISTATYMASid_PRISTATYMAS`) REFERENCES `pristatymas` (`id_PRISTATYMAS`),
  ADD CONSTRAINT `sumoka` FOREIGN KEY (`fk_MOKEJIMASmokejimo_id`) REFERENCES `mokejimas` (`mokejimo_id`),
  ADD CONSTRAINT `uzsako` FOREIGN KEY (`fk_KLIENTASasmens_kodas`) REFERENCES `klientas` (`asmens_kodas`),
  ADD CONSTRAINT `uzsakymas_ibfk_1` FOREIGN KEY (`busena`) REFERENCES `mokejimo_busena` (`id_mokejimo_busena`);

--
-- Constraints for table `uzsakymo_preke`
--
ALTER TABLE `uzsakymo_preke`
  ADD CONSTRAINT `sudarytas_is` FOREIGN KEY (`fk_UZSAKYMASnr`) REFERENCES `uzsakymas` (`nr`),
  ADD CONSTRAINT `turi` FOREIGN KEY (`fk_PREKEid`) REFERENCES `preke` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
