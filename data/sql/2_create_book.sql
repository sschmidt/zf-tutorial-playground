use `zend`;

CREATE TABLE `book` (
  `id`     INT(11)      UNSIGNED NOT NULL AUTO_INCREMENT,
  `author` VARCHAR(100) NOT NULL,
  `title`  VARCHAR(100) NOT NULL,
  `isbn`   BIGINT(20)   UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`isbn`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = UTF8;


INSERT INTO `book` (`id`, `author`, `title`) VALUES
  (1, 'The Lord of the Rings', 'J. R. R. Tolkien');
