<?php

namespace Endeavors\MaxMD\Proofing;

use Endeavors\MaxMD\Proofing\Contracts\IProof;
use Endeavors\MaxMD\Support\Client;
use Endeavors\MaxMD\Api\Auth\Session;
use Endeavors\MaxMD\Api\Auth\UnauthorizedAccessException;
use Endeavors\MaxMD\Proofing\Traits\ResponseTrait;
use Endeavors\MaxMD\Proofing\Traits\RequestValidator;

/**
 * The developer will need to authenticate prior to using
 * @todo add some validation for the required fields
 */
class IdentityProof implements IProof
{
    use ResponseTrait, RequestValidator;

    protected $response;
    /**
     * will call verifyandauthenticate and autosent one time password
     */
    public function Verify($request)
    {
        return $this->VerifyAndAuthenticate($request, true);
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
            $request = $this->sanitizeRequest($request);

            $this->validatesVerificationRequest($request);

            $autoSendOTP = $autoSendOTP ? "true" : "false";

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
            $request = $this->sanitizeRequest($request);

            $this->validatesOneTimePasswordRequest($request);

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
            $request = $this->sanitizeRequest($request);

            $this->validatesCreditCardRequest($request);

            $this->response = Client::ProofingRest()->Post('personal/verifyCreditCard/' . Session::getId() . '/', $request, array("Accept: application/json", "Content-Type: application/json"));
        
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
            $request = $this->sanitizeRequest($request);

            $this->response = Client::ProofingRest()->Post('personal/generateMFAOTP/' . Session::getId() . '/', $request, array("Accept: application/json", "Content-Type: application/json"));
        
            return $this;
        }

        throw new UnauthorizedAccessException("The credentials supplied are either invalid or your session has timed out.");
    }
    
    // the below should probably go in support or http
    protected function sanitizeRequest($request)
    {
        if( is_array($request) && isset($request['mobilePhone']) ) {
            $request['mobilePhone'] = $this->sanitizeMobilePhone($request['mobilePhone']);
        }
        elseif( is_object($request) && isset($request->mobilePhone) ) {
            $request->mobilePhone = $this->sanitizeMobilePhone($request->mobilePhone);
        }

        return $request;
    }

    protected function sanitizeMobilePhone($mobilePhone)
    {
        $validChars = '1234567890';
        
        $clean = '';
        for($i=0;$i<mb_strlen($mobilePhone);++$i) {
            $c = mb_substr($mobilePhone, $i, 1);
            if(mb_strpos($validChars, $c)===false) {
                $clean.='';
            } else {
                $clean.=$c;
            }
        }
        
        return $clean;
    }
}