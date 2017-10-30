<?php

namespace Endeavors\MaxMD\Proofing\Tests;

use Endeavors\MaxMD\Proofing\IdentityProof;
use Endeavors\MaxMD\Api\Auth\MaxMD;
use Endeavors\MaxMD\Api\Auth\Session;

class IdentityProofResponseTest extends \Orchestra\Testbench\TestCase
{
    protected $result;

    public function setUp()
    {
        MaxMD::Login(env("MAXMD_APIUSERNAME"),env("MAXMD_APIPASSWORD"));
        
        $proof = new IdentityProof();

        $this->result = $proof->Verify($this->person());

        parent::setUp();
    }

    public function testResultIsJsonResponse()
    {
        $this->assertInstanceOf(\Endeavors\MaxMD\Http\JsonResponse::class, $this->result->JsonResponse());

        $this->assertNotNull($this->result->JsonResponse()->getContent());
        $this->assertNotEquals("", $this->result->JsonResponse()->getContent());
    }

    public function testResultIsResponse()
    {
        $this->assertInstanceOf(\Endeavors\MaxMD\Http\Response::class, $this->result->Response());
        
        $this->assertNotNull($this->result->Response()->getContent());
        $this->assertNotEquals("", $this->result->Response()->getContent());
    }

    public function testResultIsRaw()
    {
        $this->result->Raw();
    }

    public function testRawResultCanBeJsonDecode()
    {
        $decoded = json_decode($this->result->Raw());

        $this->assertNotNull($decoded);
    }

    public function testResultIsObject()
    {
        $this->assertTrue(is_object($this->result->ToObject()));
    }

    public function testResultIsArray()
    {
        $this->assertTrue(is_array($this->result->ToArray()));
    }

    protected function person()
    {
        return [
            'ssn' => '123456789',
            'mobilePhone' => "+1 (555) 897-4564",
            'email' => 'fake@email.com',
            'street1' => '1234 Fake street',
            'city' => 'Fake Town',
            'state' => 'AK',
            'country' => 'US',
            'zip5' => '85412',
            'firstName' => 'Steve',
            'lastName' => 'Jobs',
            'ssn4' => '6789',
            'dob' => '1985-10-03'
        ];
    }
}

