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
-- 테이블 구조 `material`
--

CREATE TABLE IF NOT EXISTS `material` (
  `mat_no` int(11) NOT NULL,
  `lib_no` int(11) DEFAULT NULL,
  `book_no` int(11) DEFAULT NULL,
  `kind_no` int(11) DEFAULT NULL,
  `mat_many` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `mat_overlap` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'c.1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 테이블의 덤프 데이터 `material`
--

INSERT INTO `material` (`mat_no`, `lib_no`, `book_no`, `kind_no`, `mat_many`, `mat_overlap`) VALUES
(1, 1, 1, 820, '0', 'c.1'),
(2, 2, 2, 104, '0', 'c.1'),
(3, 1, 3, 847, '0', 'c.1'),
(4, 3, 4, 787, '0', 'c.1'),
(5, 1, 5, 104, '0', 'c.1');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`mat_no`),
  ADD KEY `lib_no` (`lib_no`),
  ADD KEY `book_no` (`book_no`),
  ADD KEY `kind_no` (`kind_no`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `material`
--
ALTER TABLE `material`
  MODIFY `mat_no` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `material_ibfk_1` FOREIGN KEY (`lib_no`) REFERENCES `library` (`lib_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `material_ibfk_2` FOREIGN KEY (`book_no`) REFERENCES `book` (`book_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `material_ibfk_3` FOREIGN KEY (`kind_no`) REFERENCES `kind` (`kind_no`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
