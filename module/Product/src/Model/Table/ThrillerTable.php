<?php

namespace Product\Model\Table;

use Product\Model\Thriller;
use Zend\Db\TableGateway\TableGateway;

/**
 * Class ThrillerTable
 *
 * @package Product\Model\Table
 */
class ThrillerTable extends BookTable
{
    /**
     * ThrillerTable constructor.
     *
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        parent::__construct($tableGateway);
    }

    /**
     * @param Thriller $thriller
     */
    public function saveThriller(Thriller $thriller)
    {
        $bookData = [
            'author' => $thriller->author,
            'title'  => $thriller->title,
        ];

        if ($thriller->isbn) {
            $bookData['isbn'] = $thriller->isbn;
        } else {
            $bookData['isbn'] = null;
        }

        $id = (int) $thriller->id;

        if ($id !== 0) {
            $this->tableGateway->update($bookData, ['id' => $id]);
            $thrillerData = [
                'excitement_factor' => $thriller->excitement_factor,
            ];
            $this->tableGateway->update($thrillerData, ['id' => $id]);
        } else {
            $this->tableGateway->insert($bookData);
            $thrillerData = [
                'excitement_factor' => $thriller->excitement_factor,
                'book_id'           => $this->tableGateway->getLastInsertValue(),
            ];
            $this->tableGateway->insert($thrillerData);
        }
    }

    /**
     * @param int $id
     */
    public function deleteById(int $id)
    {
        $this->tableGateway->delete(['id' => $id]);
    }
}