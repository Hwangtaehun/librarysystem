DROP DATABASE IF EXISTS librarydb;
create database librarydb;
grant all privileges on librarydb.* to mysejong@localhost with grant option;
commit;

USE librarydb;

CREATE TABLE `kind` (
  `kind_no` VARCHAR(10) COLLATE utf8mb4_unicode_ci PRIMARY KEY,
  `kind_name` VARCHAR(30)
);