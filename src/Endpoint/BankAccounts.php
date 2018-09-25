<?php
namespace ABWebDevelopers\PinPayments\Endpoint;

use ABWebDevelopers\PinPayments\ApiRequest;
use ABWebDevelopers\PinPayments\Endpoint\Endpoint;
use ABWebDevelopers\PinPayments\Entity\BankAccount;

class BankAccounts extends Endpoint
{
    public function post(BankAccount $bankAccount)
    {
        $data = $bankAccount->get();

        $request = new ApiRequest(
            $this->client,
            'POST',
            'bank_accounts',
            $data
        );

        $response = $request->send();
        $data = $response->data();
        $bankAccount->setSubmitted(true);

        if ($response->successful()) {
            // Alias the bank account display number
            $data['response']['display_number'] = $data['response']['number'];
            unset($data['response']['number']);

            $bankAccount->set($data['response'])
                ->setSuccessful(true)
                ->setLoaded(true);
        } else {
            $bankAccount->setError($data['error_description'] ?? $data['error'] ?? 'Unknown error.')
                ->setSuccessful(false)
                ->setLoaded(false);

            if (isset($data['messages'])) {
                $bankAccount->setMessages($data['messages']);
            }
        }

        return $bankAccount;
    }
}
