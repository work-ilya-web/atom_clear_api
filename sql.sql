-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Окт 17 2022 г., 11:17
-- Версия сервера: 10.5.17-MariaDB-1:10.5.17+maria~ubu2004
-- Версия PHP: 7.4.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `admin_sb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE `articles` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `alias` varchar(255) NOT NULL,
  `files_id` bigint(20) UNSIGNED NOT NULL,
  `langs_id` smallint(3) UNSIGNED NOT NULL,
  `sort` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Отзывы';

-- --------------------------------------------------------

--
-- Структура таблицы `faq`
--

CREATE TABLE `faq` (
  `id` int(11) UNSIGNED NOT NULL,
  `ask` text NOT NULL,
  `answer` text NOT NULL,
  `langs_id` smallint(3) UNSIGNED NOT NULL,
  `sort` smallint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `faq`
--

INSERT INTO `faq` (`id`, `ask`, `answer`, `langs_id`, `sort`) VALUES
(1, 'Как работает сервис?', 'Наша компания занимается перевозкой вещей на территории США (мувинг). Мы осуществляем разные виды транспортировки грузов и предоставляем сопутствующие услуги. У нас можно заказать квартирный переезд, домашний переезд, складской переезд и другие виды перевозки вещей.', 1, 1),
(2, 'Как работает мувинг и для чего он требуется мне?', 'Test', 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE `files` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id файла ',
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `type` varchar(10) NOT NULL COMMENT 'Тип',
  `mime_type` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL COMMENT 'Размер',
  `user_id` int(11) NOT NULL COMMENT 'Id загрузившего ',
  `date_create` int(11) UNSIGNED NOT NULL COMMENT 'Дата загрузки',
  `path` varchar(1000) NOT NULL COMMENT 'Путь до файла',
  `server` varchar(255) NOT NULL,
  `post_type` varchar(255) DEFAULT NULL,
  `post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Файлы';

-- --------------------------------------------------------

--
-- Структура таблицы `langs`
--

CREATE TABLE `langs` (
  `id` smallint(3) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Языки';

--
-- Дамп данных таблицы `langs`
--

INSERT INTO `langs` (`id`, `name`, `alias`) VALUES
(1, 'RU', 'ru'),
(2, 'EN', 'en'),
(3, 'ES', 'es');

-- --------------------------------------------------------

--
-- Структура таблицы `partners`
--

CREATE TABLE `partners` (
  `id` int(11) UNSIGNED NOT NULL,
  `files_id` bigint(20) UNSIGNED NOT NULL,
  `sort` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Отзывы';

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `reviews` text NOT NULL,
  `rating` tinyint(1) UNSIGNED NOT NULL,
  `files_id` bigint(20) UNSIGNED NOT NULL,
  `langs_id` smallint(3) UNSIGNED NOT NULL,
  `sort` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Отзывы';

-- --------------------------------------------------------

--
-- Структура таблицы `service_packages`
--

CREATE TABLE `service_packages` (
  `id` tinyint(1) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `list_1` text NOT NULL,
  `list_2` text NOT NULL,
  `color` varchar(255) NOT NULL,
  `langs_id` smallint(3) UNSIGNED NOT NULL,
  `sort` smallint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Комплексы услуг по переезду';

--
-- Дамп данных таблицы `service_packages`
--

INSERT INTO `service_packages` (`id`, `name`, `price`, `list_1`, `list_2`, `color`, `langs_id`, `sort`) VALUES
(1, 'Пакет 1', '137$', 'Грузовик + 2 грузчика\nУпаковочная пленка и упаковочные коробки\nУпаковочная лента\nУпаковочное одеяло\nУпаковочный материал для телевизора \n', '+1 грузчик - 50$/час\r\nДополнительная промежуточная остановка - 50$/час', 'orange', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `created_at` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `email` varchar(128) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` int(11) UNSIGNED NOT NULL,
  `deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0-не удален, 1-удален'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `created_at`, `email`, `password`, `role`, `deleted`) VALUES
(1, 4294967295, 'admin@mail.ru', 'e10adc3949ba59abbe56e057f20f883e', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_subdivisions` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Должности';

--
-- Дамп данных таблицы `user_roles`
--

INSERT INTO `user_roles` (`id`, `id_subdivisions`, `title`, `status`) VALUES
(1, 1, 'Administrator', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `date_end` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Токены пользователей';

--
-- Дамп данных таблицы `user_tokens`
--

INSERT INTO `user_tokens` (`id`, `user_id`, `token`, `date_end`) VALUES
(1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJodHRwczpcL1wvYXBpLmFsdDEueW9kZS5wcm8iLCJpYXQiOjE2NjYwMDE0MTYsIm5iZiI6MTY2NjAwMTMxNn0.OAkkuPBSMfV40eu-9txdDfnOfTNQH3ToNGYUslZBtT8', 1666865416),
(3, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJodHRwczpcL1wvYXBpLmFsdDEueW9kZS5wcm8iLCJpYXQiOjE2NjYwMDE1ODQsIm5iZiI6MTY2NjAwMTQ4NH0.P-nqo6FmYVdE4KwgXKtHRFJroOA6cBQxTN9CyuKrKZc', 1666865584);

-- --------------------------------------------------------

--
-- Структура таблицы `why_we`
--

CREATE TABLE `why_we` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `files_id` bigint(20) UNSIGNED NOT NULL,
  `langs_id` smallint(3) UNSIGNED NOT NULL,
  `sort` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Отзывы';

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `langs_id` (`langs_id`),
  ADD KEY `reviews_ibfk_2` (`files_id`);

--
-- Индексы таблицы `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`),
  ADD KEY `langs_id` (`langs_id`);

--
-- Индексы таблицы `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_ibfk_1` (`user_id`);

--
-- Индексы таблицы `langs`
--
ALTER TABLE `langs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_ibfk_2` (`files_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `langs_id` (`langs_id`),
  ADD KEY `reviews_ibfk_2` (`files_id`);

--
-- Индексы таблицы `service_packages`
--
ALTER TABLE `service_packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `langs_id` (`langs_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role`);

--
-- Индексы таблицы `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_subdivisions` (`id_subdivisions`);

--
-- Индексы таблицы `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `why_we`
--
ALTER TABLE `why_we`
  ADD PRIMARY KEY (`id`),
  ADD KEY `langs_id` (`langs_id`),
  ADD KEY `reviews_ibfk_2` (`files_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id файла ';

--
-- AUTO_INCREMENT для таблицы `langs`
--
ALTER TABLE `langs`
  MODIFY `id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `service_packages`
--
ALTER TABLE `service_packages`
  MODIFY `id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT для таблицы `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT для таблицы `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `why_we`
--
ALTER TABLE `why_we`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `faq`
--
ALTER TABLE `faq`
  ADD CONSTRAINT `faq_ibfk_1` FOREIGN KEY (`langs_id`) REFERENCES `langs` (`id`);

--
-- Ограничения внешнего ключа таблицы `partners`
--
ALTER TABLE `partners`
  ADD CONSTRAINT `partners_ibfk_1` FOREIGN KEY (`files_id`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`langs_id`) REFERENCES `langs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`files_id`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `service_packages`
--
ALTER TABLE `service_packages`
  ADD CONSTRAINT `service_packages_ibfk_1` FOREIGN KEY (`langs_id`) REFERENCES `langs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
