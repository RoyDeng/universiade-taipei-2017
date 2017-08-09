-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 2017-08-09 14:02:02
-- 伺服器版本: 10.1.21-MariaDB
-- PHP 版本： 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `tsu`
--

-- --------------------------------------------------------

--
-- 資料表結構 `abnormal`
--

CREATE TABLE `abnormal` (
  `id` int(11) NOT NULL,
  `eqpt_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `remark` varchar(100) NOT NULL,
  `pic` blob,
  `signature` blob,
  `report` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `check_log`
--

CREATE TABLE `check_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_detail_id` int(11) NOT NULL,
  `check_in_time` timestamp NULL DEFAULT NULL,
  `check_out_time` timestamp NULL DEFAULT NULL,
  `period` double DEFAULT NULL,
  `extra` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `eqpt`
--

CREATE TABLE `eqpt` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `unit` varchar(2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `check_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `form`
--

CREATE TABLE `form` (
  `id` int(11) NOT NULL,
  `form_id` varchar(20) DEFAULT NULL,
  `item_detail_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_time` timestamp NULL DEFAULT NULL,
  `updated_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `item_detail`
--

CREATE TABLE `item_detail` (
  `id` int(11) NOT NULL,
  `abbr` varchar(20) NOT NULL,
  `item_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `created_time` timestamp NULL DEFAULT NULL,
  `updated_time` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `created_time` timestamp NULL DEFAULT NULL,
  `updated_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `note`
--

CREATE TABLE `note` (
  `id` int(11) NOT NULL,
  `item_detail_id` int(11) NOT NULL,
  `remark` varchar(100) NOT NULL,
  `created_time` timestamp NULL DEFAULT NULL,
  `updated_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `token` varchar(100) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `abnormal`
--
ALTER TABLE `abnormal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_report_eqpt1_idx` (`eqpt_id`),
  ADD KEY `fk_abnormal_form1_idx` (`form_id`);

--
-- 資料表索引 `check_log`
--
ALTER TABLE `check_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sign_log_user1_idx` (`user_id`),
  ADD KEY `fk_check_log_item_detail1_idx` (`item_detail_id`);

--
-- 資料表索引 `eqpt`
--
ALTER TABLE `eqpt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_eqpt_form1_idx` (`form_id`);

--
-- 資料表索引 `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_form_user1_idx` (`user_id`),
  ADD KEY `fk_form_item_detail1_idx` (`item_detail_id`);

--
-- 資料表索引 `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `item_detail`
--
ALTER TABLE `item_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_item_detail_item1_idx` (`item_id`),
  ADD KEY `fk_item_detail_location1_idx` (`location_id`);

--
-- 資料表索引 `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_note_item_detail1_idx` (`item_detail_id`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `abnormal`
--
ALTER TABLE `abnormal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- 使用資料表 AUTO_INCREMENT `check_log`
--
ALTER TABLE `check_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;
--
-- 使用資料表 AUTO_INCREMENT `eqpt`
--
ALTER TABLE `eqpt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2361;
--
-- 使用資料表 AUTO_INCREMENT `form`
--
ALTER TABLE `form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;
--
-- 使用資料表 AUTO_INCREMENT `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- 使用資料表 AUTO_INCREMENT `item_detail`
--
ALTER TABLE `item_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
--
-- 使用資料表 AUTO_INCREMENT `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- 使用資料表 AUTO_INCREMENT `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- 使用資料表 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;
--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `abnormal`
--
ALTER TABLE `abnormal`
  ADD CONSTRAINT `fk_abnormal_form1` FOREIGN KEY (`form_id`) REFERENCES `form` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_report_eqpt1` FOREIGN KEY (`eqpt_id`) REFERENCES `eqpt` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 資料表的 Constraints `check_log`
--
ALTER TABLE `check_log`
  ADD CONSTRAINT `fk_check_log_item_detail1` FOREIGN KEY (`item_detail_id`) REFERENCES `item_detail` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_check_log_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 資料表的 Constraints `eqpt`
--
ALTER TABLE `eqpt`
  ADD CONSTRAINT `fk_eqpt_form1` FOREIGN KEY (`form_id`) REFERENCES `form` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 資料表的 Constraints `form`
--
ALTER TABLE `form`
  ADD CONSTRAINT `fk_form_item_detail1` FOREIGN KEY (`item_detail_id`) REFERENCES `item_detail` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_form_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 資料表的 Constraints `item_detail`
--
ALTER TABLE `item_detail`
  ADD CONSTRAINT `fk_item_detail_item1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_item_detail_location1` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 資料表的 Constraints `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `fk_note_item_detail1` FOREIGN KEY (`item_detail_id`) REFERENCES `item_detail` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
