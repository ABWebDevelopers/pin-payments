<?php
namespace ABWebDevelopers\PinPayments\Endpoint\Exception;

class InvalidEndpointException extends \Exception
{
    /**
     * Exception message
     *
     * @var string
     */
    protected $message = 'The specified API endpoint does not exist.';

    /**
     * Exception code
     *
     * @var int
     */
    protected $code = 404;
}
