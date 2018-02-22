<?php

namespace Product\Controller;

use Product\Form\BookForm;
use Product\Model\Book;
use Product\Model\Table\BookTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class BookController
 *
 * @package Product\Controller
 */
class BookController extends AbstractActionController
{

    /**
     * @var BookTable
     */
    private $bookTable;

    /**
     * BookController constructor.
     *
     * @param BookTable $bookTable
     */
    public function __construct(BookTable $bookTable)
    {
        $this->bookTable = $bookTable;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(
            [
                'books' => $this->bookTable->fetchAll(),
            ]
        );
    }

    public function addAction()
    {
        $form = new BookForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $book = new Book();
        $form->setInputFilter($book->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $book->exchangeArray($form->getData());
        $this->bookTable->saveBook($book);

        return $this->redirect()->toRoute('book');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('book', ['action' => 'add']);
        }

        try {
            $book = $this->bookTable->getById($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('book', ['action' => 'index']);
        }

        $form = new BookForm();
        $form->bind($book);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request  = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($book->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }

        $this->bookTable->saveBook($book);

        // Redirect to book list
        return $this->redirect()->toRoute('book', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('book');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->bookTable->deleteById($id);
            }

            return $this->redirect()->toRoute('book');
        }

        return [
            'id'   => $id,
            'book' => $this->bookTable->getById($id),
        ];
    }
}