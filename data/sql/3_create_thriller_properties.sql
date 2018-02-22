use `zend`;

CREATE TABLE `thriller_attributes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` int(11) UNSIGNED NOT NULL,
  `excitement_factor` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`book_id`),
  FOREIGN KEY (book_id) REFERENCES book(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
