<?php

namespace Product\Model\Table;

use Product\Model\Album;
use Zend\Db\TableGateway\TableGateway;

/**
 * Class AlbumTable
 *
 * @package Product\Model\Table
 */
class AlbumTable extends BaseTable
{
    /**
     * @param Album $album
     */
    public function saveAlbum(Album $album)
    {
        $data = [
            'artist' => $album->artist,
            'title'  => $album->title,
        ];

        $id = (int) $album->id;

        $this->insertOrUpdate($id, $data);
    }
}
