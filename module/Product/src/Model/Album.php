<?php

namespace Product\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

/**
 * Class Album
 *
 * @package Product\Model
 */
class Album extends Product
{
    public $artist;

    /**
     * @param string[] $data
     */
    public function exchangeArray(array $data)
    {
        $this->id     = $data['id'] ?? null;
        $this->artist = $data['artist'] ?? null;
        $this->title  = $data['title'] ?? null;
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

    /**
     * @return string[]
     */
    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'artist' => $this->artist,
            'title'  => $this->title,
        ];
    }
}
