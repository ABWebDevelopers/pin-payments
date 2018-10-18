<?php
namespace ABWebDevelopers\PinPayments\Endpoint\Exception;

class SuspectedFraudException extends \Exception
{
    /**
     * Exception message
     *
     * @var string
     */
    protected $message = 'The transaction was flagged as possibly fraudulent and subsequently declined.';

    /**
     * Exception code
     *
     * @var int
     */
    protected $code = 400;
}
