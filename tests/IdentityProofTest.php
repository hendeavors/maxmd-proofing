<?php

namespace Endeavors\MaxMD\Proofing\Tests;

use Endeavors\MaxMD\Proofing\IdentityProof;

class IdentityProofTest extends \Orchestra\Testbench\TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testProofing()
    {
        $proof = new IdentityProof();
    }
}

