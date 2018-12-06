<?php
namespace ABWebDevelopers\PinPayments\Endpoint;

use ABWebDevelopers\PinPayments\ApiRequest;
use ABWebDevelopers\PinPayments\Endpoint\Endpoint;
use ABWebDevelopers\PinPayments\Endpoint\Exception\CardDeclinedException;
use ABWebDevelopers\PinPayments\Endpoint\Exception\CardExpiredException;
use ABWebDevelopers\PinPayments\Endpoint\Exception\InsufficientFundsException;
use ABWebDevelopers\PinPayments\Endpoint\Exception\NotFoundException;
use ABWebDevelopers\PinPayments\Endpoint\Exception\ProcessingErrorException;
use ABWebDevelopers\PinPayments\Endpoint\Exception\SuspectedFraudException;
use ABWebDevelopers\PinPayments\Endpoint\Exception\InsufficientPinBalanceException;
use ABWebDevelopers\PinPayments\Entity\Charge;
use ABWebDevelopers\PinPayments\Entity\Refund;

class Charges extends Endpoint
{
    public function post(Charge $charge): Charge
    {
        $data = $charge->getApiData();

        $request = new ApiRequest(
            $this->client,
            'POST',
            'charges',
            $data
        );

        $response = $request->send();
        $data = $response->getResponseData();
        $charge->setSubmitted(true);

        if ($response->isSuccessful()) {
            // Remove some unneeded variables
            unset($data['response']['success']);
            unset($data['response']['status_message']);
            unset($data['response']['error_message']);

            $charge->set($data['response'])
                ->setSuccessful(true)
                ->setLoaded(true);
        } else if ($response->getStatusCode() === 400) {
            switch ($data['error']) {
                case 'card_declined':
                    throw new CardDeclinedException('The card was declined');
                    break;
                case 'insufficient_funds':
                    throw new InsufficientFundsException('There are not enough funds available to process the requested amount');
                    break;
                case 'suspected_fraud':
                    throw new SuspectedFraudException('The transaction was flagged as possibly fraudulent and subsequently declined');
                    break;
                case 'expired_card':
                    throw new CardExpiredException('The card has expired');
                    break;
                case 'processing_error':
                default:
                    throw new ProcessingErrorException('An error occurred while processing the card');
                    break;
            }
        } else {
            $charge->setError($data['error_description'] ?? $data['error'] ?? 'Unknown error.')
                ->setSuccessful(false)
                ->setLoaded(false);

            if (isset($data['messages'])) {
                $charge->setMessages($data['messages']);
            }
        }

        return $charge;
    }

    public function get(Charge $charge): Charge
    {
        $data = $charge->getApiData();

        $request = new ApiRequest(
            $this->client,
            'GET',
            'charges/' . $charge->getToken(),
            $data
        );

        $response = $request->send();
        $data = $response->getResponseData();
        $charge->setSubmitted(true);

        if ($response->isSuccessful()) {
            // Remove some unneeded variables
            unset($data['response']['success']);
            unset($data['response']['status_message']);
            unset($data['response']['error_message']);

            $charge->set($data['response'])
                ->setSuccessful(true)
                ->setLoaded(true);
        } else if ($response->getStatusCode() === 404) {
            throw new NotFoundException('The specified charge could not be found.');
        } else {
            $charge->setError($data['error_description'] ?? $data['error'] ?? 'Unknown error.')
                ->setSuccessful(false)
                ->setLoaded(false);

            if (isset($data['messages'])) {
                $charge->setMessages($data['messages']);
            }
        }

        return $charge;
    }

    public function refund(Charge $charge, $amount = null): Refund
    {
        if (!$charge->isLoaded()) {
            try {
                $charge = $this->client->charges->get($charge);
            } catch (\Exception $e) {
                throw new NotFoundException('Unable to find valid charge to refund.');
            }
        }

        $data = (isset($amount)) ? [
            'amount' => $amount
        ] : [];

        $request = new ApiRequest(
            $this->client,
            'POST',
            'charges/' . $charge->getToken() . '/refunds',
            $data
        );

        $response = $request->send();
        $data = $response->getResponseData();

        if ($response->isSuccessful()) {
            // Remove some unneeded variables
            unset($data['response']['success']);
            unset($data['response']['status_message']);
            unset($data['response']['error_message']);

            $refund = new Refund($data['response']);
            $refund->setCharge($charge)
                ->setSubmitted(true)
                ->setSuccessful(true)
                ->setLoaded(true);
        } else if ($response->getStatusCode() === 402) {
            throw new InsufficientPinBalanceException('Refund amount is more than your available Pin Payments balance.');
        } else {
            $refund->setError($data['error_description'] ?? $data['error'] ?? 'Unknown error.')
                ->setSuccessful(false)
                ->setLoaded(false);

            if (isset($data['messages'])) {
                $refund->setMessages($data['messages']);
            }
        }

        return $refund;
    }
}
