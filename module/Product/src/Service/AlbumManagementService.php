<?php

namespace Product\Service;

use Product\Form\AlbumForm;
use Product\Model\Album;
use Product\Model\Table\AlbumTable;
use Zend\Db\Exception\InvalidArgumentException;
use Zend\Db\ResultSet\ResultSet;

/**
 * Class AlbumManagementService
 */
class AlbumManagementService extends BaseCrudService
{

    /**
     * @var AlbumTable
     */
    private $albumTable;

    /**
     * AlbumManagementService constructor.
     *
     * @param AlbumTable $albumTable
     */
    public function __construct(AlbumTable $albumTable)
    {
        parent::__construct($albumTable);

        $this->albumTable = $albumTable;
    }

    /**
     * @return AlbumForm
     */
    public function createForm(): AlbumForm
    {
        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');

        return $form;
    }

    /**
     * @param AlbumForm $form
     */
    public function createAlbum(AlbumForm $form)
    {
        $album = new Album();
        $album->exchangeArray($form->getData());

        $this->albumTable->saveAlbum($album);
    }

    /**
     * @param int $id
     *
     * @return bool|AlbumForm
     */
    public function editForm(int $id)
    {
        $album = $this->getById($id);
        if ($album === null) {
            return false;
        }

        $form = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        return $form;
    }

    /**
     * @param AlbumForm $form
     */
    public function updateAlbum(AlbumForm $form)
    {
        $this->albumTable->saveAlbum($form->getObject());
    }

}