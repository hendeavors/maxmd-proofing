<?php

namespace Endeavors\MaxMD\Proofing\Validation;

use Endeavors\MaxMD\Proofing\Contracts\IValidate;
use Endeavors\MaxMD\Proofing\Contracts\IValidationMessage;
/**
 * The validators perform the exact same functionality, except for defining
 * The required fields. Inheritance makes sense at this point.
 */
final class CreditCardRequestValidator extends Validator implements IValidate, IValidationMessage
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
        return "Missing fields: " . $this->missingFields();
    }

    public function validate()
    {
        $orignalRequest = $this->request;

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

        $this->request = $orignalRequest;

        if( isset($this->request['creditCard']) ) {
            $this->request = $this->request['creditCard'];

            $assigned = false;

            foreach($this->requiredCreditCardFields() as $next) {
                if( ! $this->hasValue($next) ) {
                    $this->missingFields[] = $next;
                    // only assign once
                    if( false === $assigned ) {
                        $this->missingFieldKey = ' in creditCard';
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
            'personMeta' => $this->requiredPersonFields(),
            'creditCard' => $this->requiredCreditCardFields()
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

    protected function requiredCreditCardFields()
    {
        return [
            'cardNumber',
            'cvv',
            'expireYear',
            'expireMonth'
        ];
    }
}