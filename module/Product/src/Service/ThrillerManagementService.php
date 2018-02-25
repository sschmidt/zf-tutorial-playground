<?php

namespace Product\Service;

use Product\Form\ThrillerForm;
use Product\Model\Table\BookTable;
use Product\Model\Table\ThrillerTable;
use Product\Model\Thriller;

/**
 * Class ThrillerManagementService
 */
class ThrillerManagementService extends BaseCrudService
{
    /**
     * @var ThrillerTable
     */
    private $thrillerTable;

    /**
     * @var BookTable
     */
    private $bookTable;

    /**
     * ThrillerManagementService constructor.
     *
     * @param ThrillerTable $thrillerTable
     * @param BookTable     $bookTable
     */
    public function __construct(ThrillerTable $thrillerTable, BookTable $bookTable)
    {
        parent::__construct($thrillerTable);

        $this->thrillerTable = $thrillerTable;
        $this->bookTable     = $bookTable;
    }

    /**
     * @return ThrillerForm
     */
    public function createForm(): ThrillerForm
    {
        $form = new ThrillerForm();
        $form->get('submit')->setValue('Add');

        return $form;
    }

    /**
     * @param ThrillerForm $form
     */
    public function createThriller(ThrillerForm $form)
    {
        $thriller = new Thriller();
        $thriller->exchangeArray($form->getData());

        $this->thrillerTable->saveThriller($thriller);
    }

    /**
     * @param int $id
     *
     * @return bool|ThrillerForm
     */
    public function editForm(int $id)
    {
        $thriller = $this->getById($id);
        if ($thriller === null) {
            return false;
        }

        $form = new ThrillerForm();
        $form->bind($thriller);
        $form->get('submit')->setAttribute('value', 'Edit');

        return $form;
    }

    /**
     * @param ThrillerForm $form
     */
    public function updateThriller(ThrillerForm $form)
    {
        $this->thrillerTable->saveThriller($form->getObject());
    }

    /**
     * @param int $bookId
     */
    public function deleteByBookId(int $bookId)
    {
        $this->bookTable->deleteById($bookId);
    }
}