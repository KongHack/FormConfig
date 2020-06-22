<?php
namespace GCWorld\FormConfig\Exceptions;

use Exception;
use Throwable;

/**
 * Class CSRFRequestFailedException
 *
 * @package GCWorld\FormConfig\Exceptions
 */
class CSRFRequestFailedException extends Exception
{
    /**
     * CSRFRequestFailedException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if(empty($message)) {
            $message = 'CSRF Failed';
        }

        parent::__construct($message, $code, $previous);
    }
}
