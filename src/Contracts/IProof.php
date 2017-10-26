<?php

namespace Endeavors\MaxMD\Proofing\Contracts;

interface IProof
{
    /**
     * We should already have the session id so
     * We can help out the developer and drop it in automatically
     * @param $request IDPerson https://evalapi.max.md:8445/AutoProofingRESTful/#IDPerson
     * @param autsentotp (One Time Password)
     */
    function VerifyAndAuthenticate($request, $autoSendOTP = false);
    
    /**
     * We'll drop in the session id
     * @param $request VerifyOTPRequestType https://evalapi.max.md:8445/AutoProofingRESTful/#VerifyOTPRequestType
     * @return VerificationResponseType
     */
    function VerifyOneTimePassword($request);

    /**
     * We'll drop in the session id
     * @param $request VerifyOTPRequestType https://evalapi.max.md:8445/AutoProofingRESTful/#VerifyOTPRequestType
     * @return IDProofingResponseType
     */
    function GenerateOneTimePassword($request);
}