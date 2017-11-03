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

    protected function search($request, $field)
    {
        $result = null;

        if( is_string($field) && isset($request[$field]) && $request[$field] !== '' ) {
            $result = $request[$field];
        }
        elseif( is_array($field) && is_array($request) ) {
            foreach($request as $nextRequest) {
                foreach($field as $next) {
                    $result = $this->search($nextRequest,$next);
                }
            }
        }

        return $result;
    }
}