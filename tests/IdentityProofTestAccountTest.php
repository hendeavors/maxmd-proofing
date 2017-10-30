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

    protected function person()
    {
        return [
            'ssn' => '999999999',
            'mobilePhone' => "+1 (555) 897-4564",
            'email' => 'fake@email.com',
            'street1' => '1234 Fake street',
            'city' => 'Fake Town',
            'state' => 'AK',
            'country' => 'US',
            'zip5' => '85412',
            'firstName' => 'Steve',
            'lastName' => 'Jobs',
            'ssn4' => '9999',
            'dob' => '1985-10-03'
        ];
    }
}

