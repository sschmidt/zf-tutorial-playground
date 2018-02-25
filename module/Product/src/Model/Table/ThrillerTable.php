<?php

namespace Product\Model\Table;

use Product\Model\Thriller;

/**
 * Class ThrillerTable
 *
 * @package Product\Model\Table
 */
class ThrillerTable extends BookTable
{
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
}