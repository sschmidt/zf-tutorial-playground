<?php

namespace Album\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Class AlbumTable
 *
 * @package Album\Model
 */
class AlbumTable
{
    private $tableGateway;

    /**
     * AlbumTable constructor.
     *
     * @param TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getAlbum(int $id)
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

    public function saveAlbum(Album $album)
    {
        $data = [
            'artist' => $album->artist,
            'title'  => $album->title,
        ];

        $id = (int) $album->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);

            return;
        }

        if (!$this->getAlbum($id)) {
            throw new RuntimeException(
                sprintf(
                    'Cannot update album with identifier %d; does not exist',
                    $id
                )
            );
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteAlbum(int $id)
    {
        $this->tableGateway->delete(['id' => $id]);
    }
}
