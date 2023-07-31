-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- 생성 시간: 23-06-23 05:11
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
-- 테이블 구조 `delivery`
--

CREATE TABLE IF NOT EXISTS `delivery` (
  `del_no` int(11) NOT NULL,
  `mem_no` int(11) DEFAULT NULL,
  `mat_no` int(11) DEFAULT NULL,
  `lib_no_arr` int(11) DEFAULT NULL,
  `del_arr_date` date DEFAULT NULL,
  `del_app` int(11) NOT NULL DEFAULT '0',
  `len_no` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 테이블의 덤프 데이터 `delivery`
--

INSERT INTO `delivery` (`del_no`, `mem_no`, `mat_no`, `lib_no_arr`, `del_arr_date`, `del_app`, `len_no`) VALUES
(1, 2, 2, 1, '2023-05-07', 1, NULL),
(2, 4, 5, 2, NULL, 0, NULL);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`del_no`),
  ADD UNIQUE KEY `len_no` (`len_no`),
  ADD KEY `mem_no` (`mem_no`),
  ADD KEY `mat_no` (`mat_no`),
  ADD KEY `lib_no_arr` (`lib_no_arr`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `delivery`
--
ALTER TABLE `delivery`
  MODIFY `del_no` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`mem_no`) REFERENCES `member` (`mem_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `delivery_ibfk_2` FOREIGN KEY (`mat_no`) REFERENCES `material` (`mat_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `delivery_ibfk_3` FOREIGN KEY (`lib_no_arr`) REFERENCES `library` (`lib_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `delivery_ibfk_4` FOREIGN KEY (`len_no`) REFERENCES `lent` (`len_no`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
