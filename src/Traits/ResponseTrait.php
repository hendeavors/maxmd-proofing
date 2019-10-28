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
        return JsonResponse::make($this->ToObject());
    }

    /**
     * Provide a convenient Response method
     */
    public function Response()
    {
        return Response::make(json_encode($this->Raw()));
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
