-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 26 2023 г., 02:56
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `polynetwork`
--

-- --------------------------------------------------------

--
-- Структура таблицы `chats`
--

CREATE TABLE `chats` (
  `id` int NOT NULL COMMENT 'айди чата',
  `title` varchar(50) DEFAULT NULL COMMENT 'заголовок чата. если нулевой, то ники юзеров',
  `owner_id` int DEFAULT NULL COMMENT 'айди владелеца чата, нулевой если это директ',
  `add_in_chat` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'могут ли добавлять юзеров не только владельцы, 1 - да, 0 - нет',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'последнее время обновления'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='таблица чатов';

--
-- Дамп данных таблицы `chats`
--

INSERT INTO `chats` (`id`, `title`, `owner_id`, `add_in_chat`, `last_update`) VALUES
(12, NULL, NULL, 0, '2023-06-25 22:02:57');

-- --------------------------------------------------------

--
-- Структура таблицы `chats_conn_users`
--

CREATE TABLE `chats_conn_users` (
  `id` int NOT NULL COMMENT 'айди юзера в чате',
  `chat_id` int NOT NULL COMMENT 'айди самого чата',
  `user_id` int NOT NULL COMMENT 'айди самого юзера'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='таблица юзеров чата';

--
-- Дамп данных таблицы `chats_conn_users`
--

INSERT INTO `chats_conn_users` (`id`, `chat_id`, `user_id`) VALUES
(19, 12, 14),
(20, 12, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL COMMENT 'айди комментария',
  `user_id` int NOT NULL COMMENT 'айди юзера',
  `post_id` int NOT NULL COMMENT 'айди поста',
  `description` varchar(1024) NOT NULL COMMENT 'содержание комментария',
  `dispatch_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'когда оставлен комментарий'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='таблица комментариев, от юзеров и всегда в постах';

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE `files` (
  `id` int NOT NULL COMMENT 'айди файла',
  `user_id` int DEFAULT NULL COMMENT 'айди юзера',
  `group_id` int DEFAULT NULL COMMENT 'айди группы',
  `message_id` int DEFAULT NULL COMMENT 'айди сообщения',
  `post_id` int DEFAULT NULL COMMENT 'айди поста',
  `file_name` varchar(100) NOT NULL COMMENT 'имя файла',
  `loading_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'время загрузки файла'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='таблица с файлами. только 1 внешний айди - остальные нулл';

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int NOT NULL COMMENT 'айди группы',
  `title` varchar(50) NOT NULL COMMENT 'название группы',
  `description` varchar(255) NOT NULL COMMENT 'описание группы',
  `date_of_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'дата создания группы'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='таблица групп';

-- --------------------------------------------------------

--
-- Структура таблицы `group_members`
--

CREATE TABLE `group_members` (
  `id` int NOT NULL COMMENT 'айди строки',
  `user_id` int NOT NULL COMMENT 'айди юзера-участника',
  `group_id` int NOT NULL COMMENT 'айди группы',
  `user_group_status_id` int NOT NULL COMMENT 'айди статуса юзера в группе',
  `participant_since` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'с какого времени в группе'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='таблица с участниками группы';

-- --------------------------------------------------------

--
-- Структура таблицы `learning_status`
--

CREATE TABLE `learning_status` (
  `id` tinyint(1) NOT NULL COMMENT 'Айди статуса',
  `status_name` varchar(50) NOT NULL COMMENT 'Название статуса'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Статус обучения юзера';

--
-- Дамп данных таблицы `learning_status`
--

INSERT INTO `learning_status` (`id`, `status_name`) VALUES
(0, 'Не указан'),
(1, 'Студент СПТ'),
(2, 'Выпускник СПТ'),
(3, 'Абитуриент'),
(4, 'Студент'),
(5, 'Выпускник'),
(7, 'Преподаватель СПТ'),
(8, 'Преподаватель');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL COMMENT 'айди сообщения',
  `user_id` int NOT NULL COMMENT 'айди отправившего юзера',
  `chat_id` int NOT NULL COMMENT 'айди чата/директа',
  `text` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'текст сообщения',
  `dispatch_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'когда написано сообщение'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='таблица сообщений';

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `chat_id`, `text`, `dispatch_time`) VALUES
(29, 1, 12, 'Привет!', '2023-06-25 21:17:06'),
(30, 14, 12, 'Привет!', '2023-06-25 22:02:57');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL COMMENT 'айди строки',
  `user_id` int DEFAULT NULL COMMENT 'айди юзера',
  `group_id` int DEFAULT NULL COMMENT 'айди группы',
  `title` varchar(128) DEFAULT NULL COMMENT 'заголовок поста, может быть нулевым',
  `description` varchar(5120) NOT NULL COMMENT 'основное содержание поста',
  `date_of_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'дата создания',
  `likes` int NOT NULL DEFAULT '0' COMMENT 'лайки под постом'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='таблица постов, может быть от юзера или от группы';

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `group_id`, `title`, `description`, `date_of_creation`, `likes`) VALUES
(1, 1, NULL, NULL, 'Ясность нашей позиции очевидна: экономическая повестка сегодняшнего дня требует анализа укрепления моральных ценностей. Кстати, некоторые особенности внутренней политики представляют собой не что иное, как квинтэссенцию победы маркетинга над разумом и должны быть объявлены нарушающими общечеловеческие нормы этики и морали. Предварительные выводы неутешительны: понимание сути ресурсосберегающих технологий играет важную роль в формировании анализа существующих паттернов поведения.', '2023-06-25 21:10:36', 0),
(2, 1, NULL, NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2023-06-25 21:12:49', 0),
(3, 1, NULL, NULL, 'Сегодня сдаю курсовую.', '2023-06-25 21:15:48', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `id` tinyint(1) NOT NULL COMMENT 'Айди роли',
  `role_name` varchar(50) NOT NULL COMMENT 'Название роли'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Роли юзера (по умолчанию простой)';

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `role_name`) VALUES
(1, 'default'),
(2, 'admin'),
(3, 'teacher');

-- --------------------------------------------------------

--
-- Структура таблицы `spt_group`
--

CREATE TABLE `spt_group` (
  `id` int NOT NULL COMMENT 'Айди группы спт',
  `group_name` varchar(20) NOT NULL COMMENT 'Название группы'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Таблица групп спт';

--
-- Дамп данных таблицы `spt_group`
--

INSERT INTO `spt_group` (`id`, `group_name`) VALUES
(0, 'none'),
(1, '2АС-20'),
(2, '2ОПС-22'),
(3, '2ПР-20'),
(4, '2ПР-21'),
(5, '2ПР-22'),
(6, '2ПР-23'),
(7, '2ТС-23'),
(8, '2ЭМ-19'),
(9, 'А-23'),
(10, 'АС-19'),
(11, 'АС-20'),
(12, 'АС-21'),
(13, 'АС-22'),
(14, 'АС-23'),
(15, 'БД-20'),
(16, 'БД-22'),
(17, 'БД-23'),
(18, 'Л-20'),
(19, 'Л-21'),
(20, 'Л-22'),
(21, 'Л-23'),
(22, 'ОПС-20'),
(23, 'ОПС-21'),
(24, 'ОПС-22'),
(25, 'ОПС-23'),
(26, 'ПР-19'),
(27, 'ПР-20'),
(28, 'ПР-21'),
(29, 'ПР-22'),
(30, 'ПР-23'),
(31, 'СБ-19'),
(32, 'СБ-20'),
(33, 'СБ-21'),
(34, 'СБ-22'),
(35, 'СБ-23'),
(36, 'Т-19'),
(37, 'Т-20'),
(38, 'ТМ-21'),
(39, 'ТМ-22'),
(40, 'ТМ-23'),
(41, 'ТС-23'),
(42, 'ТТ-20'),
(43, 'ТТ-21'),
(44, 'ТТ-22'),
(45, 'ТТ-23'),
(46, '2ПБ-21'),
(47, '2ПД-20'),
(48, '2ПД-21'),
(49, '2ПД-22'),
(50, '2ПДв-22'),
(51, '2ЧС-19'),
(52, '2ЧС-20'),
(53, '2ЧС-21'),
(54, '2ЧС-22'),
(55, '2Ю-20'),
(56, '2Ю-21'),
(57, '2Ю-22'),
(58, '3ПД-20'),
(59, '3ПД-21'),
(60, '3ПД-22'),
(61, '3ПДв-22'),
(62, '3ЧС-19'),
(63, '3ЧС-20'),
(64, '3ЧС-21'),
(65, '3ЧС-22'),
(66, '4ПД-20'),
(67, '4ЧС-20'),
(68, '4ЧС-21'),
(69, '4ЧС-22'),
(70, 'М-19'),
(71, 'М-20'),
(72, 'М-21'),
(73, 'М-22'),
(74, 'ПБ-20'),
(75, 'ПБ-21'),
(76, 'ПБ-22'),
(77, 'ПД-20'),
(78, 'ПД-21'),
(79, 'ПД-22'),
(80, 'ПДВ-21'),
(81, 'ПДС-21'),
(82, 'ПДС-22'),
(83, 'ПДв-22'),
(84, 'Ф-22'),
(85, 'ЧС-19'),
(86, 'ЧС-20'),
(87, 'ЧС-21'),
(88, 'ЧС-22'),
(89, 'Э-19'),
(90, 'Э-20'),
(91, 'Э-21'),
(92, 'Э-22'),
(93, 'ЭМ-19'),
(94, 'ЭМ-20'),
(95, 'ЭМ-21'),
(96, 'ЭМ-22'),
(97, 'Ю-20'),
(98, 'Ю-21'),
(99, 'Ю-22');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL COMMENT 'Айди юзера',
  `login` varchar(50) DEFAULT NULL COMMENT 'Логин юзера, можно задать самому в настройках, также будет уникальный логин системы спт (uid)',
  `password_hash` varchar(60) NOT NULL COMMENT 'Хэшированный пароль',
  `email` varchar(50) NOT NULL COMMENT 'Эл. почта',
  `phone` varchar(20) NOT NULL COMMENT 'Телефон',
  `firstname` varchar(50) NOT NULL COMMENT 'Фамилия',
  `name` varchar(50) NOT NULL COMMENT 'Имя',
  `lastname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Отчество',
  `sex` tinyint(1) NOT NULL COMMENT 'пол юзера. 1 если мужчина, 0 если женщина',
  `date_of_registration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата регистрации.',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'время последней загрузки страницы от пользователя',
  `role_id` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Айди роли (админ/не админ)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Таблица юзера с его инфой';

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password_hash`, `email`, `phone`, `firstname`, `name`, `lastname`, `sex`, `date_of_registration`, `last_update`, `role_id`) VALUES
(1, 'admin', '$2y$10$KLAQdqkDMPIkj8Of/p2b4.FTyhQEeHMGa5dJtINmH7V/GR0YwU7F2', 'example@gmail.com', '88005553535', 'Админов', 'Админ', 'Админович', 1, '2023-05-21 14:07:40', '2023-06-25 22:59:17', 2),
(14, NULL, '$2y$10$OjmcPEMxof6bQfG6L2SDh.Z.Am5zjNhQ2JcoejqLI.uREGLjEj6Te', 'koxas12@mail.ru', '79234878515', 'Кохась', 'ВладЕк', NULL, 0, '2023-06-16 07:00:58', '2023-06-25 22:02:46', 1),
(15, NULL, '$2y$10$jgcXmglGOo6tKIQK3BnIGOVp0K5MQIMKmfxRbbO4lj6Jh74PWfTrq', 'admin@admin', '8800', 'Второй', 'Админ', NULL, 0, '2023-06-19 17:12:35', '2023-06-24 12:14:34', 1),
(18, NULL, '$2y$10$GfhJaYdIO3n9bWybMnD6duWcJPd6eYgTBvNgaDcYcBbUEXKYbJ6KO', 'admin@admin.com', '78005553535', 'Третий', 'Админ', 'Админович', 1, '2023-06-25 09:38:42', '2023-06-25 09:39:42', 1),
(24, NULL, '$2y$10$QHDp3oqTn8e4iuNfBXo99.tgHYwzEbyeldpZl0y35qtdZ0no9iK5W', 'chernykhin45@gmail.com', '79511684577', 'Черных', 'Игорь', 'Олегович', 1, '2023-06-25 14:36:27', '2023-06-25 14:36:27', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users_conn_user_friends`
--

CREATE TABLE `users_conn_user_friends` (
  `id` int NOT NULL COMMENT 'айди таблицы',
  `user_id` int NOT NULL COMMENT 'айди юзера',
  `user_friend_id` int NOT NULL COMMENT 'айди друзей юзера',
  `friendship_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'время когда подружились'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='таблица для связывания юзеров и друзей';

-- --------------------------------------------------------

--
-- Структура таблицы `user_friends`
--

CREATE TABLE `user_friends` (
  `id` int NOT NULL COMMENT 'айди строки',
  `user_id` int NOT NULL COMMENT 'Айди юзера-друга'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='дублирующая айди юзеров таблица для добавления в друзья';

-- --------------------------------------------------------

--
-- Структура таблицы `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int NOT NULL COMMENT 'айди таблицы',
  `user_id` int NOT NULL COMMENT 'айди юзера',
  `group_id` int NOT NULL COMMENT 'айди группы'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='таблица групп юзера';

-- --------------------------------------------------------

--
-- Структура таблицы `user_group_status`
--

CREATE TABLE `user_group_status` (
  `id` int NOT NULL COMMENT 'айди статуса',
  `name` varchar(30) NOT NULL COMMENT 'название статуса'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='таблица статусов юзера в группе';

--
-- Дамп данных таблицы `user_group_status`
--

INSERT INTO `user_group_status` (`id`, `name`) VALUES
(1, 'Участник'),
(2, 'Администратор'),
(3, 'Владелец');

-- --------------------------------------------------------

--
-- Структура таблицы `user_info`
--

CREATE TABLE `user_info` (
  `id` int NOT NULL COMMENT 'Айди строки.',
  `user_id` int NOT NULL COMMENT 'Айди юзера.',
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Статус юзера.',
  `date_of_birth` date DEFAULT NULL COMMENT 'ДР юзера.',
  `city` varchar(50) DEFAULT NULL COMMENT 'Город юзера.',
  `about_me` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Обо мне.',
  `spt_group_id` int DEFAULT '0' COMMENT 'Группа СПТ юзера (если состоит).',
  `learning_status_id` tinyint(1) DEFAULT '0' COMMENT 'Статус обучения.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user_info`
--

INSERT INTO `user_info` (`id`, `user_id`, `status`, `date_of_birth`, `city`, `about_me`, `spt_group_id`, `learning_status_id`) VALUES
(1, 1, 'Пилим Полисеть. До сих пор.', '2004-03-12', 'Кемерово', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 1),
(14, 14, NULL, NULL, NULL, NULL, 0, 5),
(15, 15, NULL, NULL, NULL, NULL, 0, 0),
(18, 18, NULL, NULL, NULL, NULL, 0, 0),
(24, 24, NULL, NULL, NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_settings`
--

CREATE TABLE `user_settings` (
  `id` int NOT NULL COMMENT 'айди строки таблицы',
  `user_id` int NOT NULL COMMENT 'айди юзера',
  `hide_lastname` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'скрыть отчество, по умолчанию нет',
  `hide_email` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'скрыть почту, по умолчанию нет',
  `hide_phone` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'скрыть телефон, по умолчанию да',
  `hide_date_of_birth` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'скрыть др, по умолчанию нет',
  `type_of_profile` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'тип профиля. 1 - закрытый, 0 - открытый, по умолчанию 0',
  `avatar_file` varchar(100) NOT NULL DEFAULT 'none' COMMENT 'путь к аватарке из персонального путя юзера, по умолчанию аватарки нет'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='таблица настроек юзера. в булевых значениях 1 - да, 2 - нет';

--
-- Дамп данных таблицы `user_settings`
--

INSERT INTO `user_settings` (`id`, `user_id`, `hide_lastname`, `hide_email`, `hide_phone`, `hide_date_of_birth`, `type_of_profile`, `avatar_file`) VALUES
(1, 1, 0, 0, 0, 0, 0, 'none'),
(14, 14, 0, 0, 1, 0, 0, 'none'),
(15, 15, 0, 0, 1, 0, 0, 'none'),
(18, 18, 0, 0, 1, 1, 0, 'none'),
(24, 24, 0, 0, 1, 1, 0, 'none');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Индексы таблицы `chats_conn_users`
--
ALTER TABLE `chats_conn_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_conn_users_ibfk_1` (`chat_id`),
  ADD KEY `chats_conn_users_ibfk_2` (`user_id`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_ibfk_1` (`user_id`),
  ADD KEY `comments_ibfk_2` (`post_id`);

--
-- Индексы таблицы `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `message_id` (`message_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_group_status_id` (`user_group_status_id`);

--
-- Индексы таблицы `learning_status`
--
ALTER TABLE `learning_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_ibfk_1` (`user_id`),
  ADD KEY `messages_ibfk_2` (`chat_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `spt_group`
--
ALTER TABLE `spt_group`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Индексы таблицы `users_conn_user_friends`
--
ALTER TABLE `users_conn_user_friends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_friend_id` (`user_friend_id`),
  ADD KEY `users_conn_user_friends_ibfk_1` (`user_id`);

--
-- Индексы таблицы `user_friends`
--
ALTER TABLE `user_friends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_friends_ibfk_1` (`user_id`);

--
-- Индексы таблицы `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Индексы таблицы `user_group_status`
--
ALTER TABLE `user_group_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `spt_group_id` (`spt_group_id`),
  ADD KEY `learning_status_id` (`learning_status_id`);

--
-- Индексы таблицы `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'айди чата', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `chats_conn_users`
--
ALTER TABLE `chats_conn_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'айди юзера в чате', AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'айди комментария';

--
-- AUTO_INCREMENT для таблицы `files`
--
ALTER TABLE `files`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'айди файла';

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'айди группы';

--
-- AUTO_INCREMENT для таблицы `group_members`
--
ALTER TABLE `group_members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'айди строки';

--
-- AUTO_INCREMENT для таблицы `learning_status`
--
ALTER TABLE `learning_status`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'Айди статуса', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'айди сообщения', AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'айди строки', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'Айди роли', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `spt_group`
--
ALTER TABLE `spt_group`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'Айди группы спт', AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'Айди юзера', AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `users_conn_user_friends`
--
ALTER TABLE `users_conn_user_friends`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'айди таблицы';

--
-- AUTO_INCREMENT для таблицы `user_friends`
--
ALTER TABLE `user_friends`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'айди строки';

--
-- AUTO_INCREMENT для таблицы `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'айди таблицы';

--
-- AUTO_INCREMENT для таблицы `user_group_status`
--
ALTER TABLE `user_group_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'айди статуса', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'Айди строки.', AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'айди строки таблицы', AUTO_INCREMENT=25;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `chats_conn_users`
--
ALTER TABLE `chats_conn_users`
  ADD CONSTRAINT `chats_conn_users_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `chats_conn_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `files_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `files_ibfk_3` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `files_ibfk_4` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `group_members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `group_members_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `group_members_ibfk_3` FOREIGN KEY (`user_group_status_id`) REFERENCES `user_group_status` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `users_conn_user_friends`
--
ALTER TABLE `users_conn_user_friends`
  ADD CONSTRAINT `users_conn_user_friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `users_conn_user_friends_ibfk_2` FOREIGN KEY (`user_friend_id`) REFERENCES `user_friends` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `user_friends`
--
ALTER TABLE `user_friends`
  ADD CONSTRAINT `user_friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `user_groups`
--
ALTER TABLE `user_groups`
  ADD CONSTRAINT `user_groups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_groups_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `user_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_info_ibfk_2` FOREIGN KEY (`spt_group_id`) REFERENCES `spt_group` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_info_ibfk_3` FOREIGN KEY (`learning_status_id`) REFERENCES `learning_status` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `user_settings`
--
ALTER TABLE `user_settings`
  ADD CONSTRAINT `user_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
