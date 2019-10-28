<?php

namespace Endeavors\MaxMD\Proofing\Tests;

use Endeavors\MaxMD\Proofing\IdentityProof;
use Endeavors\MaxMD\Api\Auth\MaxMD;
use Endeavors\MaxMD\Api\Auth\Session;
use Psr\Http\Message\ResponseInterface;

class IdentityProofResponseTest extends TestCase
{
    protected $result;

    public function setUp()
    {
        parent::setUp();

        MaxMD::Login(getenv("MAXMD_APIUSERNAME"),getenv("MAXMD_APIPASSWORD"));

        $proof = new IdentityProof();

        $this->result = $proof->Verify($this->person());
    }

    public function testResultIsJsonResponse()
    {
        $this->assertInstanceOf(ResponseInterface::class, $this->result->JsonResponse());

        $this->assertNotNull($this->result->JsonResponse()->getBody()->getContents());
        $this->assertNotEquals("", $this->result->JsonResponse()->getBody()->getContents());
    }

    public function testResultIsResponse()
    {
        $this->assertInstanceOf(ResponseInterface::class, $this->result->Response());

        $this->assertNotNull($this->result->Response()->getBody()->getContents());
        $this->assertNotEquals("", $this->result->Response()->getBody()->getContents());
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
