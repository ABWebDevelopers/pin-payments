<?php
namespace ABWebDevelopers\PinPayments\Endpoint;

use ABWebDevelopers\PinPayments\ApiRequest;
use ABWebDevelopers\PinPayments\Endpoint\Endpoint;
use ABWebDevelopers\PinPayments\Entity\Recipient;

class Recipients extends Endpoint
{
    public function post(Recipient $recipient)
    {
        $data = $recipient->getApiData();

        $request = new ApiRequest(
            $this->client,
            'POST',
            'recipients',
            $data
        );

        $response = $request->send();
        $data = $response->data();
        $recipient->setSubmitted(true);

        if ($response->successful()) {
            // Alias the bank account number if it is provided
            if (isset($data['response']['bank_account']['number'])) {
                $data['response']['bank_account']['display_number'] = $data['response']['bank_account']['number'];
                unset($data['response']['bank_account']['number']);
            }

            $recipient->set($data['response'])
                ->setSuccessful(true)
                ->setLoaded(true);
        } else {
            $recipient->setError($data['error_description'] ?? $data['error'] ?? 'Unknown error.')
                ->setSuccessful(false)
                ->setLoaded(false);

            if (isset($data['messages'])) {
                $recipient->setMessages($data['messages']);
            }
        }

        return $recipient;
    }
}
