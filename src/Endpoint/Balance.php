<?php
namespace ABWebDevelopers\PinPayments\Endpoint;

use ABWebDevelopers\PinPayments\ApiRequest;
use ABWebDevelopers\PinPayments\Endpoint\Endpoint;
use ABWebDevelopers\PinPayments\Entity\Balance as BalanceEntity;

class Balance extends Endpoint
{
    public function get()
    {
        $request = new ApiRequest(
            $this->client,
            'GET',
            'balance'
        );

        $response = $request->send();

        if ($response->successful()) {
            $data = $response->data();

            return new BalanceEntity([
                'available' => $data['available'][0]['amount'],
                'available_currency' => $data['available'][0]['currency'],
                'pending' => $data['pending'][0]['amount'],
                'pending_currency' => $data['pending'][0]['currency']
            ]);
        }
    }
}
