<?php

namespace Product\Model;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;

/**
 * Class Thriller
 *
 * @package Product\Model
 */
class Thriller extends Book
{
    /**
     * @var string
     */
    public $book_id;

    /**
     * @var string
     */
    public $excitement_factor;

    /**
     * @param string[] $data
     */
    public function exchangeArray(array $data)
    {
        $this->id                = $data['id'] ?? null;
        $this->author            = $data['author'] ?? null;
        $this->title             = $data['title'] ?? null;
        $this->isbn              = $data['isbn'] ?? null;
        $this->excitement_factor = $data['excitement_factor'] ?? null;
        $this->book_id           = $data['book_id'] ?? null;
    }

    /**
     * @return InputFilter
     */
    public function getInputFilter()
    {
        $inputFilter = parent::getInputFilter();

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

        $inputFilter->replace($this->getIsbnFilter('book_id'), 'isbn');

        return $inputFilter;
    }

    /**
     * @return string[]
     */
    public function getArrayCopy()
    {
        return [
            'id'                => $this->id,
            'author'            => $this->author,
            'title'             => $this->title,
            'isbn'              => $this->isbn,
            'excitement_factor' => $this->excitement_factor,
            'book_id'           => $this->book_id,
        ];
    }

}