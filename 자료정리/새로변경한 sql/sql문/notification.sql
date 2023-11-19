-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- 생성 시간: 23-11-19 11:23
-- 서버 버전: 10.4.25-MariaDB
-- PHP 버전: 8.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `librarydb`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `notification`
--

CREATE TABLE `notification` (
  `not_no` int(11) NOT NULL,
  `not_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'NULL',
  `not_detail` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT 'NULL',
  `not_op_date` date NOT NULL,
  `not_cl_date` date DEFAULT NULL,
  `not_ban_url` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `not_pop_url` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `not_pop_wid` int(11) DEFAULT NULL,
  `not_pop_hei` int(11) DEFAULT NULL,
  `not_pop_x` int(11) DEFAULT NULL,
  `not_pop_y` int(11) DEFAULT NULL,
  `mem_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`not_no`),
  ADD KEY `mem_no` (`mem_no`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `notification`
--
ALTER TABLE `notification`
  MODIFY `not_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`mem_no`) REFERENCES `member` (`mem_no`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
