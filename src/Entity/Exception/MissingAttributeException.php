<?php
namespace ABWebDevelopers\PinPayments\Entity\Exception;

class MissingAttributeException extends \Exception
{
    /**
     * Exception message
     *
     * @var string
     */
    protected $message = 'This entity does not contain the specified attribute.';
}
