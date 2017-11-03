<?php

namespace Endeavors\MaxMD\Proofing\Validation;

use Endeavors\MaxMD\Proofing\Contracts\IValidate;
use Endeavors\MaxMD\Proofing\Contracts\IValidationMessage;

/**
 * The validators perform the exact same functionality, except for defining
 * The required fields. Inheritance makes sense at this point.
 */
final class VerificationRequestValidator extends Validator implements IValidate, IValidationMessage
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

    protected function requiredFields()
    {
        return [
            'firstName',
            'lastName',
            'ssn4',
            'dob',
            'ssn',
            'mobilePhone',
            'email',
            'street1',
            'city',
            'state',
            'country',
            'zip5'
        ];
    }
}