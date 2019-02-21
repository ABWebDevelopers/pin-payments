<?php
namespace ABWebDevelopers\PinPayments\Endpoint\Exception;

class InvalidResourceException extends \Exception
{
    /**
     * Exception message
     *
     * @var string
     */
    protected $message = 'One or more parameters were missing or invalid.';

    /**
     * Exception code
     *
     * @var int
     */
    protected $code = 422;
}
