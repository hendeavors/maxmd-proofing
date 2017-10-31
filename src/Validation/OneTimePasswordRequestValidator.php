<?php

namespace Endeavors\MaxMD\Proofing\Validation;

class OneTimePasswordRequestValidator
{
    protected $request;

    protected $missingFields = [];

    public function __construct($request = [])
    {
        $this->request = $request;
    }

    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

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

    protected function missingFields()
    {
        return implode(', ', $this->missingFields);
    }

    public function validate()
    {
        // check if otp,firstName,lastName,ssn4,dob exists
        foreach($this->requiredFields() as $field) {
            if( ! $this->hasValue($field) ) {
                $this->missingFields[] = $field;
            }
        }

        return $this->missingFields;
    }

    protected function requestAsArray()
    {
        if(is_array($this->request)) {
            return $this->request;
        }

        return (array)$this->request;
    }

    protected function hasValue($key)
    {
        return null !== $this->getValue($key);
    }

    protected function getValue($key)
    {
        return isset($this->requestAsArray()[$key]) ? $this->requestAsArray()[$key] : null;
    }

    protected function requiredFields()
    {
        return [
            'otp',
            'firstName',
            'lastName',
            'ssn4',
            'dob'
        ];
    }
}