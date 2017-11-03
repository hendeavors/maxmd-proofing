<?php

namespace Endeavors\MaxMD\Proofing\Contracts;

interface IRetrievableValue
{
    /**
     * Gets a value from input by key
     */
    function getValue($key);
    
    /**
     * Get the input or request as an array
     */
    function requestAsArray();
}