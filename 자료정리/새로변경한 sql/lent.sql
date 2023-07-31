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
-- 테이블 구조 `lent`
--

CREATE TABLE IF NOT EXISTS `lent` (
  `len_no` int(11) NOT NULL,
  `mem_no` int(11) DEFAULT NULL,
  `mat_no` int(11) DEFAULT NULL,
  `len_date` date DEFAULT NULL,
  `len_ex` int(11) DEFAULT NULL,
  `len_re_date` date DEFAULT NULL,
  `len_re_st` int(11) NOT NULL DEFAULT '0',
  `len_memo` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 테이블의 덤프 데이터 `lent`
--

INSERT INTO `lent` (`len_no`, `mem_no`, `mat_no`, `len_date`, `len_ex`, `len_re_date`, `len_re_st`, `len_memo`) VALUES
(1, 2, 1, '2023-05-05', 0, NULL, 0, NULL),
(2, 2, 2, '2023-05-08', 7, NULL, 0, NULL),
(3, 3, 3, '2023-04-01', 0, '2023-04-30', 2, '분실-상대방 재구매');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `lent`
--
ALTER TABLE `lent`
  ADD PRIMARY KEY (`len_no`),
  ADD KEY `mem_no` (`mem_no`),
  ADD KEY `mat_no` (`mat_no`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `lent`
--
ALTER TABLE `lent`
  MODIFY `len_no` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `lent`
--
ALTER TABLE `lent`
  ADD CONSTRAINT `lent_ibfk_1` FOREIGN KEY (`mem_no`) REFERENCES `member` (`mem_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `lent_ibfk_2` FOREIGN KEY (`mat_no`) REFERENCES `material` (`mat_no`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
