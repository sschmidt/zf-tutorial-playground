<?php

namespace Album\Controller;

use Album\Model\AlbumTable;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class AlbumController
 *
 * @package Album\Controller
 */
class AlbumController extends AbstractActionController
{
    private $table;

    /**
     * AlbumController constructor.
     *
     * @param AlbumTable $table
     */
    public function __construct(AlbumTable $table)
    {
        $this->table = $table;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(
            [
                'albums' => $this->table->fetchAll(),
            ]
        );
    }

}