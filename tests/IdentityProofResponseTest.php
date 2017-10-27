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

    protected function person()
    {
        return [
            'ssn' => '1234',
            'mobilePhone' => 1234,
            'email' => 'sdfsdf',
            'street1' => 'sdfsdf',
            'city' => 'sdfsdf',
            'state' => 'sfsdfds',
            'country' => 'us',
            'zip5' => 'sdfsdf',
            'firstName' => 'sdfsdf',
            'lastName' => 'sdfsdf',
            'ssn4' => 'sdfsdf',
            'dob' => '1900-01-31'
        ];
    }
}

