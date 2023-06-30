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
-- 테이블 구조 `place`
--

CREATE TABLE IF NOT EXISTS `place` (
  `pla_no` int(11) NOT NULL,
  `len_no` int(11) DEFAULT NULL,
  `lib_no_len` int(11) DEFAULT NULL,
  `lib_no_re` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 테이블의 덤프 데이터 `place`
--

INSERT INTO `place` (`pla_no`, `len_no`, `lib_no_len`, `lib_no_re`) VALUES
(1, 1, 1, NULL),
(2, 2, 1, NULL);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`pla_no`),
  ADD KEY `len_no` (`len_no`),
  ADD KEY `lib_no_len` (`lib_no_len`),
  ADD KEY `lib_no_re` (`lib_no_re`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `place`
--
ALTER TABLE `place`
  MODIFY `pla_no` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `place`
--
ALTER TABLE `place`
  ADD CONSTRAINT `place_ibfk_1` FOREIGN KEY (`len_no`) REFERENCES `lent` (`len_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `place_ibfk_2` FOREIGN KEY (`lib_no_len`) REFERENCES `library` (`lib_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `place_ibfk_3` FOREIGN KEY (`lib_no_re`) REFERENCES `library` (`lib_no`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
