<?php

namespace Endeavors\MaxMD\Proofing;

use Endeavors\MaxMD\Proofing\Contracts\IProof;

class IdentityProof implements IProof
{
    public function VerifyAndAuthenticate($request, $autoSendOTP = false)
    {
        
    }
    
    /**
     * We'll drop in the session id
     * @param $request VerifyOTPRequestType https://evalapi.max.md:8445/AutoProofingRESTful/#VerifyOTPRequestType
     * @return VerificationResponseType
     */
    public function VerifyOneTimePassword($request)
    {

    }

    /**
     * We'll drop in the session id
     * @param $request VerifyOTPRequestType https://evalapi.max.md:8445/AutoProofingRESTful/#VerifyOTPRequestType
     * @return IDProofingResponseType
     */
    public function GenerateOneTimePassword($request)
    {

    }
}