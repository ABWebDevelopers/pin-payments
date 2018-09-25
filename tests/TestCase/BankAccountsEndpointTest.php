<?php
namespace ABWebDevelopers\PinPayments\Tests\TestCase;

use ABWebDevelopers\PinPayments\Entity\BankAccount;
use ABWebDevelopers\PinPayments\Tests\TestCase\HttpTestCase;

class BankAccountsEndpointTest extends HttpTestCase
{
    protected $bankAccount;

    protected function setUp()
    {
        parent::setUp();

        $this->bankAccount = new BankAccount([
            'name' => 'John Smith',
            'bsb' => '123456',
            'number' => '987654321'
        ]);
    }

    public function testPostBankAccount()
    {
        $this->fakeResponse(200, [
            'response' => [
                'token' => 'ba_nytGw7koRg23EEp9NTmz9w',
                'name' => 'John Smith',
                'bsb' => '123456',
                'number' => 'XXXXXX321',
                'bank_name' => 'Test Bank',
                'branch' => ''
            ],
            'ip_address' => '127.0.0.1'
        ]);

        $bankAccount = $this->client->bankAccounts->post($this->bankAccount);

        $this->assertInstanceOf(BankAccount::class, $bankAccount);
        $this->assertTrue($bankAccount->isSubmitted());
        $this->assertTrue($bankAccount->isSuccessful());
        $this->assertTrue($bankAccount->isLoaded());
        $this->assertEquals('ba_nytGw7koRg23EEp9NTmz9w', $bankAccount->getToken());
        $this->assertEquals('123456', $bankAccount->getBsb());
        $this->assertEquals('XXXXXX321', $bankAccount->getDisplayNumber());
        $this->assertEquals('XXXXXX321', $bankAccount->getNumber());
    }
}
