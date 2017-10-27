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
        return new JsonResponse($this->Raw());
    }
    
    /**
     * Provide a convenient Response method
     */
    public function Response()
    {
        return new Response($this->Raw());
    }
    
    /**
     * Provide a the Raw response if the developer wishes to customize the output
     */
    public function Raw()
    {
        return $this->response;
    }
}