CREATE DATABASE `zend`
  CHARACTER SET utf8
  COLLATE utf8_general_ci;

USE `zend`;

CREATE TABLE `album` (
  `id`     INT(11)      NOT NULL,
  `artist` VARCHAR(100) NOT NULL,
  `title`  VARCHAR(100) NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = UTF8;

ALTER TABLE `album`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `album`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1;
COMMIT;

INSERT INTO `album` (`id`, `artist`, `title`) VALUES
  (1, 'The Military Wives', 'In My Dreams'),
  (2, 'Adele', '21'),
  (3, 'Bruce Springsteen', 'Wrecking Ball (Deluxe)'),
  (4, 'Lana Del Rey', 'Born To Die'),
  (5, 'Gotye', 'Making Mirrors');
