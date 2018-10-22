---
layout: default
---
ABWebDevelopers\PinPayments\ApiClient
===============

API Client class

The main class that instantiates a connection between a PHP application and the Pin Payments
HTTP API. To use this class, simply include the following in your code:

```php
<?php
use ABWebDevelopers\PinPayments\ApiClient;

$client = new ApiClient([
  'apiKey' => '', // Your secret API key
  'testMode' => true // Set to false for live data
]);
```


* Class name: ApiClient
* Namespace: ABWebDevelopers\PinPayments





Properties
----------


### $apiKey

    protected string $apiKey

Your Pin Payments Secret API key.



* Visibility: **protected**


### $testMode

    protected boolean $testMode = false

Whether to use the test payment gateway.



* Visibility: **protected**


### $httpClient

    protected \Http\Client\HttpClient $httpClient

HTTP Client to send and receive HTTP messages to the API



* Visibility: **protected**


### $messageProvider

    protected \Http\Message\MessageFactory $messageProvider

Message Provider for the API HTTP messages



* Visibility: **protected**


### $endpoints

    protected array $endpoints = array('balance' => \ABWebDevelopers\PinPayments\Endpoint\Balance::class, 'bankAccounts' => \ABWebDevelopers\PinPayments\Endpoint\BankAccounts::class, 'cards' => \ABWebDevelopers\PinPayments\Endpoint\Cards::class, 'charges' => \ABWebDevelopers\PinPayments\Endpoint\Charges::class, 'recipients' => \ABWebDevelopers\PinPayments\Endpoint\Recipients::class, 'transfers' => \ABWebDevelopers\PinPayments\Endpoint\Transfers::class)

Mapped endpoints for this API client



* Visibility: **protected**


Methods
-------


### __construct

    mixed ABWebDevelopers\PinPayments\ApiClient::__construct(string $apiKey, boolean $testMode, \Http\Client\HttpClient $httpClient, \Http\Message\MessageFactory $messageProvider)

Constructor method.



* Visibility: **public**


#### Arguments
* $apiKey **string** - &lt;p&gt;Your Pin Payments API secret key. Note that if you are in test mode, your API key
may be different.&lt;/p&gt;
* $testMode **boolean** - &lt;p&gt;If true, use the test Pin Payments gateway.&lt;/p&gt;
* $httpClient **Http\Client\HttpClient** - &lt;p&gt;Sets the HTTP client to use for requests and responses. If null,
the API client will attempt to find a suitable client. If one cannot be found, an exception will be
thrown.&lt;/p&gt;
* $messageProvider **Http\Message\MessageFactory** - &lt;p&gt;Set the PSR-7 message provider to use for requests and responses.
If null, the API client will attempt to find a suitable message provider. If one cannot be found, an
exception will be thrown.&lt;/p&gt;



### __get

    void ABWebDevelopers\PinPayments\ApiClient::__get(string $endpoint)

__get() magic method.

Provides an interface to selecting an API endpoint. For example, to use the cards endpoint, you could use:
```php
$client->cards->method()
```

If the API endpoint does not exist, an exception will be thrown.

* Visibility: **public**


#### Arguments
* $endpoint **string**



### getApiKey

    string ABWebDevelopers\PinPayments\ApiClient::getApiKey()

Gets the currently entered API key



* Visibility: **public**




### setApiKey

    void ABWebDevelopers\PinPayments\ApiClient::setApiKey(string $apiKey)

Sets the API key to use for this client.



* Visibility: **public**


#### Arguments
* $apiKey **string** - &lt;p&gt;Your Pin Payments API secret key. Note that if you are in test mode, your API key
may be different.&lt;/p&gt;



### getTestMode

    boolean ABWebDevelopers\PinPayments\ApiClient::getTestMode()

Gets whether we are using the test gateway.



* Visibility: **public**




### setTestMode

    void ABWebDevelopers\PinPayments\ApiClient::setTestMode(boolean $testMode)

Sets whether to use the test gateway or not.



* Visibility: **public**


#### Arguments
* $testMode **boolean** - &lt;p&gt;If true, use the test Pin Payments gateway.&lt;/p&gt;



### getHttpClient

    \Http\Client\HttpClient; ABWebDevelopers\PinPayments\ApiClient::getHttpClient()

Gets the HTTP client in use in this API client.

This function is used by the endpoints to call the API. It wraps the client with the Authentication
Plugin in order to send the necessary credentials to Pin Payments.

* Visibility: **public**




### setHttpClient

    void ABWebDevelopers\PinPayments\ApiClient::setHttpClient(\Http\Client\HttpClient $httpClient)

Sets the HTTP client to use in this API client.



* Visibility: **public**


#### Arguments
* $httpClient **Http\Client\HttpClient** - &lt;p&gt;A valid PHP-HTTP client interface.&lt;/p&gt;



### getMessageProvider

    \Http\Message\MessageFactory; ABWebDevelopers\PinPayments\ApiClient::getMessageProvider()

Gets the PSR-7 Message provider in use in this API client.



* Visibility: **public**




### setMessageProvider

    void ABWebDevelopers\PinPayments\ApiClient::setMessageProvider(\Http\Message\MessageFactory $messageProvider)

Sets the PSR-7 Message provider to use in this API client.



* Visibility: **public**


#### Arguments
* $messageProvider **Http\Message\MessageFactory** - &lt;p&gt;A valid PSR-7 Messages interface.&lt;/p&gt;


