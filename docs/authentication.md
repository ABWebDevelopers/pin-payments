---
layout: default
---

# Authentication

To authenticate and use this plugin, you will need your Pin Payments API Secret Key. You can retrieve this via
the **Account** area when signed in to your [Pin Payments dashboard](https://dashboard.pinpayments.com). Click on the
**API Keys** option on this page to retrieve your key. Note that there are separate keys for the test gateway.

Once you have your secret key, you can include the library in your application like so:

```php
<?php
use ABWebDevelopers\PinPayments\ApiClient;

$pinClient = new ApiClient(
    '', // Your Pin Payments API Secret Key.
    true, // Test mode?
    null, // (optional) Your HTTP client object, specify this if
          // you wish to use a custom HTTP client.
    null // (optional) Your HTTP message provider object, specify this
         // if you wish to use a custom HTTP message provider.
);
```

You will be able to determine if authentication is successful after your first call to the Pin Payments API. If, for some reason,
you do not have authentication, the `ApiClient` will throw an `UnauthorizedException`. It is best to wrap any API calls within a `try..catch` declaration, for example:

```php
try {
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
} catch (\ABWebDevelopers\PinPayments\Endpoint\Exception\UnauthorizedException $e) {
    // Handle an unauthorized API call
}
```
