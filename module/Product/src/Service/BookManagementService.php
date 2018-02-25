<?php

namespace Product\Service;

use Product\Form\BookForm;
use Product\Model\Book;
use Product\Model\Table\BookTable;

/**
 * Class BookManagementService
 */
class BookManagementService extends BaseCrudService
{
    /**
     * @var BookTable
     */
    private $bookTable;

    /**
     * BookManagementService constructor.
     *
     * @param BookTable $bookTable
     */
    public function __construct(BookTable $bookTable)
    {
        parent::__construct($bookTable);

        $this->bookTable = $bookTable;
    }

    /**
     * @return BookForm
     */
    public function createForm(): BookForm
    {
        $form = new BookForm();
        $form->get('submit')->setValue('Add');

        return $form;
    }

    /**
     * @param BookForm $form
     */
    public function createBook(BookForm $form)
    {
        $book = new Book();
        $book->exchangeArray($form->getData());

        $this->bookTable->saveBook($book);
    }

    /**
     * @param int $id
     *
     * @return bool|BookForm
     */
    public function editForm(int $id)
    {
        $book = $this->getById($id);
        if ($book === null) {
            return false;
        }

        $form = new BookForm();
        $form->bind($book);
        $form->get('submit')->setAttribute('value', 'Edit');

        return $form;
    }

    /**
     * @param BookForm $form
     */
    public function updateBook(BookForm $form)
    {
        $this->bookTable->saveBook($form->getObject());
    }
}