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
-- 테이블 구조 `book`
--

CREATE TABLE IF NOT EXISTS `book` (
  `book_no` int(11) NOT NULL,
  `book_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_author` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_publish` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_price` int(11) DEFAULT '7000',
  `book_year` int(11) DEFAULT '2023'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 테이블의 덤프 데이터 `book`
--

INSERT INTO `book` (`book_no`, `book_name`, `book_author`, `book_publish`, `book_price`, `book_year`) VALUES
(1, '(일러스트)연금술사', '파울로 코엘료', '문학동네', 12000, 2009),
(2, '이득우의 언리얼 C++ 게임 개발의 정석', '이득우', '에이콘', 50000, 2018),
(3, '설민석의 조선왕조실록 : 대한민국이 선택한 역사 이야기', '설민석', '세계사', 22000, 2016),
(4, '해리포터: 마법같은 1년', 'J.K.롤링', '문학수첩리틀북', 26000, 2021),
(5, 'CentOS리눅스 구축관리실무', '정우영', '수퍼유저코리아', 35000, 2016);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_no`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `book`
--
ALTER TABLE `book`
  MODIFY `book_no` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
