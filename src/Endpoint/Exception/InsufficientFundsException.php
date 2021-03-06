<?php
namespace ABWebDevelopers\PinPayments\Endpoint\Exception;

class InsufficientFundsException extends \Exception
{
    /**
     * Exception message
     *
     * @var string
     */
    protected $message = 'There are not enough funds available to process this charge.';

    /**
     * Exception code
     *
     * @var int
     */
    protected $code = 400;
}
