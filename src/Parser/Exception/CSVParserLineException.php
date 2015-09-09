<?php /** CSVParserLineException can not parse line (starts by 0) */
namespace TPFoundation\Parser\Exception;
use Exception;

/**
 * CSVParser Line Exception, can not parse line
 * @package TPFoundation\Helper\Exception
 */
class CSVParserLineException extends CSVParserException
{
    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Construct the exception. Note: The message is NOT binary safe.
     * @link http://php.net/manual/en/exception.construct.php
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code.
     * @param Exception $previous [optional] The previous exception used for the exception chaining. Since 5.3.0
     */
    public function __construct($message = "", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}