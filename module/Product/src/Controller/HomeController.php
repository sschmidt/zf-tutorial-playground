<?php

namespace Product\Controller;

use Product\Model\Table\AlbumTable;
use Product\Model\Table\BookTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class HomeController
 *
 * @package Product\Controller
 */
class HomeController extends AbstractActionController
{
    /**
     * @var BookTable
     */
    private $bookTable;

    /**
     * @var AlbumTable
     */
    private $albumTable;

    /**
     * AlbumController constructor.
     *
     * @param AlbumTable $table
     * @param BookTable  $bookTable
     */
    public function __construct(AlbumTable $table, BookTable $bookTable)
    {
        $this->albumTable = $table;
        $this->bookTable  = $bookTable;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(
            [
                'albums' => $this->albumTable->fetchAll(),
                'books'  => $this->bookTable->fetchAll(),
            ]
        );
    }
}
