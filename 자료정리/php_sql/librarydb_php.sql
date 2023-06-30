-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- 생성 시간: 23-05-05 07:06
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
-- 테이블 구조 `address`
--

CREATE TABLE `address` (
  `zipcode` varchar(5) DEFAULT NULL,
  `sido` varchar(25) DEFAULT NULL,
  `sido_en` varchar(20) DEFAULT NULL,
  `sigungu` varchar(30) DEFAULT NULL,
  `sigungu_en` varchar(30) DEFAULT NULL,
  `eupmyun` varchar(20) DEFAULT NULL,
  `eupmyun_en` varchar(25) DEFAULT NULL,
  `doro_code` varchar(12) DEFAULT NULL,
  `doro` varchar(40) DEFAULT NULL,
  `doro_en` varchar(50) DEFAULT NULL,
  `under_yn` varchar(1) DEFAULT NULL,
  `buildno1` varchar(5) DEFAULT NULL,
  `buildno2` varchar(4) DEFAULT NULL,
  `buildnum` varchar(25) DEFAULT NULL,
  `multiple` varchar(1) DEFAULT NULL,
  `buildname` varchar(70) DEFAULT NULL,
  `dong_code` varchar(10) DEFAULT NULL,
  `dong` varchar(20) DEFAULT NULL,
  `ri` varchar(20) DEFAULT NULL,
  `dong_hj` varchar(30) DEFAULT NULL,
  `mount_yn` varchar(1) DEFAULT NULL,
  `jibun1` varchar(4) DEFAULT NULL,
  `eupmyundong_no` varchar(2) DEFAULT NULL,
  `jibun2` varchar(4) DEFAULT NULL,
  `zipcode_old` varchar(7) DEFAULT NULL,
  `zipcode_seq` varchar(3) DEFAULT NULL,
  `add_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `book`
--

CREATE TABLE `book` (
  `book_no` int(11) NOT NULL,
  `book_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_author` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_publish` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_price` int(11) DEFAULT 7000 CHECK (`book_price` >= 6000),
  `book_year` int(11) DEFAULT 2023 CHECK (`book_year` > 1900)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `delivery`
--

CREATE TABLE `delivery` (
  `del_no` int(11) NOT NULL,
  `mem_no` int(11) DEFAULT NULL,
  `mat_no` int(11) DEFAULT NULL,
  `lib_no_arr` int(11) DEFAULT NULL,
  `del_arr_date` date DEFAULT NULL,
  `del_back` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `kind`
--

CREATE TABLE `kind` (
  `kind_no` int(11) NOT NULL,
  `kind_num` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kind_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `lent`
--

CREATE TABLE `lent` (
  `len_no` int(11) NOT NULL,
  `mem_no` int(11) DEFAULT NULL,
  `mat_no` int(11) DEFAULT NULL,
  `len_date` date DEFAULT NULL,
  `len_ex` int(11) DEFAULT NULL,
  `len_re_date` date DEFAULT NULL,
  `len_re_st` int(11) DEFAULT NULL,
  `len_memo` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `library`
--

CREATE TABLE `library` (
  `lib_no` int(11) NOT NULL,
  `lib_name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lib_date` date NOT NULL,
  `add_no` int(11) DEFAULT NULL,
  `lib_detail` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `material`
--

CREATE TABLE `material` (
  `mat_no` int(11) NOT NULL,
  `lib_no` int(11) DEFAULT NULL,
  `book_no` int(11) DEFAULT NULL,
  `kind_no` int(11) DEFAULT NULL,
  `mat_many` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mat_overlap` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `member`
--

CREATE TABLE `member` (
  `mem_no` int(11) NOT NULL,
  `mem_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mem_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mem_pw` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mem_lent` int(11) DEFAULT NULL,
  `mem_state` int(11) DEFAULT NULL,
  `add_no` int(11) DEFAULT NULL,
  `mem_detail` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `overdue`
--

CREATE TABLE `overdue` (
  `due_no` int(11) NOT NULL,
  `due_exp` date DEFAULT NULL,
  `len_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `place`
--

CREATE TABLE `place` (
  `pla_no` int(11) NOT NULL,
  `len_no` int(11) DEFAULT NULL,
  `lib_no_len` int(11) DEFAULT NULL,
  `lib_no_re` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `reservation`
--

CREATE TABLE `reservation` (
  `res_no` int(11) NOT NULL,
  `res_date` date DEFAULT NULL,
  `mem_no` int(11) DEFAULT NULL,
  `mat_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`add_no`);

--
-- 테이블의 인덱스 `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_no`);

--
-- 테이블의 인덱스 `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`del_no`),
  ADD KEY `mem_no` (`mem_no`),
  ADD KEY `mat_no` (`mat_no`),
  ADD KEY `lib_no_arr` (`lib_no_arr`);

--
-- 테이블의 인덱스 `kind`
--
ALTER TABLE `kind`
  ADD PRIMARY KEY (`kind_no`),
  ADD UNIQUE KEY `kind_num` (`kind_num`);

--
-- 테이블의 인덱스 `lent`
--
ALTER TABLE `lent`
  ADD PRIMARY KEY (`len_no`),
  ADD KEY `mem_no` (`mem_no`),
  ADD KEY `mat_no` (`mat_no`);

--
-- 테이블의 인덱스 `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`lib_no`),
  ADD KEY `add_no` (`add_no`);

--
-- 테이블의 인덱스 `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`mat_no`),
  ADD KEY `lib_no` (`lib_no`),
  ADD KEY `book_no` (`book_no`),
  ADD KEY `kind_no` (`kind_no`);

--
-- 테이블의 인덱스 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`mem_no`),
  ADD UNIQUE KEY `mem_id` (`mem_id`),
  ADD KEY `add_no` (`add_no`);

--
-- 테이블의 인덱스 `overdue`
--
ALTER TABLE `overdue`
  ADD PRIMARY KEY (`due_no`),
  ADD KEY `len_no` (`len_no`);

--
-- 테이블의 인덱스 `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`pla_no`),
  ADD KEY `len_no` (`len_no`),
  ADD KEY `lib_no_len` (`lib_no_len`),
  ADD KEY `lib_no_re` (`lib_no_re`);

--
-- 테이블의 인덱스 `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`res_no`),
  ADD KEY `mem_no` (`mem_no`),
  ADD KEY `mat_no` (`mat_no`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `address`
--
ALTER TABLE `address`
  MODIFY `add_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `book`
--
ALTER TABLE `book`
  MODIFY `book_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `delivery`
--
ALTER TABLE `delivery`
  MODIFY `del_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `kind`
--
ALTER TABLE `kind`
  MODIFY `kind_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `lent`
--
ALTER TABLE `lent`
  MODIFY `len_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `library`
--
ALTER TABLE `library`
  MODIFY `lib_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `material`
--
ALTER TABLE `material`
  MODIFY `mat_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `mem_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `overdue`
--
ALTER TABLE `overdue`
  MODIFY `due_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `place`
--
ALTER TABLE `place`
  MODIFY `pla_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `reservation`
--
ALTER TABLE `reservation`
  MODIFY `res_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`mem_no`) REFERENCES `member` (`mem_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `delivery_ibfk_2` FOREIGN KEY (`mat_no`) REFERENCES `material` (`mat_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `delivery_ibfk_3` FOREIGN KEY (`lib_no_arr`) REFERENCES `library` (`lib_no`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `lent`
--
ALTER TABLE `lent`
  ADD CONSTRAINT `lent_ibfk_1` FOREIGN KEY (`mem_no`) REFERENCES `member` (`mem_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `lent_ibfk_2` FOREIGN KEY (`mat_no`) REFERENCES `material` (`mat_no`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `library`
--
ALTER TABLE `library`
  ADD CONSTRAINT `library_ibfk_1` FOREIGN KEY (`add_no`) REFERENCES `address` (`add_no`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `material_ibfk_1` FOREIGN KEY (`lib_no`) REFERENCES `library` (`lib_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `material_ibfk_2` FOREIGN KEY (`book_no`) REFERENCES `book` (`book_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `material_ibfk_3` FOREIGN KEY (`kind_no`) REFERENCES `kind` (`kind_no`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`add_no`) REFERENCES `address` (`add_no`);

--
-- 테이블의 제약사항 `overdue`
--
ALTER TABLE `overdue`
  ADD CONSTRAINT `overdue_ibfk_1` FOREIGN KEY (`len_no`) REFERENCES `lent` (`len_no`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `place`
--
ALTER TABLE `place`
  ADD CONSTRAINT `place_ibfk_1` FOREIGN KEY (`len_no`) REFERENCES `lent` (`len_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `place_ibfk_2` FOREIGN KEY (`lib_no_len`) REFERENCES `library` (`lib_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `place_ibfk_3` FOREIGN KEY (`lib_no_re`) REFERENCES `library` (`lib_no`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`mem_no`) REFERENCES `member` (`mem_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`mat_no`) REFERENCES `material` (`mat_no`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
