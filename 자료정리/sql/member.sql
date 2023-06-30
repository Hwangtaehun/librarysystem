-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- 생성 시간: 23-06-23 05:12
-- 서버 버전: 5.5.68-MariaDB
-- PHP 버전: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- 테이블 구조 `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `mem_no` int(11) NOT NULL,
  `mem_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mem_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mem_pw` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mem_lent` int(11) DEFAULT '5',
  `mem_state` int(11) NOT NULL DEFAULT '0',
  `add_no` int(11) DEFAULT NULL,
  `mem_detail` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 테이블의 덤프 데이터 `member`
--

INSERT INTO `member` (`mem_no`, `mem_name`, `mem_id`, `mem_pw`, `mem_lent`, `mem_state`, `add_no`, `mem_detail`) VALUES
(1, 'root', 'mysejong', 'sj4321', NULL, 1, NULL, NULL),
(2, '황태훈', 'skymemoryblue', 'sj4321', 5, 0, 4847250, '3동 401호'),
(3, '이정지', 'stopaccount', 'sj4321', 5, 2, 4814353, '103동 502호'),
(4, 'guest', '1111', '1234', 5, 0, 4814735, '12');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`mem_no`),
  ADD UNIQUE KEY `mem_id` (`mem_id`),
  ADD KEY `add_no` (`add_no`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `mem_no` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`add_no`) REFERENCES `address` (`add_no`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
