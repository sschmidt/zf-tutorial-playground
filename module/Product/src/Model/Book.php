<?php

namespace Product\Model;

/**
 * Class Book
 *
 * @package Product\Model
 */
class Book extends Product
{
    /**
     * @var string
     */
    public $author;

    /**
     * @var int|null
     */
    public $isbn;

    /**
     * @param string[] $data
     */
    public function exchangeArray(array $data)
    {
        $this->id     = $data['id'] ?? null;
        $this->author = $data['author'] ?? null;
        $this->title  = $data['title'] ?? null;
        $this->isbn   = $data['isbn'] ?? null;
    }

    /**
     * @return string[]
     */
    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'author' => $this->author,
            'title'  => $this->title,
            'isbn'   => $this->isbn,
        ];
    }
}
