<?php

namespace Endeavors\MaxMD\Proofing\Tests;

use Endeavors\MaxMD\Proofing\IdentityProof;
use Endeavors\MaxMD\Api\Auth\MaxMD;
use Endeavors\MaxMD\Api\Auth\Session;

class IdentityProofUnauthorizedExceptionTest extends TestCase
{
    /**
     * @expectedException Exception
     * @expectedExceptionMessage The credentials supplied are either invalid or your session has timed out.
     */
    public function testExceptionIsThrownWhenBadCredentialsUsed()
    {
        MaxMD::Logout();

        MaxMD::Login("bad", "bad");

        $proof = new IdentityProof();

        $proof->Verify([]);
    }
}
