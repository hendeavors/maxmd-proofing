<?php

namespace Endeavors\MaxMD\Proofing\Validation;

use Endeavors\MaxMD\Proofing\Contracts\IRetrievableValue;

/**
 * We want to check all nested values of the request, given a field
 */
class RecursiveRetrievableValue implements IRetrievableValue
{
    protected $validator;
    
    public function __construct($validator)
    {
        $this->validator = $validator;
    }

    public function getValue($field)
    {
        return $this->search($this->requestAsArray(), $field);
    }

    public function requestAsArray()
    {
        return $this->validator->requestAsArray();
    }

    protected function search($request, $field)
    {
        $result = null;

        if( is_string($field) && isset($request[$field]) && $request[$field] !== '' ) {
            $result = $request[$field];
        }
        elseif( is_array($field) && is_array($request) ) {
            foreach($request as $key => $nextRequest) {
                foreach($field as $next) {
                    $result = $this->search($nextRequest,$next);
                }
            }
        }

        return $result;
    }
}