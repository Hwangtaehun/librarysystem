-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- 생성 시간: 23-07-12 00:28
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
-- 테이블 구조 `overdue`
--

CREATE TABLE `overdue` (
  `due_no` int(11) NOT NULL,
  `due_exp` date DEFAULT NULL,
  `len_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 테이블의 덤프 데이터 `overdue`
--

INSERT INTO `overdue` (`due_no`, `due_exp`, `len_no`) VALUES
(1, '2023-05-30', 3);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `overdue`
--
ALTER TABLE `overdue`
  ADD PRIMARY KEY (`due_no`),
  ADD UNIQUE KEY `len_no` (`len_no`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `overdue`
--
ALTER TABLE `overdue`
  MODIFY `due_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `overdue`
--
ALTER TABLE `overdue`
  ADD CONSTRAINT `overdue_ibfk_1` FOREIGN KEY (`len_no`) REFERENCES `lent` (`len_no`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
