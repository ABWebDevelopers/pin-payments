<?php
namespace ABWebDevelopers\PinPayments\Tests\TestCase;

use ABWebDevelopers\PinPayments\Entity\BankAccount;
use ABWebDevelopers\PinPayments\Entity\Recipient;
use ABWebDevelopers\PinPayments\Tests\TestCase\HttpTestCase;

class RecipientsEndpointTest extends HttpTestCase
{
    protected $recipient;

    public function testPostRecipient()
    {
        $this->fakeResponse(200, '{
            "response": {
                "token": "rp_yeUyeNqDIhEEDRtH9mPvAQ",
                "name": "Test Person",
                "email": "test@test.com",
                "created_at": "2018-09-25T09:15:59Z",
                "bank_account": {
                    "token": "ba_v5-1yD9B94e-S6OccKe7Eg",
                    "name": "Mr Test Person",
                    "bsb": "086366",
                    "number": "XXXXX432",
                    "bank_name": "National Australia Bank Limited",
                    "branch": "Mount Lawley"
                }
            }
        }');

        $recipient = new Recipient([
            'name' => 'Test Person',
            'email' => 'test@test.com',
            'bank_account' => new BankAccount([
                'name' => 'Mr Test Person',
                'bsb' => '086366',
                'number' => '98765432'
            ])
        ]);

        $recipient = $this->client->recipients->post($recipient);

        $this->assertInstanceOf(Recipient::class, $recipient);
        $this->assertTrue($recipient->isSubmitted());
        $this->assertTrue($recipient->isSuccessful());
        $this->assertTrue($recipient->isLoaded());
        $this->assertEquals('rp_yeUyeNqDIhEEDRtH9mPvAQ', $recipient->getToken());

        $this->assertInstanceOf(BankAccount::class, $recipient->BankAccount);
        $this->assertFalse($recipient->BankAccount->isSubmitted());
        $this->assertFalse($recipient->BankAccount->isSuccessful());
        $this->assertTrue($recipient->BankAccount->isLoaded());
        $this->assertEquals('ba_v5-1yD9B94e-S6OccKe7Eg', $recipient->BankAccount->getToken());
    }

    public function testGetRecipients()
    {
        $this->fakeResponse(200, '{
            "response": [
                {
                    "token": "rp_yeUyeNqDIhEEDRtH9mPvAQ",
                    "name": "Test Person",
                    "email": "test@test.com",
                    "created_at": "2018-09-25T09:15:59Z",
                    "bank_account": {
                        "token": "ba_v5-1yD9B94e-S6OccKe7Eg",
                        "name": "Mr Test Person",
                        "bsb": "086366",
                        "number": "XXXXX432",
                        "bank_name": "National Australia Bank Limited",
                        "branch": "Mount Lawley"
                    }
                },
                {
                    "token": "rp_JNZABDaziI4twLUeJrd7pw",
                    "name": "Test Person",
                    "email": "test@test.com",
                    "created_at": "2018-09-25T09:14:18Z",
                    "bank_account": {
                        "token": "ba_DWYZ0pwR_NfTd-vrF8vdnA",
                        "name": "Mr Test Person",
                        "bsb": "083832",
                        "number": "XXXXX432",
                        "bank_name": "National Australia Bank Limited",
                        "branch": "Personal Direct Unit"
                    }
                }
            ],
            "count": 2,
            "pagination": {
                "current": 1,
                "previous": null,
                "next": null,
                "per_page": 25,
                "pages": 1,
                "count": 2
            }
        }');

        $recipients = $this->client->recipients->get();

        $this->assertCount(2, $recipients);

        foreach ($recipients as $recipient) {
            $this->assertInstanceOf(Recipient::class, $recipient);
            $this->assertTrue($recipient->isLoaded());

            $this->assertInstanceOf(BankAccount::class, $recipient->BankAccount);
            $this->assertTrue($recipient->BankAccount->isLoaded());
        }
    }
}
