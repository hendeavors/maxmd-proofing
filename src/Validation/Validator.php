<?php

namespace Endeavors\MaxMD\Proofing\Validation;

use Endeavors\MaxMD\Proofing\Contracts\IValidate;
use Endeavors\MaxMD\Proofing\Contracts\IRetrievableValue;
use Endeavors\Support\VO\ModernArray;

/**
 * The validators perform the exact same functionality, except for defining
 * The required fields. Inheritance makes sense at this point.
 */
abstract class Validator implements IValidate
{
    protected $valueRetriever;

    public function passes()
    {
        return ! $this->fails();
    }

    public function fails()
    {
        return count($this->missingFields) > 0;
    }

    public function message()
    {
        return "Missing fields: " . $this->missingFields();
    }

    public function validate()
    {
        foreach($this->requiredFields() as $field) {
            if( ! $this->hasValue($field) ) {
                $this->missingFields[] = $field;
            }
        }

        return $this->missingFields;
    }

    public function setValueRetriever(IRetrievableValue $retriever)
    {
        $this->valueRetriever = $retriever;

        return $this;
    }

    protected function missingFields()
    {
        $modernArray = ModernArray::create($this->missingFields);

        return $modernArray->implode();
    }

    public function requestAsArray()
    {
        if(is_array($this->request)) {
            return $this->request;
        }

        return (array)$this->request;
    }

    protected function hasValue($field)
    {
        return null !== $this->getValue($field);
    }

    protected function getValue($field)
    {
        return $this->valueRetriever->getValue($field);
    }
}