<?php
namespace ABWebDevelopers\PinPayments\Endpoint\Exception;

class NotFoundException extends \Exception
{
    /**
     * Exception message
     *
     * @var string
     */
    protected $message = 'Resource not found.';

    /**
     * Exception code
     *
     * @var int
     */
    protected $code = 404;
}
