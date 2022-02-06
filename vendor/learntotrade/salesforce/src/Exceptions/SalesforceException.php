<?php

namespace learntotrade\salesforce\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class SalesforceException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        Log::debug($message);

        parent::__construct($message, $code, $previous);
    }
}
