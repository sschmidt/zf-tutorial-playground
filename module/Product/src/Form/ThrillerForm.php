<?php

namespace Product\Form;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;

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

    /**
     * @return InputFilter
     */
    public function getInputFilter()
    {
        $inputFilter = parent::getBookBaseInputFilter();

        $inputFilter->add(
            [
                'name'       => 'excitement_factor',
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

        $inputFilter->add($this->getIsbnFilter('book_id'));

        return $inputFilter;
    }

}