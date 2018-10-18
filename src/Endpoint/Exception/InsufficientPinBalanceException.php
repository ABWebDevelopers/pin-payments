<?php
namespace ABWebDevelopers\PinPayments\Endpoint\Exception;

class InsufficientPinBalanceException extends \Exception
{
    /**
     * Exception message
     *
     * @var string
     */
    protected $message = 'There are not enough funds available to process this transfer.';

    /**
     * Exception code
     *
     * @var int
     */
    protected $code = 402;
}
