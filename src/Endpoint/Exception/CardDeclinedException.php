<?php
namespace ABWebDevelopers\PinPayments\Endpoint\Exception;

class CardDeclinedException extends \Exception
{
    /**
     * Exception message
     *
     * @var string
     */
    protected $message = 'This card was declined.';

    /**
     * Exception code
     *
     * @var int
     */
    protected $code = 400;
}
