USE librarydb;

CREATE TABLE `notification` (
  `not_no` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `not_name` VARCHAR(50) DEFAULT 'NULL',
  `not_detail` VARCHAR(200) DEFAULT 'NULL',
  `not_op_date` DATE,
  `not_cl_date` DATE,
  `not_det_url` VARCHAR(256),
  `not_ban_url` VARCHAR(256),
  `not_pop_url` VARCHAR(256),
  `not_pop_wid` INTEGER,
  `not_pop_hei` INTEGER,
  `not_pop_x` INTEGER,
  `not_pop_y` INTEGER,
  `mem_no` INTEGER,
  FOREIGN KEY (`mem_no`) REFERENCES `member`(`mem_no`) ON DELETE SET NULL ON UPDATE CASCADE
);