<?php
namespace ABWebDevelopers\PinPayments\Endpoint\Exception;

class CardExpiredException extends \Exception
{
    /**
     * Exception message
     *
     * @var string
     */
    protected $message = 'This card has expired.';

    /**
     * Exception code
     *
     * @var int
     */
    protected $code = 400;
}
