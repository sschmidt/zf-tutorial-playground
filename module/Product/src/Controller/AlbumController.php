<?php

namespace Product\Controller;

use Product\Service\AlbumManagementService;
use Product\Service\BookManagementService;
use Zend\Http\Response;
use Zend\View\Model\ViewModel;

/**
 * Class AlbumController
 *
 * @package Product\Controller
 */
class AlbumController extends BaseController
{
    /**
     * @var BookManagementService
     */
    private $albumManagementService;

    /**
     * AlbumController constructor.
     *
     * @param AlbumManagementService $albumManagementService
     */
    public function __construct(AlbumManagementService $albumManagementService)
    {
        $this->albumManagementService = $albumManagementService;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(
            [
                'albums' => $this->albumManagementService->fetchAll(),
            ]
        );
    }

    /**
     * @return array|Response
     */
    public function addAction()
    {
        $form = $this->albumManagementService->createForm();

        if (!$this->bindAndValidateForm($form)) {
            return ['form' => $form];
        }

        $this->albumManagementService->createAlbum($form);

        return $this->redirect()->toRoute('album');
    }

    /**
     * @return array|Response
     */
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('album', ['action' => 'add']);
        }

        $form = $this->albumManagementService->editForm($id);
        if (!$form) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }

        if (!$this->bindAndValidateForm($form)) {
            return ['form' => $form, 'id' => $id];
        }

        $this->albumManagementService->updateAlbum($form);

        return $this->redirect()->toRoute('album', ['action' => 'index']);
    }

    /**
     * @return array|Response
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }

        $success = $this->handleDeleteConfirmation(
            function ($id) {
                $this->albumManagementService->deleteById($id);
            }
        );

        if ($success) {
            return $this->redirect()->toRoute('album');
        }

        return [
            'id'    => $id,
            'album' => $this->albumManagementService->getById($id),
        ];
    }
}