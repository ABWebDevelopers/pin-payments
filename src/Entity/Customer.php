<?php
namespace ABWebDevelopers\PinPayments\Entity;

use ABWebDevelopers\PinPayments\Entity\Entity;

class Customer extends Entity
{
    protected $attributes = [
        // Request attributes
        'card_token' => 'string',
        'email' => 'string',
        'card' => 'ABWebDevelopers\PinPayments\Entity\Card',

        // Response attributes
        'created_at' => 'datetime',
        'token' => 'string',

        // Communication attributes
        'successful' => 'bool',
        'loaded' => 'bool',
        'submitted' => 'bool',
        'status_message' => 'string',
        'error' => 'string',
        'messages' => 'array'
    ];

    protected $apiAttributes = [
        'token',
        'email',
    ];

    protected function onGetApiData($data = [], $associated = false)
    {
        // If a card token is present, use that instead of the entire card data
        if (isset($this->card) && !empty($this->card->getToken())) {
            $data['card_token'] = $this->card->getToken();
        } else {
            $data['card'] = $this->card->getApiData(true) ?: null;
        }

        return $data;
    }
}
