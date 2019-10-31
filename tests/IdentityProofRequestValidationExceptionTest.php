<?php

namespace Endeavors\MaxMD\Proofing\Tests;

use Endeavors\MaxMD\Api\Auth\MaxMD;
use Endeavors\MaxMD\Proofing\IdentityProof;

class IdentityProofRequestValidationExceptionTest extends TestCase
{
    /**
     * @var IdentityProof
     */
    private $proof;

    public function setUp()
    {
        parent::setUp();

        MaxMD::Login(getenv("MAXMD_APIUSERNAME"),getenv("MAXMD_APIPASSWORD"));

        $this->proof = new IdentityProof();
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: otp, personMeta
     */
    public function testCallOneTimePasswordThrowsException()
    {
        $this->proof->VerifyOneTimePassword([]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: personMeta
     */
    public function testExceptionMessageExcludesOtp()
    {
        $this->proof->VerifyOneTimePassword([
            'otp' => 'test'
        ]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: otp
     */
    public function testExceptionMessageExcludesPersonMeta()
    {
        $this->proof->VerifyOneTimePassword([
            'personMeta' => 'test'
        ]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: otp, firstName, lastName, ssn4, dob
     */
    public function testExceptionMessageExcludesPersonMetaWithArray()
    {
        $this->proof->VerifyOneTimePassword([
            'personMeta' => []
        ]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: firstName, lastName, ssn4, dob in personMeta
     */
    public function testExceptionMessageExcludesOtpAndPersonMetaWithArray()
    {
        $this->proof->VerifyOneTimePassword([
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
        $this->proof->VerifyOneTimePassword([
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
        $this->proof->Verify([
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
        $this->proof->Verify([
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

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: firstName, lastName
     */
    public function testVerificationOfCreditCardMissingFirstAndLastName()
    {
        $response = $this->proof->VerifyCreditCard([
            'personMeta' => [
                'frstName' => 'Adam',
                'latName' => 'Rodriguez',
                'ssn4' => 9999,
                'dob' => '1985-05-05'
            ],
            'creditCard' => [
                'cardNumber' => '4111111111111111',
                'cvv' => '382',
                'expireYear' => '2019',
                'expireMonth' => '09'
            ]
        ]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: firstName, lastName
     */
    public function testVerificationOfCreditCard()
    {
        $response = $this->proof->VerifyCreditCard([
            'personMeta' => [
                'frstName' => 'Adam',
                'latName' => 'Rodriguez',
                'ssn4' => 9999,
                'dob' => '1985-05-05'
            ],
            'creditCard' => [
                'cardNumber' => '4111111111111111',
                'cvv' => '382',
                'expireYear' => '2019',
                'expireMonth' => '09'
            ]
        ]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: cardNumber, cvv, expireYear, expireMonth
     */
    public function testVerificationOfCreditCardMissingCreditCard()
    {
        $response = $this->proof->VerifyCreditCard([
            'personMeta' => [
                'firstName' => 'Adam',
                'lastName' => 'Rodriguez',
                'ssn4' => 9999,
                'dob' => '1985-05-05'
            ],
            'creditCard' => [

            ]
        ]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: firstName, lastName, ssn4, dob
     */
    public function testVerificationOfCreditCardMissingPersonMeta()
    {
        $response = $this->proof->VerifyCreditCard([
            'personMeta' => [

            ],
            'creditCard' => [
                'cardNumber' => '4111111111111111',
                'cvv' => '382',
                'expireYear' => '2019',
                'expireMonth' => '09'
            ]
        ]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: creditCard
     */
    public function testVerificationOfCreditCardMissingCreditCardNode()
    {
        $response = $this->proof->VerifyCreditCard([
            'personMeta' => [
                'firstName' => 'Adam',
                'lastName' => 'Rodriguez',
                'ssn4' => 9999,
                'dob' => '1985-05-05'
            ]
        ]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The request failed validation. Missing fields: personMeta
     */
    public function testVerificationOfCreditCardMissingPersonMetaNode()
    {
        $response = $this->proof->VerifyCreditCard([
            'creditCard' => [
                'cardNumber' => '4111111111111111',
                'cvv' => '382',
                'expireYear' => '2019',
                'expireMonth' => '09'
            ]
        ]);
    }

    public function testVerificationOfCreditCardOfDifferentOrderedParameters()
    {
        $response = $this->proof->VerifyCreditCard([
            'personMeta' => [
                'ssn4' => 9999,
                'lastName' => 'Rodriguez',
                'firstName' => 'Adam',
                'dob' => '1985-05-05'
            ],
            'creditCard' => [
                'cardNumber' => '4111111111111111',
                'cvv' => '382',
                'expireYear' => '2019',
                'expireMonth' => '09'
            ]
        ]);
    }
}
