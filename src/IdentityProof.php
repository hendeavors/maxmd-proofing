<?php

namespace Endeavors\MaxMD\Proofing;

use Endeavors\MaxMD\Proofing\Contracts\IProof;
use Endeavors\MaxMD\Support\Client;
use Endeavors\MaxMD\Api\Auth\Session;
use Endeavors\MaxMD\Api\Auth\UnauthorizedAccessException;
use Endeavors\MaxMD\Proofing\Traits\ResponseTrait;

/**
 * The developer will need to authenticate prior to using
 */
class IdentityProof implements IProof
{
    use ResponseTrait;

    protected $response;
    /**
     * will call verifyandauthenticate and autosent one time password
     */
    public function Verify($request)
    {
        return $this->VerifyAndAuthenticate($request,true);
    }
    /**
     * @todo determine the failed response format
     * The developer will authenticate against the maxmd api
     * @param IDPerson
     * @return IProof
     * @throws UnauthorizedAccessException
     */
    public function VerifyAndAuthenticate($request, $autoSendOTP = false)
    {
        if(Session::check()) {
            $this->response = Client::ProofingRest()->Post('personal/verifyAndAuthenticate/' . Session::getId() . '/' . $autoSendOTP, $request, array("Accept: application/json", "Content-Type: application/json"));
            
            return $this;
        }

        throw new UnauthorizedAccessException("The credentials supplied are either invalid or your session has timed out.");
    }
    
    /**
     * We'll drop in the session id
     * @param $request VerifyOTPRequestType https://evalapi.max.md:8445/AutoProofingRESTful/#VerifyOTPRequestType
     * @return IProof
     */
    public function VerifyOneTimePassword($request)
    {
        if(Session::check()) {
            $this->response = Client::ProofingRest()->Post('personal/one-time-password-verify/' . Session::getId() . '/', $request, array("Accept: application/json", "Content-Type: application/json"));
        
            return $this;
        }

        throw new UnauthorizedAccessException("The credentials supplied are either invalid or your session has timed out.");
    }

    /**
     * We'll drop in the session id
     * @param $request VerifyCreditCardType https://evalapi.max.md:8445/AutoProofingRESTful/#VerifyCreditCardType
     * @return IProof
     */
    public function VerifyCreditCard($request)
    {
        if(Session::check()) {
            $this->response = Client::ProofingRest()->Post('personal/one-time-password-verify/' . Session::getId() . '/', $request, array("Accept: application/json", "Content-Type: application/json"));
        
            return $this;
        }

        throw new UnauthorizedAccessException("The credentials supplied are either invalid or your session has timed out.");
    }

    /**
     * We'll drop in the session id
     * @param $request VerifyOTPRequestType https://evalapi.max.md:8445/AutoProofingRESTful/#VerifyOTPRequestType
     * @return IProof
     */
    public function GenerateOneTimePassword($request)
    {
        if(Session::check()) {
            $this->response = Client::ProofingRest()->Post('personal/generateMFAOTP/' . Session::getId() . '/', $request, array("Accept: application/json", "Content-Type: application/json"));
        
            return $this;
        }

        throw new UnauthorizedAccessException("The credentials supplied are either invalid or your session has timed out.");
    }
}