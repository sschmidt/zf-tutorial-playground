use `zend`;

CREATE VIEW `thriller` AS
  select
    t.id AS id,
    t.book_id AS book_id,
    b.author AS author,
    b.title AS title,
    b.isbn AS isbn,
    t.excitement_factor AS excitement_factor
  from (thriller_attributes t join book b) where (b.id = t.book_id)