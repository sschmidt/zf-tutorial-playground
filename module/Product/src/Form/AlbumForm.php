<?php

namespace Product\Form;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;

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

    /**
     * @return InputFilter
     */
    public function getInputFilter()
    {
        $inputFilter = parent::getInputFilter();

        $inputFilter->add(
            [
                'name'       => 'artist',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ],
                    ],
                ],
            ]
        );

        return $inputFilter;
    }

}
