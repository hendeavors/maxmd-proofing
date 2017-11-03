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
     * We'll need various ways to retrieve values from the input
     */
    function setValueRetriever(IRetrievableValue $retriever);
}