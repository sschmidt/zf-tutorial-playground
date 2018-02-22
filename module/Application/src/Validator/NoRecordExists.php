<?php

namespace Application\Validator;

/**
 * Class NoRecordExists
 *
 * see: https://stackoverflow.com/q/23470550
 *
 * @package Application\Validator
 */
class NoRecordExists extends \Zend\Validator\Db\NoRecordExists
{

    /**
     * @param mixed $value
     * @param array $context
     *
     * @return bool
     */
    public function isValid($value, $context = [])
    {
        $exclude = $this->getExclude();

        if (is_array($exclude)) {
            if (array_key_exists('formValue', $exclude)) {
                $formValue        = $exclude['formValue'];
                $exclude['value'] = $context[$formValue] ?? 0;
                $this->setExclude($exclude);
            }
        }

        return parent::isValid($value);
    }
}