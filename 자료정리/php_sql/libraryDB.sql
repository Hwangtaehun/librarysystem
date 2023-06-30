DROP DATABASE IF EXISTS librarydb;
create database librarydb;
grant all privileges on librarydb.* to mysejong@localhost with grant option;
commit;

USE librarydb;

CREATE TABLE `address` 
(
    `zipcode`        VARCHAR(5) NULL,
    `sido`           VARCHAR(25) NULL,
    `sido_en`        VARCHAR(20) NULL,
    `sigungu`        VARCHAR(30) NULL,
    `sigungu_en`     VARCHAR(30) NULL,
    `eupmyun`        VARCHAR(20) NULL,
    `eupmyun_en`     VARCHAR(25) NULL,
    `doro_code`      VARCHAR(12) NULL,
    `doro`           VARCHAR(40) NULL,
    `doro_en`        VARCHAR(50) NULL,
    `under_yn`       VARCHAR(1) NULL,
    `buildno1`       VARCHAR(5) NULL,
    `buildno2`       VARCHAR(4) NULL,
    `buildnum`       VARCHAR(25) NULL,
    `multiple`       VARCHAR(1) NULL,
    `buildname`      VARCHAR(70) NULL,
    `dong_code`      VARCHAR(10) NULL,
    `dong`           VARCHAR(20) NULL,
    `ri`             VARCHAR(20) NULL,
    `dong_hj`        VARCHAR(30) NULL,
    `mount_yn`       VARCHAR(1) NULL,
    `jibun1`        VARCHAR(4) NULL,
    `eupmyundong_no` VARCHAR(2) NULL,
    `jibun2`         VARCHAR(4) NULL,
    `zipcode_old`    VARCHAR(7) NULL,
    `zipcode_seq`    VARCHAR(3) NULL,
    `add_no`         INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `library` (
  `lib_no` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `lib_name` VARCHAR(10) NOT NULL,
  `lib_date` DATE NOT NULL,
  `add_no` INTEGER,
  `lib_detail` VARCHAR(50),
  FOREIGN KEY (`add_no`) REFERENCES `address`(`add_no`) ON DELETE SET NULL ON UPDATE CASCADE
); 

CREATE TABLE `book` (
  `book_no` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `book_name` VARCHAR(50) NOT NULL,
  `book_author` VARCHAR(20) NOT NULL,
  `book_publish` VARCHAR(20) NOT NULL,
  `book_price` INTEGER DEFAULT 7000 CHECK(`book_price` >= 6000),
  `book_year` INTEGER DEFAULT 2023 CHECK(`book_year` > 1900)
);

CREATE TABLE `kind` (
  `kind_no` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `kind_num` VARCHAR(10) UNIQUE,
  `kind_name` VARCHAR(30)
);

CREATE TABLE `member` (
  `mem_no` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `mem_name` VARCHAR(20) NOT NULL,
  `mem_id` VARCHAR(20) UNIQUE,
  `mem_pw` VARCHAR(20) NOT NULL,
  `mem_lent` INTEGER,
  `mem_state` INTEGER,
  `add_no` INTEGER,
  `mem_detail` VARCHAR(50),
  FOREIGN KEY (`add_no`) REFERENCES `address`(`add_no`)
);

CREATE TABLE `material` (
  `mat_no` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `lib_no` INTEGER,
  `book_no` INTEGER,
  `kind_no` INTEGER,
  `mat_many` VARCHAR(10),
  `mat_overlap` VARCHAR(10),
  FOREIGN KEY (`lib_no`) REFERENCES `library`(`lib_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`book_no`) REFERENCES `book`(`book_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`kind_no`) REFERENCES `kind`(`kind_no`) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE `reservation` (
  `res_no` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `res_date` DATE,
  `mem_no` INTEGER,
  `mat_no` INTEGER,
  FOREIGN KEY (`mem_no`) REFERENCES `member`(`mem_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`mat_no`) REFERENCES `material`(`mat_no`) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE `lent` (
  `len_no` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `mem_no` INTEGER,
  `mat_no` INTEGER,
  `len_date` DATE,
  `len_ex` INTEGER,
  `len_re_date` DATE,
  `len_re_st` INTEGER,
  `len_memo` VARCHAR(30),
  FOREIGN KEY (`mem_no`) REFERENCES `member`(`mem_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`mat_no`) REFERENCES `material`(`mat_no`) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE `overdue` (
  `due_no` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `due_exp` DATE,
  `len_no` INTEGER,
  FOREIGN KEY (`len_no`) REFERENCES `lent`(`len_no`) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE `place` (
  `pla_no` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `len_no` INTEGER,
  `lib_no_len` INTEGER,
  `lib_no_re` INTEGER,
  FOREIGN KEY (`len_no`) REFERENCES `lent`(`len_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`lib_no_len`) REFERENCES `library`(`lib_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`lib_no_re`) REFERENCES `library`(`lib_no`) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE `delivery` (
  `del_no` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `mem_no` INTEGER,
  `mat_no` INTEGER,
  `lib_no_arr` INTEGER,
  `del_arr_date` DATE,
  `del_back` INTEGER,
  FOREIGN KEY (`mem_no`) REFERENCES `member`(`mem_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`mat_no`) REFERENCES `material`(`mat_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`lib_no_arr`) REFERENCES `library`(`lib_no`) ON DELETE SET NULL ON UPDATE CASCADE
);