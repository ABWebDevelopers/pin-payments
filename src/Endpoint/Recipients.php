<?php
namespace ABWebDevelopers\PinPayments\Endpoint;

use ABWebDevelopers\PinPayments\ApiRequest;
use ABWebDevelopers\PinPayments\Endpoint\Endpoint;
use ABWebDevelopers\PinPayments\Endpoint\Exception\NotFoundException;
use ABWebDevelopers\PinPayments\Entity\Recipient;
use ABWebDevelopers\PinPayments\Entity\Transfer;

class Recipients extends Endpoint
{
    public function post(Recipient $recipient): Recipient
    {
        $data = $recipient->getApiData();

        $request = new ApiRequest(
            $this->client,
            'POST',
            'recipients',
            $data
        );

        $response = $request->send();
        $data = $response->getResponseData();
        $recipient->setSubmitted(true);

        if ($response->isSuccessful()) {
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

    public function get(Recipient $recipient = null)
    {
        if (isset($recipient)) {
            return $this->getDetails($recipient);
        } else {
            return $this->getAll();
        }
    }

    protected function getAll()
    {
        $page = 0;

        do {
            ++$page;

            $request = new ApiRequest(
                $this->client,
                'GET',
                'recipients?page=' . $page
            );

            $response = $request->send();
            $data = $response->getResponseData();
            $recipients = [];

            if ($response->isSuccessful()) {
                if (count($data['response'])) {
                    foreach ($data['response'] as $recipient) {
                        // Alias the bank account number if it is provided
                        if (isset($recipient['bank_account']['number'])) {
                            $recipient['bank_account']['display_number'] = $recipient['bank_account']['number'];
                            unset($recipient['bank_account']['number']);
                        }

                        $recipient = new Recipient($recipient);
                        $recipient->setLoaded(true);
                        $recipient->BankAccount->setLoaded(true);
                        $recipients[] = $recipient;
                    }
                }
            }
        } while ($data['pagination']['next'] !== null);

        return $recipients;
    }

    protected function getDetails(Recipient $recipient): Recipient
    {
        $request = new ApiRequest(
            $this->client,
            'GET',
            'recipients/' . $recipient->getToken()
        );

        $response = $request->send();
        $data = $response->getResponseData();

        if ($response->isSuccessful()) {
            // Alias the bank account number if it is provided
            if (isset($data['response']['bank_account']['number'])) {
                $data['response']['bank_account']['display_number'] = $data['response']['bank_account']['number'];
                unset($data['response']['bank_account']['number']);
            }

            $recipient->set($data['response'])
                ->setLoaded(true);
        } else {
            throw new NotFoundException('No recipient could be found with the specified token.');
        }

        return $recipient;
    }

    public function put(Recipient $recipient): Recipient
    {
        $data = $recipient->getApiData();

        $request = new ApiRequest(
            $this->client,
            'PUT',
            'recipients/' . $recipient->getToken(),
            $data
        );

        $response = $request->send();
        $data = $response->getResponseData();
        $recipient->setSubmitted(true);

        if ($response->isSuccessful()) {
            // Alias the bank account number if it is provided
            if (isset($data['response']['bank_account']['number'])) {
                $data['response']['bank_account']['display_number'] = $data['response']['bank_account']['number'];
                unset($data['response']['bank_account']['number']);
            }

            $recipient->set($data['response'])
                ->setSuccessful(true)
                ->setLoaded(true);
        } elseif ($response->getStatusCode() === 404) {
                throw new NotFoundException('No recipient could be found with the specified token.');
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

    public function getTransfers(Recipient $recipient)
    {
        $page = 0;

        do {
            ++$page;

            $request = new ApiRequest(
                $this->client,
                'GET',
                'recipients/' . $recipient->getToken() . '/transfers'
            );

            $response = $request->send();
            $data = $response->getResponseData();
            $transfers = [];

            if ($response->isSuccessful()) {
                if (count($data['response'])) {
                    foreach ($data['response'] as $transfer) {
                        // Alias the bank account number if it is provided
                        if (isset($transfer['bank_account']['number'])) {
                            $transfer['bank_account']['display_number'] = $transfer['bank_account']['number'];
                            unset($transfer['bank_account']['number']);
                        }

                        $transfer = new Transfer($transfer);
                        $transfer->setLoaded(true);
                        $transfer->BankAccount->setLoaded(true);
                        $transfers[] = $transfer;
                    }
                }
            } else {
                throw new NotFoundException('No recipient could be found with the specified token.');
            }
        } while ($data['pagination']['next'] !== null);

        return $transfers;
    }
}
