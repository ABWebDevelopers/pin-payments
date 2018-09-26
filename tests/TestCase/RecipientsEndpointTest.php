<?php
namespace ABWebDevelopers\PinPayments\Tests\TestCase;

use ABWebDevelopers\PinPayments\Entity\BankAccount;
use ABWebDevelopers\PinPayments\Entity\Recipient;
use ABWebDevelopers\PinPayments\Entity\Transfer;
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

        $this->assertEquals('XXXXX432', $recipients[0]->BankAccount->getNumber());
        $this->assertEquals('XXXXX432', $recipients[1]->BankAccount->getNumber());
    }

    public function testGetRecipient()
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

        $recipient = new Recipient('rp_yeUyeNqDIhEEDRtH9mPvAQ');
        $recipient = $this->client->recipients->get($recipient);

        $this->assertInstanceOf(Recipient::class, $recipient);
        $this->assertTrue($recipient->isLoaded());

        $this->assertInstanceOf(BankAccount::class, $recipient->BankAccount);
        $this->assertTrue($recipient->BankAccount->isLoaded());
        $this->assertEquals('XXXXX432', $recipient->BankAccount->getNumber());
    }

    public function testPutRecipient()
    {
        $this->fakeResponse(200, '{
            "response": {
                "token": "rp_JNZABDaziI4twLUeJrd7pw",
                "name": "Test Person",
                "email": "test@test.com",
                "created_at": "2018-09-25T09:14:18Z",
                "bank_account": {
                    "token": "ba_F3z2mD42PW2sSQ5Zkr80Qg",
                    "name": "Mr Test Person",
                    "bsb": "086366",
                    "number": "XXXXX432",
                    "bank_name": "National Australia Bank Limited",
                    "branch": "Mount Lawley"
                }
            }
        }');

        $recipient = new Recipient('rp_JNZABDaziI4twLUeJrd7pw');
        $recipient = $this->client->recipients->get($recipient);

        $this->fakeResponse(200, '{
            "response": {
                "token": "rp_JNZABDaziI4twLUeJrd7pw",
                "name": "Test Person",
                "email": "new@test.com",
                "created_at": "2018-09-25T09:14:18Z",
                "bank_account": {
                    "token": "ba_F3z2mD42PW2sSQ5Zkr80Qg",
                    "name": "Mr Test Person",
                    "bsb": "086366",
                    "number": "XXXXX678",
                    "bank_name": "National Australia Bank Limited",
                    "branch": "Mount Lawley"
                }
            }
        }');

        $recipient->setEmail('new@test.com');
        $recipient->BankAccount->setNumber('12345678');
        $recipient = $this->client->recipients->put($recipient);

        $this->assertInstanceOf(Recipient::class, $recipient);
        $this->assertTrue($recipient->isLoaded());
        $this->assertTrue($recipient->isSubmitted());
        $this->assertTrue($recipient->isSuccessful());
        $this->assertEquals('new@test.com', $recipient->getEmail());

        $this->assertInstanceOf(BankAccount::class, $recipient->BankAccount);
        $this->assertTrue($recipient->BankAccount->isLoaded());
        $this->assertEquals('XXXXX678', $recipient->BankAccount->getNumber());
    }

    public function testGetRecipientTransfers()
    {
        $this->fakeResponse(200, '{
            "response": [
                {
                    "token": "tfer_lfUYEBK14zotCTykezJkfg",
                    "status": "succeeded",
                    "currency": "AUD",
                    "description": "Test transfer",
                    "amount": 1000,
                    "total_debits": 0,
                    "total_credits": 1000,
                    "created_at": "2018-09-26T03:10:49Z",
                    "paid_at": "2018-09-26T03:10:49Z",
                    "reference": "Mr Test Person",
                    "bank_account": {
                        "token": "ba_F3z2mD42PW2sSQ5Zkr80Qg",
                        "name": "Mr Test Person",
                        "bsb": "086366",
                        "number": "XXXXX432",
                        "bank_name": "National Australia Bank Limited",
                        "branch": "Mount Lawley"
                    },
                    "recipient": "rp_JNZABDaziI4twLUeJrd7pw"
                },
                {
                    "token": "tfer_lc2x5lCzc7qoFSCi6ZFUfT",
                    "status": "succeeded",
                    "currency": "AUD",
                    "description": "Test transfer 2",
                    "amount": 2000,
                    "total_debits": 0,
                    "total_credits": 2000,
                    "created_at": "2018-09-26T04:10:49Z",
                    "paid_at": "2018-09-26T04:10:49Z",
                    "reference": "Mr Test Person",
                    "bank_account": {
                        "token": "ba_F3z2mD42PW2sSQ5Zkr80Qg",
                        "name": "Mr Test Person",
                        "bsb": "086366",
                        "number": "XXXXX432",
                        "bank_name": "National Australia Bank Limited",
                        "branch": "Mount Lawley"
                    },
                    "recipient": "rp_JNZABDaziI4twLUeJrd7pw"
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

        $recipient = new Recipient('rp_JNZABDaziI4twLUeJrd7pw');
        $transfers = $this->client->recipients->getTransfers($recipient);

        $this->assertCount(2, $transfers);

        foreach ($transfers as $transfer) {
            $this->assertInstanceOf(Transfer::class, $transfer);
            $this->assertTrue($transfer->isLoaded());

            $this->assertInstanceOf(BankAccount::class, $transfer->BankAccount);
            $this->assertTrue($transfer->BankAccount->isLoaded());

            $this->assertInstanceOf(Recipient::class, $transfer->Recipient);
            $this->assertFalse($transfer->Recipient->isLoaded()); // Recipient isn't loaded as it is returned by the API as a simple token
            $this->assertEquals('rp_JNZABDaziI4twLUeJrd7pw', $transfer->Recipient->getToken());
        }
    }
}
