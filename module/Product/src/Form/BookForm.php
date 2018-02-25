<?php

namespace Product\Form;

use Application\Validator\NoRecordExists;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Between;
use Zend\Validator\Isbn;
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
                'name'    => 'isbn',
                'type'    => 'number',
                'options' => [
                    'label' => 'ISBN-13',
                ],
            ]
        );
    }

    /**
     * @return InputFilter
     */
    public function getInputFilter()
    {
        $inputFilter = $this->getBookBaseInputFilter();

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
                    'name'    => Isbn::class,
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

    /**
     * @return InputFilter
     */
    protected function getBookBaseInputFilter(): InputFilter
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

        return $inputFilter;
    }
}
