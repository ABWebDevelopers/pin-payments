<?php
namespace ABWebDevelopers\PinPayments\Entity;

use ABWebDevelopers\PinPayments\Entity\Entity;

class Charge extends Entity
{
    protected $attributes = [
        // Request attributes
        'token' => 'string',
        'email' => 'string',
        'description' => 'string',
        'amount' => 'int',
        'ip_address' => 'string',
        'currency' => 'string',
        'capture' => 'bool',
        'metadata' => 'array',
        'card' => 'ABWebDevelopers\PinPayments\Entity\Card',

        // Response attributes
        'created_at' => 'datetime',
        'transfer' => 'array',
        'amount_refunded' => 'int',
        'total_fees' => 'int',
        'merchant_entitlement' => 'int',
        'refund_pending' => 'bool',
        'authorisation_expired' => 'bool',
        'captured' => 'bool',
        'captured_at' => 'datetime',
        'settlement_currency' => 'string',
        'active_chargebacks' => 'bool',

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
        'description',
        'amount',
        'ip_address',
        'currency',
        'capture',
        'metadata',
        'card'
    ];

    protected function onGetApiData(array $data = [], bool $associated = false): array
    {
        // If a card token is present, use that instead of the entire card data
        if (isset($this->card) && !empty($this->card->getToken())) {
            $data['card_token'] = $this->card->getToken();
        } elseif (isset($this->card)) {
            $data['card'] = $this->card->getApiData(true);
        } else {
            $data['card'] = null;
        }

        return $data;
    }
}
