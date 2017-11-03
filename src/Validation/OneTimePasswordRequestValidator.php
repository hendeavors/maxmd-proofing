<?php

namespace Endeavors\MaxMD\Proofing\Validation;

use Endeavors\MaxMD\Proofing\Contracts\IValidate;
use Endeavors\MaxMD\Proofing\Contracts\IValidationMessage;
/**
 * The validators perform the exact same functionality, except for defining
 * The required fields. Inheritance makes sense at this point.
 */
final class OneTimePasswordRequestValidator extends Validator implements IValidate, IValidationMessage
{
    protected $request;

    protected $missingFieldKey = '';

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

    public function message()
    {
        return "Missing fields: " . $this->missingFields() . $this->missingFieldKey;
    }

    public function validate()
    {
        foreach($this->requiredFields() as $field) {
            if( ! $this->hasValue($field) ) {
                $this->missingFields[] = $field;
            }
        }

        if( isset($this->request['personMeta']) ) {
            $this->request = $this->request['personMeta'];

            $assigned = false;

            foreach($this->requiredPersonFields() as $next) {
                if( ! $this->hasValue($next) ) {
                    $this->missingFields[] = $next;
                    // only assign once
                    if( false === $assigned ) {
                        $this->missingFieldKey = ' in personMeta';
                        $assigned = true;
                    }
                }
            }
        }

        return $this->missingFields;
    }

    protected function requiredFields()
    {
        return [
            'otp',
            'personMeta'
        ];
    }

    protected function requiredPersonFields()
    {
        return [
            'firstName',
            'lastName',
            'ssn4',
            'dob'
        ];
    }
}