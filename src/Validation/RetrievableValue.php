<?php

namespace Endeavors\MaxMD\Proofing\Validation;

use Endeavors\MaxMD\Proofing\Contracts\IRetrievableValue;

class RetrievableValue implements IRetrievableValue
{
    protected $validator;

    public function __construct($validator)
    {
        $this->validator = $validator;
    }

    public function getValue($field)
    {
        return isset($this->requestAsArray()[$field]) && $this->requestAsArray()[$field] !== ''  ? $this->requestAsArray()[$field] : null;
    }

    public function requestAsArray()
    {
        return $this->validator->requestAsArray();
    }
}