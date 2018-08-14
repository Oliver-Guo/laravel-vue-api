-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- 主機: mariadb
-- 產生時間： 2018 年 08 月 13 日 10:03
-- 伺服器版本: 10.2.12-MariaDB-10.2.12+maria~jessie
-- PHP 版本： 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `demo`
--

-- --------------------------------------------------------

--
-- 資料表結構 `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL COMMENT '標題'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章';

--
-- 資料表的匯出資料 `articles`
--

INSERT INTO `articles` (`id`, `title`) VALUES
(1, 'AABBCC'),
(2, 'AAAAA'),
(3, 'BBBBB456'),
(4, 'CCCCC123'),
(5, 'ERJYTKQ'),
(6, 'ILUTE'),
(7, 'WTWETKYOV'),
(8, 'ERTREYNSD');

-- --------------------------------------------------------

--
-- 資料表結構 `article_topic`
--

CREATE TABLE `article_topic` (
  `article_id` int(11) NOT NULL COMMENT 'articles',
  `topic_id` int(11) NOT NULL COMMENT 'topics',
  `sort` int(11) NOT NULL DEFAULT 9999
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `article_topic`
--

INSERT INTO `article_topic` (`article_id`, `topic_id`, `sort`) VALUES
(1, 1, 1),
(4, 1, 2),
(8, 1, 3),
(3, 3, 1),
(7, 3, 2);

-- --------------------------------------------------------

--
-- 資料表結構 `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT '名稱',
  `description` text DEFAULT NULL COMMENT '簡述',
  `outsite_url` varchar(255) DEFAULT '' COMMENT '作者連結',
  `fb_share` varchar(255) DEFAULT '',
  `google_share` varchar(255) DEFAULT '',
  `twitter_share` varchar(255) DEFAULT '',
  `is_online` tinyint(1) DEFAULT 1,
  `created_at` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `authors`
--

INSERT INTO `authors` (`id`, `name`, `description`, `outsite_url`, `fb_share`, `google_share`, `twitter_share`, `is_online`, `created_at`, `updated_at`) VALUES
(1, 'AAAA', '作者簡述 作者簡述 作者簡述123', '', '', '', '', 1, 1534150215, 1534154177),
(2, 'BBBB', '作者簡述 作者簡述 作者簡述', '', '', '', '', 0, 1534150711, 1534150711);

-- --------------------------------------------------------

--
-- 資料表結構 `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('demo_cachemzpVqPpOe2hwElcW', 'a:1:{s:11:\"valid_until\";i:1534149638;}', 1534408408),
('demo_cacheoA8xpf2nVpvXdLdk', 'a:1:{s:11:\"valid_until\";i:1534149724;}', 1534408854),
('demo_cacheyU5eKg0ckr8isqUD', 'a:1:{s:11:\"valid_until\";i:1534150921;}', 1534408971);

-- --------------------------------------------------------

--
-- 資料表結構 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2018_05_28_153758_create_cache_table', 2);

-- --------------------------------------------------------

--
-- 資料表結構 `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `permission_group_id` int(11) DEFAULT NULL,
  `display_type` varchar(255) NOT NULL DEFAULT '',
  `display_name` varchar(255) NOT NULL DEFAULT '',
  `sort` int(11) NOT NULL DEFAULT 999,
  `description` varchar(255) NOT NULL DEFAULT '',
  `created_user` int(11) NOT NULL DEFAULT 0,
  `created_at` bigint(20) DEFAULT NULL,
  `updated_user` int(11) NOT NULL DEFAULT 0,
  `updated_at` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `permission_group_id`, `display_type`, `display_name`, `sort`, `description`, `created_user`, `created_at`, `updated_user`, `updated_at`) VALUES
