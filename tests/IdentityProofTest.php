<?php

namespace Endeavors\MaxMD\Proofing\Tests;

use Endeavors\MaxMD\Proofing\IdentityProof;
use Endeavors\MaxMD\Api\Auth\MaxMD;
use Endeavors\MaxMD\Api\Auth\Session;

class IdentityProofTest extends \Orchestra\Testbench\TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testCanCallGenerateOneTimePassword()
    {
        MaxMD::Login(env("MAXMD_APIUSERNAME"),env("MAXMD_APIPASSWORD"));

        $proof = new IdentityProof();

        $proof->GenerateOneTimePassword([]);
    }

    public function testCanCallVerifyOneTimePassword()
    {
        MaxMD::Login(env("MAXMD_APIUSERNAME"),env("MAXMD_APIPASSWORD"));

        $proof = new IdentityProof();

        $proof->VerifyOneTimePassword([
            'otp' => 'test',
            'personMeta' => [
                'firstName' => 'bob',
                'lastName' => 'smith',
                'ssn4' => 9999,
                'dob' => '1985-10-03'
            ]
        ]);
    }
}

