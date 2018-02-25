<?php

namespace Product\Model;

use Zend\InputFilter\InputFilter;

/**
 * Class Product
 *
 * @package Product\Model
 */
abstract class Product
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var InputFilter
     */
    protected $inputFilter;

}
