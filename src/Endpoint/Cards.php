<?php
namespace ABWebDevelopers\PinPayments\Endpoint;

use ABWebDevelopers\PinPayments\ApiRequest;
use ABWebDevelopers\PinPayments\Endpoint\Endpoint;
use ABWebDevelopers\PinPayments\Entity\Card;

class Cards extends Endpoint
{
    public function post(Card $card)
    {
        $data = $card->get();

        $request = new ApiRequest(
            $this->client,
            'POST',
            'cards',
            $data
        );

        $response = $request->send();

        if ($response->successful()) {
            $data = $response->data();

            $card->set($data)
                ->setSuccessful(true)
                ->setLoaded(true)
                ->setSubmitted(true);

            return $card;
        }
    }
}
