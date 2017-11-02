<?php

namespace Endeavors\MaxMD\Proofing\Contracts;

interface IValidate
{
    /**
     * whether or not the validation passes
     * @return bool
     */
    function passes();
    
    /**
     * whether or not the validation fails
     * @return bool
     */
    function fails();
    
    /**
     * validation the request
     * void
     */
    function validate();

    /**
     * The output message from the validator
     * @return string
     */
    function message();
}