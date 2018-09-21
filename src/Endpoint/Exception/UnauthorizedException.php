<?php
namespace ABWebDevelopers\PinPayments\Endpoint\Exception;

class UnauthorizedException extends \Exception
{
    /**
     * Exception message
     *
     * @var string
     */
    protected $message = 'You are unauthorised to access the Pin Payments API. Please check your API key.';

    /**
     * Exception code
     *
     * @var int
     */
    protected $code = 401;
}
