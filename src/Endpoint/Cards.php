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
        $data = $response->data();
        $card->setSubmitted(true);

        if ($response->successful()) {
            $card->set($data['response'])
                ->setSuccessful(true)
                ->setLoaded(true);
        } else {
            $card->setError($data['error_description'] ?? $data['error'] ?? 'Unknown error.')
                ->setSuccessful(false)
                ->setLoaded(false);

            if (isset($data['messages'])) {
                $card->setMessages($data['messages']);
            }
        }

        return $card;
    }
}
