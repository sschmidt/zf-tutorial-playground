<?php

namespace Product\Model\Table;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

/**
 * Class BaseTable
 * @package Product\Model\Table
 */
abstract class BaseTable
{

    protected $tableGateway;

    /**
     * BaseTable constructor.
     *
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * @param int $id
     *
     * @return array|\ArrayObject|null
     */
    public function getById(int $id)
    {
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row    = $rowset->current();
        if (!$row) {
            throw new RuntimeException(
                sprintf(
                    'Could not find row with identifier %d',
                    $id
                )
            );
        }

        return $row;
    }

    /**
     * @param int $id
     */
    public function deleteById(int $id)
    {
        $this->tableGateway->delete(['id' => $id]);
    }

    /**
     * @param int   $id
     * @param array $data
     */
    protected function insertOrUpdate(int $id, array $data)
    {
        if ($id === 0) {
            $this->tableGateway->insert($data);

            return;
        }

        if (!$this->getById($id)) {
            throw new RuntimeException(
                sprintf(
                    'Cannot update model with identifier %d; does not exist',
                    $id
                )
            );
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }
}