<?php

namespace Product\Form;

/**
 * Class AlbumForm
 *
 * @package Product\Form
 */
final class AlbumForm extends ProductForm
{
    /**
     * AlbumForm constructor.
     *
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct('album');

        $this->add(
            [
                'name'    => 'artist',
                'type'    => 'text',
                'options' => [
                    'label' => 'Artist',
                ],
            ]
        );
    }
}
