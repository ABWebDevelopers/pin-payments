<?php
namespace ABWebDevelopers\PinPayments\Endpoint;

use ABWebDevelopers\PinPayments\ApiRequest;
use ABWebDevelopers\PinPayments\Endpoint\Endpoint;
use ABWebDevelopers\PinPayments\Endpoint\Exception\NotFoundException;
use ABWebDevelopers\PinPayments\Entity\Transfer;

class Transfers extends Endpoint
{
    public function post(Transfer $transfer): Transfer
    {
        $data = $transfer->getApiData();

        $request = new ApiRequest(
            $this->client,
            'POST',
            'transfers',
            $data
        );

        $response = $request->send();
        $data = $response->getResponseData();
        $transfer->setSubmitted(true);

        if ($response->isSuccessful()) {
            // Alias the bank account number if it is provided
            if (isset($data['response']['bank_account']['number'])) {
                $data['response']['bank_account']['display_number'] = $data['response']['bank_account']['number'];
                unset($data['response']['bank_account']['number']);
            }

            $transfer->set($data['response'])
                ->setSuccessful(true)
                ->setLoaded(true);
        } else if ($response->getStatusCode() === 402) {
            throw new InsufficientFundsException('There are not enough funds available to process this transfer');
        } else {
            $transfer->setError($data['error_description'] ?? $data['error'] ?? 'Unknown error.')
                ->setSuccessful(false)
                ->setLoaded(false);

            if (isset($data['messages'])) {
                $transfer->setMessages($data['messages']);
            }
        }

        return $transfer;
    }
}
