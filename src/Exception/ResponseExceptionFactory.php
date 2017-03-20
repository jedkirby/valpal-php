<?php

namespace Jedkirby\ValPal\Exception;

final class ResponseExceptionFactory
{
    /**
     * @var string
     */
    const GENERIC_ERROR = 'Unable to process valuation';

    /**
     * An array of ValPal specific error response codes and messages.
     *
     * @var array
     */
    private static $messages = [
        400 => 'Error in username and/or password',
        401 => 'Error in postcode format',
        408 => 'Error in address or cannot match to a valid PAF address',
        409 => 'Unable to generate output',
        503 => 'Server error during connection',
        504 => 'Server error during authentication',
        505 => 'Server error while attempting to find data',
        601 => 'You have exceeded your allowed quota of API hits',
        602 => 'Type not specified',
        700 => 'The API request needs to be an https post request',
    ];

    /**
     * @param int $code
     *
     * @throws ResponseException
     */
    public static function make($code)
    {
        return new ResponseException(
            (array_key_exists($code, static::$messages) ? static::$messages[$code] : static::GENERIC_ERROR),
            $code
        );
    }

    /**
     * @return array
     */
    public static function getMessages()
    {
        return static::$messages;
    }
}
