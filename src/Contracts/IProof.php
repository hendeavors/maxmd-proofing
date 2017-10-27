<?php

namespace Endeavors\MaxMD\Proofing\Contracts;

interface IProof
{
    /**
     * We should already have the session id so
     * We can help out the developer and drop it in automatically
     * @param $request IDPerson https://evalapi.max.md:8445/AutoProofingRESTful/#IDPerson
     * @param autsentotp (One Time Password)
     * @return IProof
     */
    function VerifyAndAuthenticate($request, $autoSendOTP = false);
    
    /**
     * We'll drop in the session id
     * @param $request VerifyOTPRequestType https://evalapi.max.md:8445/AutoProofingRESTful/#VerifyOTPRequestType
     * @return VerificationResponseType
     * @return IProof
     */
    function VerifyOneTimePassword($request);

    /**
     * We'll drop in the session id
     * @param $request VerifyOTPRequestType https://evalapi.max.md:8445/AutoProofingRESTful/#VerifyOTPRequestType
     * @return IDProofingResponseType
     * @return IProof
     */
    function GenerateOneTimePassword($request);

     /**
     * We'll drop in the session id
     * @param $request VerifyCreditCardType https://evalapi.max.md:8445/AutoProofingRESTful/#VerifyCreditCardType
     * @return VerificationResponseType
     * @return IProof
     */
    function VerifyCreditCard($request);

    /**
     * return a raw response from the service
     */
    function Raw();
}