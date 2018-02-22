<?php

namespace Product\Model;

use Application\Validator\NoRecordExists;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Between;
use Zend\Validator\StringLength;

/**
 * Class Book
 *
 * @package Product\Model
 */
class Book extends Product
{
    /**
     * @var string
     */
    public $author;

    /**
     * @var int|null
     */
    public $isbn;

    /**
     * @param string[] $data
     */
    public function exchangeArray(array $data)
    {
        $this->id     = $data['id'] ?? null;
        $this->author = $data['author'] ?? null;
        $this->title  = $data['title'] ?? null;
        $this->isbn   = $data['isbn'] ?? null;
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
     * @return string[]
     */
    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'author' => $this->author,
            'title'  => $this->title,
            'isbn'   => $this->isbn,
        ];
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
