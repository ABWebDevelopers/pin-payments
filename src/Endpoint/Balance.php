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

        if ($response->isSuccessful()) {
            $data = $response->getResponseData();

            return new BalanceEntity([
                'available' => $data['response']['available'][0]['amount'],
                'available_currency' => $data['response']['available'][0]['currency'],
                'pending' => $data['response']['pending'][0]['amount'],
                'pending_currency' => $data['response']['pending'][0]['currency']
            ]);
        }
    }
}
