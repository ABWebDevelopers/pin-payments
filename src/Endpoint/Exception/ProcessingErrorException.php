<?php
namespace ABWebDevelopers\PinPayments\Endpoint\Exception;

class ProcessingErrorException extends \Exception
{
    /**
     * Exception message
     *
     * @var string
     */
    protected $message = 'An error occurred while processing the card.';

    /**
     * Exception code
     *
     * @var int
     */
    protected $code = 400;
}
