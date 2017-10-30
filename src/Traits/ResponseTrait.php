<?php

namespace Endeavors\MaxMD\Proofing\Traits;

use Endeavors\MaxMD\Http\JsonResponse;
use Endeavors\MaxMD\Http\Response;

trait ResponseTrait
{
    /**
     * Provide a convenient JsonResponse method
     */
    public function JsonResponse()
    {
        return new JsonResponse($this->ToObject());
    }
    
    /**
     * Provide a convenient Response method
     */
    public function Response()
    {
        return new Response(json_encode($this->Raw()));
    }

    public function ToArray()
    {
        return json_decode($this->response, true);
    }

    public function ToObject($associative = false)
    {
        return json_decode($this->response, $associative);
    }
    
    /**
     * Provide a the Raw response if the developer wishes to customize the output
     */
    public function Raw()
    {
        return $this->response;
    }
}