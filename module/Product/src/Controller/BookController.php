<?php

namespace Product\Controller;

use Product\Service\BookManagementService;
use Zend\Http\Response;
use Zend\View\Model\ViewModel;

/**
 * Class BookController
 *
 * @package Product\Controller
 */
class BookController extends BaseController
{
    /**
     * @var BookManagementService
     */
    private $bookManagementService;

    /**
     * BookController constructor.
     *
     * @param BookManagementService $bookManagementService
     */
    public function __construct(BookManagementService $bookManagementService)
    {
        $this->bookManagementService = $bookManagementService;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(
            [
                'books' => $this->bookManagementService->fetchAll(),
            ]
        );
    }

    /**
     * @return array|Response
     */
    public function addAction()
    {
        $form = $this->bookManagementService->createForm();

        if (!$this->bindAndValidateForm($form)) {
            return ['form' => $form];
        }

        $this->bookManagementService->createBook($form);

        return $this->redirect()->toRoute('book');
    }

    /**
     * @return array|Response
     */
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('book', ['action' => 'add']);
        }

        $form = $this->bookManagementService->editForm($id);
        if (!$form) {
            return $this->redirect()->toRoute('book', ['action' => 'index']);
        }

        if (!$this->bindAndValidateForm($form)) {
            return ['form' => $form, 'id' => $id];
        }

        $this->bookManagementService->updateBook($form);

        return $this->redirect()->toRoute('book', ['action' => 'index']);
    }

    /**
     * @return array|Response
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('book');
        }

        $success = $this->handleDeleteConfirmation(
            function ($id) {
                $this->bookManagementService->deleteById($id);
            }
        );

        if ($success) {
            return $this->redirect()->toRoute('book');
        }

        return [
            'id'   => $id,
            'book' => $this->bookManagementService->getById($id),
        ];
    }
}