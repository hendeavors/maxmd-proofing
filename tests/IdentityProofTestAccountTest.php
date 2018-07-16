<?php

namespace Endeavors\MaxMD\Proofing\Tests;

use Endeavors\MaxMD\Proofing\IdentityProof;
use Endeavors\MaxMD\Api\Auth\MaxMD;
use Endeavors\MaxMD\Api\Auth\Session;

class IdentityProofTestAccountTest extends \Orchestra\Testbench\TestCase
{
    protected $result;

    public function setUp()
    {
        MaxMD::Login(env("MAXMD_APIUSERNAME"),env("MAXMD_APIPASSWORD"));

        $proof = new IdentityProof();

        $this->result = $proof->Verify($this->person());

        parent::setUp();
    }

    public function testProofingIsSuccessful()
    {
        $this->assertTrue($this->result->ToObject()->success);
    }

    /**
     * The person method below should pass this test
     */
    public function testMobileIsVerifiedAndGenerated()
    {
        // we are either certified or a mobile onetimepassword has been sent
        $result = $this->result->ToObject()->verificationStatus == "MFAOTPGenerated" || $this->result->ToObject()->verificationStatus == "LoA3Certified";

        $this->assertTrue($result);
    }

    public function testVerificationOfCreditCard()
    {
        $proof = new IdentityProof();

        $response = $proof->VerifyCreditCard([
            'personMeta' => [
                'firstName' => 'Adam',
                'lastName' => 'Rodriguez',
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

        $this->assertTrue($response->ToObject()->success);
    }

    public function testDeletePerson()
    {
        $proof = new IdentityProof();

        $response = $proof->VerifyCreditCard([
            'personMeta' => [
                'firstName' => 'Adam',
                'lastName' => 'Rodriguez',
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

        $response = $proof->DeletePerson($response->ToObject()->personMeta->id);
        $this->assertTrue($response->ToObject()->success);
    }

    protected function person()
    {
        return [
            'ssn' => '999999999',
            'mobilePhone' => "1(480) 364-6662",
            'email' => 'fake@email.com',
            'street1' => '1234 Fake street',
            'city' => 'Fake Town',
            'state' => 'AK',
            'country' => 'US',
            'zip5' => '85412',
            'firstName' => 'Adam',
            'lastName' => 'Rodriguez',
            'ssn4' => '9999',
            'dob' => '1985-10-03'
        ];
    }
}
