-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 21 Sty 2020, 14:42
-- Wersja serwera: 10.1.38-MariaDB
-- Wersja PHP: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `projekt_pai`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cars`
--

CREATE TABLE `cars` (
  `id_car` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `shortDescript` varchar(500) NOT NULL,
  `descript` varchar(5000) NOT NULL,
  `year` varchar(200) NOT NULL,
  `prize` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `offerts`
--

CREATE TABLE `offerts` (
  `id_offer` int(10) NOT NULL,
  `id_car` int(10) NOT NULL,
  `created_at` date DEFAULT NULL,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `photos`
--

CREATE TABLE `photos` (
  `id_photo` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `id_car` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `role`
--

CREATE TABLE `role` (
  `id_role` int(10) NOT NULL,
  `role` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `role`
--

INSERT INTO `role` (`id_role`, `role`) VALUES
(1, 'admin'),
(1, 'admin'),
(2, 'user'),
(2, 'user');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id_user` int(10) NOT NULL,
  `id_user_details` int(10) DEFAULT NULL,
  `id_role` int(10) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id_user`, `id_user_details`, `id_role`, `email`, `password`, `created_at`) VALUES
(6, NULL, 2, 'dawdziedziak@gmail.com', '$2y$10$NXBM3GgHE6M7CC0wh4wTk.7ZGIL/W.vGjBTpAilrr2yVMsQfFeS4m', '2020-01-21');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_details`
--

CREATE TABLE `user_details` (
  `id_details` int(10) NOT NULL,
  `name` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `surname` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `phone` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id_car`) USING BTREE;

--
-- Indeksy dla tabeli `offerts`
--
ALTER TABLE `offerts`
  ADD PRIMARY KEY (`id_offer`) USING BTREE,
  ADD KEY `FK2_id_car` (`id_car`),
  ADD KEY `FK2_id_user` (`id_user`);

--
-- Indeksy dla tabeli `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id_photo`) USING BTREE,
  ADD KEY `FK_car_id` (`id_car`);

--
-- Indeksy dla tabeli `role`
--
ALTER TABLE `role`
  ADD KEY `id_role` (`id_role`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`) USING BTREE,
  ADD KEY `FK_id_role` (`id_role`),
  ADD KEY `FK_id_user_details` (`id_user_details`);

--
-- Indeksy dla tabeli `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id_details`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `cars`
--
ALTER TABLE `cars`
  MODIFY `id_car` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `offerts`
--
ALTER TABLE `offerts`
  MODIFY `id_offer` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `photos`
--
ALTER TABLE `photos`
  MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `offerts`
--
ALTER TABLE `offerts`
  ADD CONSTRAINT `FK2_id_car` FOREIGN KEY (`id_car`) REFERENCES `cars` (`id_car`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK2_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `FK_car_id` FOREIGN KEY (`id_car`) REFERENCES `cars` (`id_car`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_id_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_id_user_details` FOREIGN KEY (`id_user_details`) REFERENCES `user_details` (`id_details`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
