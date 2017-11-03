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
     * @expectedExceptionMessage The request failed validation. Missing fields: otp, personMeta
     */
    public function testCallOneTimePasswordThrowsException()
    {
        MaxMD::Login(env("MAXMD_APIUSERNAME"),env("MAXMD_APIPASSWORD"));
        
        $proof = new IdentityProof();
        
        $proof->VerifyOneTimePassword([]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: personMeta
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
     * @expectedExceptionMessage The request failed validation. Missing fields: otp
     */
    public function testExceptionMessageExcludesPersonMeta()
    {
        MaxMD::Login(env("MAXMD_APIUSERNAME"),env("MAXMD_APIPASSWORD"));
        
        $proof = new IdentityProof();
        
        $proof->VerifyOneTimePassword([
            'personMeta' => 'test'
        ]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: otp, firstName, lastName, ssn4, dob
     */
    public function testExceptionMessageExcludesPersonMetaWithArray()
    {
        MaxMD::Login(env("MAXMD_APIUSERNAME"),env("MAXMD_APIPASSWORD"));
        
        $proof = new IdentityProof();
        
        $proof->VerifyOneTimePassword([
            'personMeta' => []
        ]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: firstName, lastName, ssn4, dob in personMeta
     */
    public function testExceptionMessageExcludesOtpAndPersonMetaWithArray()
    {
        MaxMD::Login(env("MAXMD_APIUSERNAME"),env("MAXMD_APIPASSWORD"));
        
        $proof = new IdentityProof();
        
        $proof->VerifyOneTimePassword([
            'personMeta' => [],
            'otp' => 'test'
        ]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: otp
     */
    public function testExceptionMessageExcludesPersonMetaWithArrayFilled()
    {
        MaxMD::Login(env("MAXMD_APIUSERNAME"),env("MAXMD_APIPASSWORD"));
        
        $proof = new IdentityProof();
        
        $proof->VerifyOneTimePassword([
            'personMeta' => [
                'firstName' => 'bob',
                'lastName' => 'smith',
                'ssn4' => 9999,
                'dob' => '1985-10-03'
            ]
        ]);
    }
    
    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: firstName, lastName, ssn4, dob, ssn, mobilePhone, email, street1, city, state, country, zip5
     */
    public function testVerifyExceptionMessageIncludesAllFields()
    {
        MaxMD::Login(env("MAXMD_APIUSERNAME"),env("MAXMD_APIPASSWORD"));
        
        $proof = new IdentityProof();
        
        $proof->Verify([
            'firstName' => '',
            'lastName' => '',
            'ssn4' => '',
            'dob' => '',
            'ssn' => '',
            'mobilePhone' => '',
            'email' => '',
            'street1' => ''
        ]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: ssn4, dob, ssn, mobilePhone, email, street1, city, state, country, zip5
     */
    public function testVerifyExceptionMessageExcludesFirstAndLast()
    {
        MaxMD::Login(env("MAXMD_APIUSERNAME"),env("MAXMD_APIPASSWORD"));
        
        $proof = new IdentityProof();
        
        $proof->Verify([
            'firstName' => 'test',
            'lastName' => 'test',
            'ssn4' => '',
            'dob' => '',
            'ssn' => '',
            'mobilePhone' => '',
            'email' => '',
            'street1' => ''
        ]);
    }
}