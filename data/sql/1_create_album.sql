use `zend`;

CREATE TABLE `album` (
  `id`     INT(13)      UNSIGNED NOT NULL AUTO_INCREMENT,
  `artist` VARCHAR(100) NOT NULL,
  `title`  VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = UTF8;


INSERT INTO `album` (`id`, `artist`, `title`) VALUES
  (1, 'The Military Wives', 'In My Dreams'),
  (2, 'Adele', '21'),
  (3, 'Bruce Springsteen', 'Wrecking Ball (Deluxe)'),
  (4, 'Lana Del Rey', 'Born To Die'),
  (5, 'Gotye', 'Making Mirrors');
