<?php

namespace Endeavors\MaxMD\Proofing\Traits;

use Endeavors\MaxMD\Proofing\Validation\OneTimePasswordRequestValidator;
use Endeavors\MaxMD\Proofing\Validation\VerificationRequestValidator;
use Endeavors\MaxMD\Proofing\RequestValidationException;

trait RequestValidator
{
    public function validatesOneTimePasswordRequest($request)
    {
        $validator = new OneTimePasswordRequestValidator($request);
        // we need to call validate :O
        $validator->validate();

        if( $validator->fails() ) {
            throw new RequestValidationException("The request failed validation. " . $validator->message() );
        }
    }

    public function validatesVerificationRequest($request)
    {
        $validator = new VerificationRequestValidator($request);
        // we need to call validate :O
        $validator->validate();

        if( $validator->fails() ) {
            throw new RequestValidationException("The request failed validation. " . $validator->message() );
        }
    }
}