<?php

namespace Product\Controller;

use Zend\Form\Form;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class BaseController
 *
 * @package Product\Controller
 */
class BaseController extends AbstractActionController
{

    /**
     * @param Form $form
     *
     * @return bool
     */
    protected function bindAndValidateForm(Form $form)
    {
        /** @var Request $request */
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return false;
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return false;
        }

        return true;
    }

    /**
     * @param callable $deleteCallback
     *
     * @return bool
     */
    protected function handleDeleteConfirmation(callable $deleteCallback)
    {
        /** @var Request $request */
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return false;
        }

        $del = $request->getPost('del', 'No');

        if ($del == 'Yes') {
            $id = (int) $request->getPost('id');
            $deleteCallback($id);
        }

        return true;
    }
}