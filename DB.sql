-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 24. Dez 2020 um 13:22
-- Server-Version: 5.5.60-0+deb7u1
-- PHP-Version: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ni1099597_2sql4`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gegner`
--

CREATE TABLE `gegner` (
  `gegnerid` int(11) NOT NULL,
  `gegnername` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `lvl` int(11) NOT NULL,
  `leben` int(11) NOT NULL,
  `angriff` int(11) NOT NULL,
  `geld` int(11) NOT NULL,
  `gegnerbildpfad` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `thema` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `gesperrt` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `konto`
--

CREATE TABLE `konto` (
  `id` int(11) NOT NULL,
  `benutzername` varchar(30) CHARACTER SET utf8 NOT NULL,
  `passwort` text CHARACTER SET utf8 NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `erstellt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token` text CHARACTER SET utf8 COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ereignis` text COLLATE utf8_bin NOT NULL,
  `spieler` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ruestung`
--

CREATE TABLE `ruestung` (
  `ruestungsid` int(11) NOT NULL,
  `ruestungsname` text NOT NULL,
  `ruestungswert` int(11) NOT NULL,
  `geldwert` int(11) NOT NULL,
  `ruestungsbildpfad` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spieler`
--

CREATE TABLE `spieler` (
  `spielername` varchar(30) CHARACTER SET utf8 NOT NULL,
  `lvl` int(11) NOT NULL,
  `erfahrung` int(11) NOT NULL,
  `geld` int(11) NOT NULL,
  `leben` int(11) NOT NULL,
  `maxleben` int(11) NOT NULL,
  `angriff` int(11) NOT NULL,
  `waffenid` int(11) DEFAULT NULL,
  `ruestungsid` int(11) DEFAULT NULL,
  `spielerbildpfad` text CHARACTER SET utf8,
  `rechte` text CHARACTER SET utf8 COLLATE utf8_bin,
  `gesperrt` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `themen`
--

CREATE TABLE `themen` (
  `id` int(11) NOT NULL,
  `themenname` text COLLATE utf8_bin NOT NULL,
  `themenbildpfad` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `traenke`
--

CREATE TABLE `traenke` (
  `trankid` int(11) NOT NULL,
  `trankname` text CHARACTER SET utf8 NOT NULL,
  `trankwert` int(11) NOT NULL,
  `trankwertpermanent` int(11) NOT NULL,
  `geldwert` int(11) NOT NULL,
  `trankbildpfad` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `waffen`
--

CREATE TABLE `waffen` (
  `waffenid` int(11) NOT NULL,
  `waffenname` text CHARACTER SET utf8 NOT NULL,
  `waffenwert` int(11) NOT NULL,
  `geldwert` int(11) NOT NULL,
  `waffenbildpfad` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `gegner`
--
ALTER TABLE `gegner`
  ADD PRIMARY KEY (`gegnerid`);

--
-- Indizes für die Tabelle `konto`
--
ALTER TABLE `konto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `benutzername` (`benutzername`);

--
-- Indizes für die Tabelle `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ruestung`
--
ALTER TABLE `ruestung`
  ADD PRIMARY KEY (`ruestungsid`);

--
-- Indizes für die Tabelle `spieler`
--
ALTER TABLE `spieler`
  ADD PRIMARY KEY (`spielername`);

--
-- Indizes für die Tabelle `themen`
--
ALTER TABLE `themen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `traenke`
--
ALTER TABLE `traenke`
  ADD PRIMARY KEY (`trankid`);

--
-- Indizes für die Tabelle `waffen`
--
ALTER TABLE `waffen`
  ADD PRIMARY KEY (`waffenid`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `gegner`
--
ALTER TABLE `gegner`
  MODIFY `gegnerid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `konto`
--
ALTER TABLE `konto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `ruestung`
--
ALTER TABLE `ruestung`
  MODIFY `ruestungsid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `themen`
--
ALTER TABLE `themen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `traenke`
--
ALTER TABLE `traenke`
  MODIFY `trankid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `waffen`
--
ALTER TABLE `waffen`
  MODIFY `waffenid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
