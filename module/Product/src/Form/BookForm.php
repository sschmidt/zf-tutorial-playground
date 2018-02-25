<?php

namespace Product\Form;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Between;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\StringLength;

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

    /**
     * @return InputFilter
     */
    public function getInputFilter()
    {
        $inputFilter = parent::getInputFilter();

        $inputFilter->add(
            [
                'name'       => 'author',
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

        $inputFilter->add($this->getIsbnFilter('id'));

        return $inputFilter;
    }

    /**
     * @param string $excludedId
     *
     * @return string[]
     */
    protected function getIsbnFilter(string $excludedId)
    {
        return [
            'name'       => 'isbn',
            'required'   => false,
            'validators' => [
                [
                    'name'    => Between::class,
                    'options' => [
                        'min' => 9780000000000,
                        'max' => 9999999999999,
                    ],
                ],
                [
                    'name'    => NoRecordExists::class,
                    'options' => [
                        'table'   => 'book',
                        'field'   => 'isbn',
                        'adapter' => GlobalAdapterFeature::getStaticAdapter(),
                        'exclude' => [
                            'field'     => 'id',
                            'formValue' => $excludedId,
                        ],
                    ],
                ],
            ],
        ];
    }
}
