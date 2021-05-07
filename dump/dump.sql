-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 07 Maj 2021, 10:53
-- Wersja serwera: 10.4.17-MariaDB
-- Wersja PHP: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `social-media`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `content` text COLLATE utf8_polish_ci NOT NULL,
  `toWho` int(11) NOT NULL,
  `fromWho` text COLLATE utf8_polish_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `messages`
--

INSERT INTO `messages` (`id`, `content`, `toWho`, `fromWho`, `date`) VALUES
(1, 'To pierwsza wiadomość', 4, 'test3', '2021-04-03'),
(2, 'testowa wiadomo&sacute;&cacute;', 4, 'test3', '2021-05-01'),
(4, 'tak o ', 3, 'test4', '2021-05-01'),
(5, 'dzi&eogon;ki za wiadomo&sacute;&cacute;', 4, 'test3', '2021-05-01'),
(6, 'nie ma za co', 3, 'test4', '2021-05-01');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_polish_ci NOT NULL,
  `Pname` text COLLATE utf8_polish_ci NOT NULL,
  `description` text COLLATE utf8_polish_ci NOT NULL,
  `WhoPosted` text COLLATE utf8_polish_ci NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `photos`
--

INSERT INTO `photos` (`id`, `title`, `Pname`, `description`, `WhoPosted`, `likes`) VALUES
(1, 'First Post', '1.jpg', 'some short descripttion', '1', 10),
(2, 'pierwszy post z formularza', '6086b35be69a86.74888687.jpg', 'taki o plik', '4', 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `thinks`
--

CREATE TABLE `thinks` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_polish_ci NOT NULL,
  `content` text COLLATE utf8_polish_ci NOT NULL,
  `WhoPosted` int(11) NOT NULL,
  `WhenPosted` date NOT NULL,
  `Likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `thinks`
--

INSERT INTO `thinks` (`id`, `title`, `content`, `WhoPosted`, `WhenPosted`, `Likes`) VALUES
(1, 'tytuł', 'tresc', 1, '2021-01-01', 0),
(2, 'test Think', 'Hello world', 4, '2021-04-19', 0),
(3, 'Pierwszy post test3', 'To ja test3', 3, '2021-04-21', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` text COLLATE utf8_polish_ci NOT NULL,
  `pass` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `surname` text COLLATE utf8_polish_ci NOT NULL,
  `age` int(11) NOT NULL,
  `status` text COLLATE utf8_polish_ci NOT NULL,
  `friends` text COLLATE utf8_polish_ci NOT NULL,
  `profpic` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `user`, `pass`, `email`, `name`, `surname`, `age`, `status`, `friends`, `profpic`) VALUES
(1, 'test1', '$2y$10$DjoCxt2UkyEOLfHw6illqOXGjpdkyks4F/Jqlam4h2FwiQgzaHyOW', 'jan@gmail.com', 'test', 'test', 21, 'single', ' ', ''),
(2, 'test2', '$2y$10$l89CDvy3djn/Rdid3cgTk.poP1NYDLT8OiZeg7RbGMQeuoc8KxDgm', 'w2137@gmail.com', 'test', 'test', 18, 'single', '', ''),
(3, 'test3', '$2y$10$yHGP2oocdjxmorL5VJ67ruP6BloEkXyww2olV67HsJ/jLes4/CJ8y', 'test3@gmail.com', 'test3', 'test3', 21, 'single', ' 4,  2,  1, ', 'test3.png'),
(4, 'test4', '$2y$10$8ge4fPd924SH5tyPt9Vg0OvZ2/k6mC3m5zUM6HtSxrNJetd4A9FYm', 'test@gmail.com', 'test', 'test4', 22, 'single', ' 3,  1,  2, ', 'test4.jpg');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `thinks`
--
ALTER TABLE `thinks`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `thinks`
--
ALTER TABLE `thinks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
