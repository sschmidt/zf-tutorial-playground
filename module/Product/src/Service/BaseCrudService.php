<?php

namespace Product\Service;

use Product\Model\Table\CrudTable;
use Zend\Db\Exception\InvalidArgumentException;
use Zend\Db\ResultSet\ResultSet;

/**
 * Class BaseCrudService
 *
 * @package Product\Service
 */
abstract class BaseCrudService
{
    /**
     * @var CrudTable
     */
    private $crudTable;

    /**
     * BaseCrudService constructor.
     *
     * @param CrudTable $crudTable
     */
    public function __construct(CrudTable $crudTable)
    {
        $this->crudTable = $crudTable;
    }

    /**
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->crudTable->fetchAll();
    }

    /**
     * @param int $id
     *
     * @return \ArrayObject|null
     */
    public function getById(int $id)
    {
        try {
            return $this->crudTable->getById($id);
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * @param int $id
     */
    public function deleteById(int $id)
    {
        $this->crudTable->deleteById($id);
    }

}