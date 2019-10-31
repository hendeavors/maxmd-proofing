<?php

namespace Endeavors\MaxMD\Proofing\Tests;

use Endeavors\MaxMD\Proofing\IdentityProof;
use Endeavors\MaxMD\Api\Auth\MaxMD;
use Endeavors\MaxMD\Api\Auth\Session;

class IdentityProofTest extends TestCase
{
    public function testCanCallGenerateOneTimePassword()
    {
        MaxMD::Login(getenv("MAXMD_APIUSERNAME"),getenv("MAXMD_APIPASSWORD"));

        $proof = new IdentityProof();

        $proof->GenerateOneTimePassword([]);
    }

    public function testCanCallVerifyOneTimePassword()
    {
        MaxMD::Login(getenv("MAXMD_APIUSERNAME"),getenv("MAXMD_APIPASSWORD"));

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