(1, 'author_list', 1, '作者', '列表', 1, '', 0, NULL, 0, NULL),
(2, 'author_add', 1, '作者', '新增', 2, '', 0, NULL, 0, NULL),
(3, 'author_edit', 1, '作者', '編輯', 3, '', 0, NULL, 0, NULL),
(4, 'author_del', 1, '作者', '刪除', 4, '', 0, NULL, 0, NULL),
(5, 'permission_user_list', 2, '2.管理使用者', '列表', 1, '', 0, NULL, 0, NULL),
(6, 'permission_user_add', 2, '2.管理使用者', '新增', 2, '', 0, NULL, 0, NULL),
(7, 'permission_user_edit', 2, '2.管理使用者', '編輯', 3, '', 0, NULL, 0, NULL),
(8, 'permission_user_del', 2, '2.管理使用者', '刪除', 4, '', 0, NULL, 0, NULL),
(9, 'permission_role_list', 2, '1.管理權限群組', '列表', 1, '', 0, NULL, 0, NULL),
(10, 'permission_role_add', 2, '1.管理權限群組', '新增', 2, '', 0, NULL, 0, NULL),
(11, 'permission_role_edit', 2, '1.管理權限群組', '編輯', 3, '', 0, NULL, 0, NULL),
(12, 'permission_role_del', 2, '1.管理權限群組', '刪除', 4, '', 0, NULL, 0, NULL),
(13, 'topic_category_list', 3, '1.專題分類', '列表', 1, '', 0, NULL, 0, NULL),
(14, 'topic_category_add', 3, '1.專題分類', '新增', 2, '', 0, NULL, 0, NULL),
(15, 'topic_category_edit', 3, '1.專題分類', '編輯', 3, '', 0, NULL, 0, NULL),
(16, 'topic_category_del', 3, '1.專題分類', '刪除', 4, '', 0, NULL, 0, NULL),
(17, 'topic_list', 3, '2.專題', '列表', 1, '', 0, NULL, 0, NULL),
(18, 'topic_add', 3, '2.專題', '新增', 2, '', 0, NULL, 0, NULL),
(19, 'topic_edit', 3, '2.專題', '編輯', 3, '', 0, NULL, 0, NULL),
(20, 'topic_del', 3, '2.專題', '刪除', 4, '', 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `permission_groups`
--

CREATE TABLE `permission_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL DEFAULT '',
  `sort` int(11) NOT NULL DEFAULT 9999
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `permission_groups`
--

INSERT INTO `permission_groups` (`id`, `group_name`, `sort`) VALUES
(1, '作者專區', 1),
(2, '權限管理', 9),
(3, '專題', 2);

-- --------------------------------------------------------

--
-- 資料表結構 `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(5, 2),
(6, 2),
(8, 2),
(7, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(3, 1),
(4, 1),
(2, 1),
(1, 4),
(2, 4),
(1, 2),
(3, 2),
(4, 2),
(2, 2),
(13, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(14, 2),
(15, 2),
(16, 2),
(3, 4),
(4, 4),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(20, 1),
(19, 1),
(18, 1),
(17, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `imageable_id` int(11) NOT NULL COMMENT '對應表id',
  `imageable_type` varchar(100) NOT NULL COMMENT '對應表',
  `name` varchar(100) NOT NULL COMMENT '檔名',
  `orig_name` varchar(255) NOT NULL COMMENT '原始檔名',
  `type` varchar(100) NOT NULL COMMENT '圖片類型',
  `path` varchar(200) NOT NULL COMMENT '存放路徑',
  `size` varchar(100) NOT NULL DEFAULT '0' COMMENT '圖大小',
  `width` int(11) NOT NULL COMMENT '圖寬',
  `height` int(11) NOT NULL COMMENT '圖高',
  `sort` int(11) NOT NULL DEFAULT 9999
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `photos`
--

INSERT INTO `photos` (`id`, `imageable_id`, `imageable_type`, `name`, `orig_name`, `type`, `path`, `size`, `width`, `height`, `sort`) VALUES
(1, 1, 'author', '5b7155c1b8ea3VFdIs.jpg', 'architecture-3095716__340.jpg', 'image/jpeg', 'upload/author/', '56214', 510, 340, 9999),
(2, 3, 'topic', '5b71489d0b3df16bHW.jpg', 'nature-3098746__340.jpg', 'image/jpeg', 'upload/topic/', '80049', 545, 340, 9999),
(3, 2, 'topic', '5b7148b4f2c8bCaFRP.jpg', 'forest-3099718__340.jpg', 'image/jpeg', 'upload/topic/', '48738', 509, 340, 9999);

-- --------------------------------------------------------

--
-- 資料表結構 `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `display_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  `created_user` int(11) NOT NULL DEFAULT 0,
  `created_at` bigint(20) DEFAULT NULL,
  `updated_user` int(11) NOT NULL DEFAULT 0,
  `updated_at` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_user`, `created_at`, `updated_user`, `updated_at`) VALUES
(1, 'Servitor', '工讀生', '', 13, 1519710922, 1, 1534152168),
(2, 'Admin', '最高權限', '', 13, 1519711138, 13, 1528944302);

-- --------------------------------------------------------

--
-- 資料表結構 `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 2),
(2, 2),
(3, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_online` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `tags`
--

INSERT INTO `tags` (`id`, `name`, `is_online`) VALUES
(1, '111', 1),
(2, '222', 1),
(3, '333', 1),
(4, '444', 1),
(5, '555', 1),
(6, 'AAA', 1),
(7, 'B', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `tag_topic`
--

CREATE TABLE `tag_topic` (
  `tag_id` int(11) NOT NULL COMMENT 'tags',
  `topic_id` int(11) NOT NULL COMMENT 'topics'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `tag_topic`
--

INSERT INTO `tag_topic` (`tag_id`, `topic_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(3, 1),
(4, 1),
(5, 1),
(5, 2),
(6, 2),
(7, 2);

-- --------------------------------------------------------

--
-- 資料表結構 `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `topic_category_id` int(11) DEFAULT NULL COMMENT 'topic_categories',
  `author_id` int(11) DEFAULT NULL COMMENT 'authors',
  `title` varchar(255) NOT NULL COMMENT '標題',
  `description` text DEFAULT NULL COMMENT '簡述',
  `is_online` tinyint(1) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 9999,
  `onlined_at` bigint(20) DEFAULT NULL COMMENT '預定上稿時間',
  `created_at` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `topics`
--

INSERT INTO `topics` (`id`, `topic_category_id`, `author_id`, `title`, `description`, `is_online`, `sort`, `onlined_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '專題名稱AAA', 'TEST', 1, 9999, NULL, 1534150781, 1534152458),
(2, 2, 2, '專題名稱BBB', 'TEST', 1, 9999, NULL, 1534150787, 1534150892),
(3, 1, 2, '專題名稱ABC', 'TEST', 1, 9999, NULL, 1534150813, 1534152492);

-- --------------------------------------------------------

--
-- 資料表結構 `topic_categories`
--

CREATE TABLE `topic_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_online` tinyint(1) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 9999,
  `created_at` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `topic_categories`
--

INSERT INTO `topic_categories` (`id`, `name`, `is_online`, `sort`, `created_at`, `updated_at`) VALUES
(1, 'AAAA', 1, 1, 1534150725, 1534154547),
(2, 'BBBB', 1, 2, 1534150728, 1534154547),
(3, 'CCCC', 1, 3, 1534150732, 1534154547),
(4, 'DDDD', 1, 4, 1534150736, 1534154547);

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL,
  `deleted_at` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Oliver Kuo', 'oliver@example.com', '$2y$10$jlHrexNGZqyF/CTYRSqPVeGYp5I9oKNVsyhNHjHooZ8hV004AKZJC', NULL, 1530070813, 1534149593, NULL),
(2, 'Test(最高權限)', 'test@example.com', '$2y$10$KlbaFEboNESynHY.B6Jdae6K.Aw9e28.eONYF2sOXGSpHNOwFYNdS', NULL, 1530070813, 1534150947, NULL),
(3, 'aaa(非最高權限)', 'aaa@aaa.aaa', '$2y$10$A4QlgyG0oC3tkRyjkAkGRO93rNrRvO5Q6xABHnVBovQEWM2jCEn1i', NULL, 1530070813, 1534152287, NULL);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `article_topic`
--
ALTER TABLE `article_topic`
  ADD PRIMARY KEY (`topic_id`,`article_id`) USING BTREE;

--
-- 資料表索引 `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `cache`
--
ALTER TABLE `cache`
  ADD UNIQUE KEY `cache_key_unique` (`key`);

--
-- 資料表索引 `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `permission_groups`
--
ALTER TABLE `permission_groups`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 資料表索引 `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 資料表索引 `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 資料表索引 `tag_topic`
--
ALTER TABLE `tag_topic`
  ADD PRIMARY KEY (`tag_id`,`topic_id`) USING BTREE;

--
-- 資料表索引 `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `topic_categories`
--
ALTER TABLE `topic_categories`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用資料表 AUTO_INCREMENT `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表 AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表 AUTO_INCREMENT `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用資料表 AUTO_INCREMENT `permission_groups`
--
ALTER TABLE `permission_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表 AUTO_INCREMENT `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表 AUTO_INCREMENT `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表 AUTO_INCREMENT `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表 AUTO_INCREMENT `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表 AUTO_INCREMENT `topic_categories`
--
ALTER TABLE `topic_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
