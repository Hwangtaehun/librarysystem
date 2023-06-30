ALTER TABLE `member` ALTER COLUMN `mem_lent` SET DEFAULT 5;

INSERT INTO `library` (`lib_name`, `lib_date`, `add_no`, `lib_detail`) VALUES ('청주청원도서관', '2007-03-21', 4834728, 'null');
INSERT INTO `library` (`lib_name`, `lib_date`, `add_no`, `lib_detail`) VALUES ('청주상당도서관', '2010-03-18', 4794352, 'null');
INSERT INTO `library` (`lib_name`, `lib_date`, `add_no`, `lib_detail`) VALUES ('청주흥덕도서관', '2009-03-31', 4855217, 'null');

INSERT INTO `book` (`book_name`, `book_author`, `book_publish`, `book_price`, `book_year`) VALUES ('(일러스트)연금술사', '파울로 코엘료', '문학동네', 12000, 2009);
INSERT INTO `book` (`book_name`, `book_author`, `book_publish`, `book_price`, `book_year`) VALUES ('이득우의 언리얼 C++ 게임 개발의 정석', '이득우', '에이콘', 50000, 2018);
INSERT INTO `book` (`book_name`, `book_author`, `book_publish`, `book_price`, `book_year`) VALUES ('설민석의 조선왕조실록 : 대한민국이 선택한 역사 이야기', '설민석', '세계사', 22000, 2016);
INSERT INTO `book` (`book_name`, `book_author`, `book_publish`, `book_price`, `book_year`) VALUES ('해리포터: 마법같은 1년', 'J.K.롤링', '문학수첩리틀북', 26000, 2021);

INSERT INTO `member` (`mem_name`, `mem_id`, `mem_pw`, `add_no`, `mem_detail`) VALUES ('황태훈', 'skymemoryblue', 'sj4321', 4847250, '3동 401호');
INSERT INTO `member` (`mem_name`, `mem_id`, `mem_pw`, `add_no`, `mem_detail`, `mem_state`) VALUES ('이정지', 'stopaccount', 'sj4321', 4814353, '103동 502호', 2);

INSERT INTO `material` (`lib_no`, `book_no`, `kind_no`, `mat_many`, `mat_overlap`) VALUES (1, 1, 820, null, '1');
INSERT INTO `material` (`lib_no`, `book_no`, `kind_no`, `mat_many`, `mat_overlap`) VALUES (2, 2, 104, null, '1');
INSERT INTO `material` (`lib_no`, `book_no`, `kind_no`, `mat_many`, `mat_overlap`) VALUES (1, 3, 847, null, '1');
INSERT INTO `material` (`lib_no`, `book_no`, `kind_no`, `mat_many`, `mat_overlap`) VALUES (3, 4, 787, null, '1');

INSERT INTO `lent` (`mem_no`, `mat_no`, `len_date`, `len_ex`) VALUES (2, 1, '2023-05-05', 0);
INSERT INTO `lent` (`mem_no`, `mat_no`, `len_date`, `len_ex`) VALUES (2, 2, '2023-05-08', 7);
INSERT INTO `lent` (`mem_no`, `mat_no`, `len_date`, `len_ex`, `len_re_date`, `len_re_st`, `len_memo`) VALUES (3, 3, '2023-04-01', 0, '2023-04-30', 2, '분실-상대방 재구매');

INSERT INTO `place` (`len_no`, `lib_no_len`) VALUES (1, 1);
INSERT INTO `place` (`len_no`, `lib_no_len`) VALUES (2, 1);

INSERT INTO `delivery` (`mem_no`, `mat_no`, `lib_no_arr`, `del_arr_date`) VALUES (2, 2, 1, '2023-05-07');

INSERT INTO `overdue`(`due_exp`, `len_no`) VALUES ('2023-05-30', 3);

INSERT INTO `reservation` (`res_date`, `mem_no`, `mat_no`)  VALUES ('2023-05-09', 2, 4);