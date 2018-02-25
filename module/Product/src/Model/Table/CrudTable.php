<?php

namespace Product\Model\Table;

use Zend\Db\ResultSet\ResultSet;

/**
 * A basic table implementing CRUD functions for a model.
 *
 * @package Product\Model\Table
 */
interface CrudTable
{
    /**
     * @return ResultSet
     */
    public function fetchAll();

    /**
     * @param int $id
     */
    public function getById(int $id);

    /**
     * @param int $id
     */
    public function deleteById(int $id);
}