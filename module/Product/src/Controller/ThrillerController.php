<?php

namespace Product\Controller;

use Product\Form\ThrillerForm;
use Product\Model\Table\BookTable;
use Product\Model\Thriller;
use Product\Model\Table\ThrillerTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class ThrillerController
 *
 * @package Product\Controller
 */
class ThrillerController extends AbstractActionController
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
     * ThrillerController constructor.
     *
     * @param ThrillerTable $thrillerTable
     * @param BookTable     $bookTable
     */
    public function __construct(ThrillerTable $thrillerTable, BookTable $bookTable)
    {
        $this->thrillerTable = $thrillerTable;
        $this->bookTable     = $bookTable;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(
            [
                'thrillers' => $this->thrillerTable->fetchAll(),
            ]
        );
    }

    public function addAction()
    {
        $form = new ThrillerForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $thriller = new Thriller();
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $thriller->exchangeArray($form->getData());
        $this->thrillerTable->saveThriller($thriller);

        return $this->redirect()->toRoute('thriller');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('thriller', ['action' => 'add']);
        }

        try {
            $thriller = $this->thrillerTable->getById($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('thriller', ['action' => 'index']);
        }

        $form = new ThrillerForm();
        $form->bind($thriller);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request  = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }

        $this->thrillerTable->saveThriller($thriller);

        // Redirect to thriller list
        return $this->redirect()->toRoute('thriller', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('thriller');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id       = (int) $request->getPost('id');
                $thriller = $this->thrillerTable->getById($id);
                $this->bookTable->deleteById($thriller->book_id);
            }

            return $this->redirect()->toRoute('thriller');
        }

        return [
            'id'       => $id,
            'thriller' => $this->thrillerTable->getById($id),
        ];
    }
}