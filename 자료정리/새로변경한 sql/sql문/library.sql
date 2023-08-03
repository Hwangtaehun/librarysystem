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
-- 테이블 구조 `library`
--

CREATE TABLE IF NOT EXISTS `library` (
  `lib_no` int(11) NOT NULL,
  `lib_name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lib_date` date NOT NULL,
  `lib_zip` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lib_add` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lib_detail` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 테이블의 덤프 데이터 `library`
--

INSERT INTO `library` (`lib_no`, `lib_name`, `lib_date`, `lib_zip`, `lib_add`, `lib_detail`) VALUES
(1, '청주청원도서관', '2007-03-21', '28341', '충북 청주시 청원구 사뜸로 61번길 88-14', 'null'),
(2, '청주상당도서관', '2010-03-18', '28509', '충북 청주시 상당구 대성로 195', 'null'),
(3, '청주흥덕도서관', '2009-03-31', '28420', '충북 청주시 흥덕구 증안로90번길 34', 'null'),
(4, '청주금빛도서관', '2019-08-28', '28474', '충북 청주시 상당구 호미로 272', 'null');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`lib_no`),
  ADD KEY `add_no` (`add_no`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `library`
--
ALTER TABLE `library`
  MODIFY `lib_no` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- 덤프된 테이블의 제약사항
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
