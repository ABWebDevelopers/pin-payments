<?php
namespace ABWebDevelopers\PinPayments\Tests\TestCase;

use ABWebDevelopers\PinPayments\Entity\BankAccount;
use ABWebDevelopers\PinPayments\Entity\Recipient;
use ABWebDevelopers\PinPayments\Entity\Transfer;
use ABWebDevelopers\PinPayments\Tests\TestCase\HttpTestCase;

class TransfersEndpointTest extends HttpTestCase
{
    public function testPostTransfer()
    {
        $this->fakeResponse(200, '{
            "response": {
                "token": "tfer_S396K3FQbkFwLz8NdDTNMw",
                "status": "succeeded",
                "currency": "AUD",
                "description": "Test Transfer",
                "amount": 10000,
                "total_debits": 0,
                "total_credits": 10000,
                "created_at": "2018-09-26T04:50:35Z",
                "paid_at": "2018-09-26T04:50:35Z",
                "reference": "Test Business",
                "bank_account": {
                    "token": "ba_v5-1yD9B94e-S6OccKe7Eg",
                    "name": "Mr Test Person",
                    "bsb": "086366",
                    "number": "XXXXX432",
                    "bank_name": "National Australia Bank Limited",
                    "branch": "Mount Lawley"
                },
                "recipient": "rp_yeUyeNqDIhEEDRtH9mPvAQ"
            }
        }');

        $transfer = new Transfer([
            'description' => 'Test Transfer',
            'amount' => 10000,
            'currency' => 'AUD',
            'recipient' => new Recipient('rp_yeUyeNqDIhEEDRtH9mPvAQ')
        ]);

        $transfer = $this->client->transfers->post($transfer);

        $this->assertInstanceOf(Transfer::class, $transfer);
        $this->assertTrue($transfer->isSubmitted());
        $this->assertTrue($transfer->isSuccessful());
        $this->assertTrue($transfer->isLoaded());
        $this->assertEquals('tfer_S396K3FQbkFwLz8NdDTNMw', $transfer->getToken());
        $this->assertEquals(10000, $transfer->getTotalCredits());
        $this->assertEquals('succeeded', $transfer->getStatus());

        $this->assertInstanceOf(Recipient::class, $transfer->Recipient);
        $this->assertFalse($transfer->Recipient->isSubmitted());
        $this->assertFalse($transfer->Recipient->isSuccessful());
        $this->assertFalse($transfer->Recipient->isLoaded());
        $this->assertEquals('rp_yeUyeNqDIhEEDRtH9mPvAQ', $transfer->Recipient->getToken());

        $this->assertInstanceOf(BankAccount::class, $transfer->BankAccount);
        $this->assertFalse($transfer->BankAccount->isSubmitted());
        $this->assertFalse($transfer->BankAccount->isSuccessful());
        $this->assertTrue($transfer->BankAccount->isLoaded());
        $this->assertEquals('ba_v5-1yD9B94e-S6OccKe7Eg', $transfer->BankAccount->getToken());
    }
}
