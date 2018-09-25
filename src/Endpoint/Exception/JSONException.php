<?php
namespace ABWebDevelopers\PinPayments\Endpoint\Exception;

class JSONException extends \Exception
{
    /**
     * Exception message
     *
     * @var string
     */
    protected $message = 'A JSON decoding error has occurred.';
}
