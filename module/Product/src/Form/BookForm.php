<?php

namespace Product\Form;

/**
 * Class BookForm
 *
 * @package Product\Form
 */
class BookForm extends ProductForm
{
    /**
     * BookForm constructor.
     *
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct('book');

        $this->add(
            [
                'name'    => 'author',
                'type'    => 'text',
                'options' => [
                    'label' => 'Author',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'isbn',
                'type'       => 'number',
                'options'    => [
                    'label' => 'ISBN-13',
                ],
                'attributes' => [
                    'min' => 9780000000000,
                    'max' => 9999999999999,
                ],
            ]
        );
    }
}
