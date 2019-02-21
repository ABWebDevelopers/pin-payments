<?php
namespace ABWebDevelopers\PinPayments\Endpoint;

use ABWebDevelopers\PinPayments\ApiRequest;
use ABWebDevelopers\PinPayments\Endpoint\Endpoint;
use ABWebDevelopers\PinPayments\Endpoint\Exception\InvalidResourceException;
use ABWebDevelopers\PinPayments\Endpoint\Exception\ProcessingErrorException;
use ABWebDevelopers\PinPayments\Endpoint\Exception\NotFoundException;
use ABWebDevelopers\PinPayments\Entity\Card;
use ABWebDevelopers\PinPayments\Entity\Customer;

class Customers extends Endpoint
{
    public function post(Customer $customer)
    {
        $data = $customer->getApiData();

        $request = new ApiRequest(
            $this->client,
            'POST',
            'customers',
            $data
        );

        $response = $request->send();
        $data = $response->getResponseData();
        $customer->setSubmitted(true);

        if ($response->isSuccessful()) {
            // Remove some unneeded variables
            unset($data['response']['success']);
            unset($data['response']['status_message']);
            unset($data['response']['error_message']);

            $customer->set($data['response'])
                ->setSuccessful(true)
                ->setLoaded(true);
        } else if ($response->getStatusCode() === 422) {
            switch ($data['error']) {
                case 'invalid_resource':
                    throw new InvalidResourceException('Missing data from request');
                    break;
                default:
                    throw new ProcessingErrorException('An error occurred while making this request');
                    break;
            }
        } else {
            $customer->setError($data['error_description'] ?: $data['error'] ?: 'Unknown error.')
                ->setSuccessful(false)
                ->setLoaded(false);

            if (isset($data['messages'])) {
                $customer->setMessages($data['messages']);
            }
        }

        return $customer;
    }

    public function get(Customer $customer = null) {
        if (isset($customer)) {
            return $this->getDetails($customer);
        }
        // return $this->getAll();
    }

    public function getDetails(Customer $customer): Customer {
        $request = new ApiRequest(
            $this->client,
            'GET',
            'customers/' . $customer->getToken()
        );
        $response = $request->send();
        $data = $response->getResponseData();
        if ($response->isSuccessful()) {
            // Alias the bank account number if it is provided
            if (isset($data['response']['bank_account']['number'])) {
                $data['response']['bank_account']['display_number'] = $data['response']['bank_account']['number'];
                unset($data['response']['bank_account']['number']);
            }
            $customer->set($data['response'])
                ->setLoaded(true);
        } else {
            throw new NotFoundException('No customer could be found with the specified token.');
        }
        return $customer;
    }

    public function getCards(Customer $customer) {

    }

    public function postCard(Customer $customer, Card $card) {
        $data = [
            'card_token' => $card->getToken(),
        ];
        $request = new ApiRequest(
            $this->client,
            'POST',
            'customers/' . $customer->getToken() . '/cards',
            $data
        );
        $response = $request->send();
        $data = $response->getResponseData();
        if ($response->isSuccessful()) {
            $card->set($data['response'])
                ->setLoaded(true);
        } else {
            throw new NotFoundException('No customer could be found with the specified token.');
        }
        return $card;
    }
}
