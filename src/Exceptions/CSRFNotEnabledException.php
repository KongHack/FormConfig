<?php
namespace GCWorld\FormConfig\Exceptions;

use Exception;
use Throwable;

/**
 * Class CSRFNotEnabledException
 *
 * @package GCWorld\FormConfig\Exceptions
 */
class CSRFNotEnabledException extends Exception
{
    /**
     * CSRFNotEnabledException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if(empty($message)) {
            $message = 'CSRF Not Enabled';
        }

        parent::__construct($message, $code, $previous);
    }
}
