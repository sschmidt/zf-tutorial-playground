<?php

namespace Product\Form;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;

/**
 * Class ProductForm
 *
 * @package Product\Form
 */
abstract class ProductForm extends Form
{

    /**
     * @var InputFilter
     */
    private $inputFilter;

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

    /**
     * @return InputFilter
     */
    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add(
            [
                'name'     => 'id',
                'required' => true,
                'filters'  => [
                    ['name' => ToInt::class],
                ],
            ]
        );

        $inputFilter->add(
            [
                'name'       => 'title',
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

        $this->inputFilter = $inputFilter;

        return $this->inputFilter;
    }
}