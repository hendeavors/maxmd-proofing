<?php

namespace Endeavors\MaxMD\Proofing\Contracts;

interface IValidationMessage
{
    /**
     * The output message from the validator
     * @return string
     */
    function message();
}