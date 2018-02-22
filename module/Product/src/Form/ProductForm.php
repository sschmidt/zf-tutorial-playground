<?php

namespace Product\Form;

use Zend\Form\Form;

/**
 * Class ProductForm
 *
 * @package Product\Form
 */
abstract class ProductForm extends Form
{

    /**
     * ProductForm constructor.
     *
     * @param string|null $name
     */
    public function __construct(string $name = null)
    {
        parent::__construct($name);

        $this->add(
            [
                'name' => 'id',
                'type' => 'hidden',
            ]
        );
        $this->add(
            [
                'name'    => 'title',
                'type'    => 'text',
                'options' => [
                    'label' => 'Title',
                ],
            ]
        );
        $this->add(
            [
                'name'       => 'submit',
                'type'       => 'submit',
                'attributes' => [
                    'value' => 'Go',
                    'id'    => 'submitbutton',
                ],
            ]
        );
    }
}