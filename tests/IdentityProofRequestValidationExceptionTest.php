<?php

namespace Endeavors\MaxMD\Proofing\Tests;

use Endeavors\MaxMD\Api\Auth\MaxMD;
use Endeavors\MaxMD\Proofing\IdentityProof;

class IdentityProofRequestValidationExceptionTest extends \Orchestra\Testbench\TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: otp, firstName, lastName, ssn4, dob
     */
    public function testCallOneTimePasswordThrowsException()
    {
        MaxMD::Login(env("MAXMD_APIUSERNAME"),env("MAXMD_APIPASSWORD"));
        
        $proof = new IdentityProof();
        
        $proof->VerifyOneTimePassword([]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: firstName, lastName, ssn4, dob
     */
    public function testExceptionMessageExcludesOtp()
    {
        MaxMD::Login(env("MAXMD_APIUSERNAME"),env("MAXMD_APIPASSWORD"));
        
        $proof = new IdentityProof();
        
        $proof->VerifyOneTimePassword([
            'otp' => 'test'
        ]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: otp, lastName, ssn4, dob
     */
    public function testExceptionMessageExcludesFirstName()
    {
        MaxMD::Login(env("MAXMD_APIUSERNAME"),env("MAXMD_APIPASSWORD"));
        
        $proof = new IdentityProof();
        
        $proof->VerifyOneTimePassword([
            'firstName' => 'test'
        ]);
    }
}