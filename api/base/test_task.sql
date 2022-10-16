-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 16 2022 г., 23:21
-- Версия сервера: 5.6.47-log
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_task`
--

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `ID` int(11) NOT NULL,
  `ParticipantId` int(11) NOT NULL,
  `NewsTitle` varchar(255) NOT NULL,
  `NewsMessage` text NOT NULL,
  `LikesCounter` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`ID`, `ParticipantId`, `NewsTitle`, `NewsMessage`, `LikesCounter`) VALUES
(1, 1, 'New agenda!', 'Please visit our site!', 0),
(2, 2, 'Доступна новая программа', 'Новая программа выслана на почту всем участникам', 0),
(3, 1, 'Еще одна новость', 'Проверка новости', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `participant`
--

CREATE TABLE `participant` (
  `ID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `participant`
--

INSERT INTO `participant` (`ID`, `Email`, `Name`) VALUES
(1, 'airmail@code-pilots.com', 'The first user'),
(2, '1@test.ru', 'test1'),
(3, '2@test.ru', 'test2'),
(4, '3@test.ru', 'test3'),
(5, '4@test.ru', 'test4');

-- --------------------------------------------------------

--
-- Структура таблицы `session`
--

CREATE TABLE `session` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `TimeOfEvent` datetime NOT NULL,
  `Description` text NOT NULL,
  `participant_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `session`
--

INSERT INTO `session` (`ID`, `Name`, `TimeOfEvent`, `Description`, `participant_limit`) VALUES
(1, 'Annual report', '2016-12-15 16:00:00', 'Anuual report by CEO', 10),
(2, 'Test', '2022-10-16 00:00:00', 'test description', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `session_participant`
--

CREATE TABLE `session_participant` (
  `session_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `session_participant`
--

INSERT INTO `session_participant` (`session_id`, `participant_id`) VALUES
(1, 2),
(1, 5),
(2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `session_speaker`
--

CREATE TABLE `session_speaker` (
  `session_id` int(11) NOT NULL,
  `speaker_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `session_speaker`
--

INSERT INTO `session_speaker` (`session_id`, `speaker_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `speaker`
--

CREATE TABLE `speaker` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `speaker`
--

INSERT INTO `speaker` (`ID`, `Name`) VALUES
(1, 'Watson'),
(2, 'Arnold');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `session_participant`
--
ALTER TABLE `session_participant`
  ADD PRIMARY KEY (`session_id`,`participant_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `participant_id` (`participant_id`);

--
-- Индексы таблицы `session_speaker`
--
ALTER TABLE `session_speaker`
  ADD PRIMARY KEY (`session_id`,`speaker_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `speaker_id` (`speaker_id`);

--
-- Индексы таблицы `speaker`
--
ALTER TABLE `speaker`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `participant`
--
ALTER TABLE `participant`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `session`
--
ALTER TABLE `session`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `speaker`
--
ALTER TABLE `speaker`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `session_participant`
--
ALTER TABLE `session_participant`
  ADD CONSTRAINT `session_participant_ibfk_1` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`ID`),
  ADD CONSTRAINT `session_participant_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `session` (`ID`);

--
-- Ограничения внешнего ключа таблицы `session_speaker`
--
ALTER TABLE `session_speaker`
  ADD CONSTRAINT `session_speaker_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `session` (`ID`),
  ADD CONSTRAINT `session_speaker_ibfk_2` FOREIGN KEY (`speaker_id`) REFERENCES `speaker` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
