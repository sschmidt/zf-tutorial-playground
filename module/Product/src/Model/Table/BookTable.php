<?php

namespace Product\Model\Table;

use Product\Model\Book;
use Zend\Db\TableGateway\TableGateway;

/**
 * Class BookTable
 *
 * @package Product\Form
 */
class BookTable extends BaseTable
{
    /**
     * BookTable constructor.
     *
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        parent::__construct($tableGateway);
    }

    /**
     * @param Book $book
     */
    public function saveBook(Book $book)
    {
        $data = [
            'author' => $book->author,
            'title'  => $book->title,
        ];

        if ($book->isbn) {
            $data['isbn'] = $book->isbn;
        } else {
            $data['isbn'] = null;
        }

        $id = (int) $book->id;

        $this->insertOrUpdate($id, $data);
    }
}