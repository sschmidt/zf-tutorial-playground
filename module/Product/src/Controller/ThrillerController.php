<?php

namespace Product\Controller;

use Product\Service\ThrillerManagementService;
use Zend\Http\Response;
use Zend\View\Model\ViewModel;

/**
 * Class ThrillerController
 *
 * @package Product\Controller
 */
class ThrillerController extends BaseController
{
    /**
     * @var ThrillerManagementService
     */
    private $thrillerManagementService;

    /**
     * ThrillerController constructor.
     *
     * @param ThrillerManagementService $thrillerManagementService
     */
    public function __construct(ThrillerManagementService $thrillerManagementService)
    {
        $this->thrillerManagementService = $thrillerManagementService;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(
            [
                'thrillers' => $this->thrillerManagementService->fetchAll(),
            ]
        );
    }

    /**
     * @return array|Response
     */
    public function addAction()
    {
        $form = $this->thrillerManagementService->createForm();

        if (!$this->bindAndValidateForm($form)) {
            return ['form' => $form];
        }

        $this->thrillerManagementService->createThriller($form);

        return $this->redirect()->toRoute('thriller');
    }

    /**
     * @return array|Response
     */
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('thriller', ['action' => 'add']);
        }

        $form = $this->thrillerManagementService->editForm($id);
        if (!$form) {
            return $this->redirect()->toRoute('thriller', ['action' => 'index']);
        }

        if (!$this->bindAndValidateForm($form)) {
            return ['form' => $form, 'id' => $id];
        }

        $this->thrillerManagementService->updateThriller($form);

        return $this->redirect()->toRoute('thriller', ['action' => 'index']);
    }

    /**
     * @return array|Response
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('thriller');
        }

        $success = $this->handleDeleteConfirmation(
            function ($id) {
                $thriller = $this->thrillerManagementService->getById($id);
                $this->thrillerManagementService->deleteByBookId($thriller->book_id);
            }
        );

        if ($success) {
            return $this->redirect()->toRoute('thriller');
        }

        return [
            'id'       => $id,
            'thriller' => $this->thrillerManagementService->getById($id),
        ];
    }
}