<?php

namespace Product\Form;

/**
 * Class ThrillerForm
 *
 * @package Product\Form
 */
class ThrillerForm extends BookForm
{

    /**
     * ThrillerForm constructor.
     *
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct('thriller');

        $this->add(
            [
                'name'    => 'excitement_factor',
                'type'    => 'text',
                'options' => [
                    'label' => 'Excitement Factor',
                ],
            ]
        );

        $this->add(
            [
                'name' => 'book_id',
                'type' => 'hidden',
            ]
        );
    }
}