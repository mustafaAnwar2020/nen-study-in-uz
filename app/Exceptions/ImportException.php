<?php

namespace App\Exceptions;

use Exception;

class ImportException extends Exception
{
    protected $messages;

    public function __construct($messages = [], $code = 0, Exception $previous = null)
    {
        parent::__construct('Import Exception', $code, $previous);
        $this->messages = $messages;
    }

    public function getMessages()
    {
        \Log::error($this->messages);
        return $this->messages;
    }
}
