<?php
namespace ABWebDevelopers\PinPayments;

use Http\Client\HttpClient;
use Http\Client\Common\PluginClient;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Message\Authentication\BasicAuth;
use Http\Message\MessageFactory;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use ABWebDevelopers\PinPayments\Endpoint\Exception\InvalidEndpointException;

/**
 * API Client class
 *
 * The main class that instantiates a connection between a PHP application and the Pin Payments
 * HTTP API. To use this class, simply include the following in your code:
 *
 * ```php
 * <?php
 * use ABWebDevelopers\PinPayments\ApiClient;
 *
 * $client = new ApiClient([
 *   'apiKey' => '', // Your secret API key
 *   'testMode' => true // Set to false for live data
 * ]);
 * ```
 *
 * @author Ben Thomson <ben@abweb.com.au>
 * @copyright 2018 AB Web Developers
 * @since 0.1.0
 * @license MIT
 */
class ApiClient
{
    /**
     * Your Pin Payments Secret API key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Whether to use the test payment gateway.
     *
     * @var boolean
     */
    protected $testMode = false;

    /**
     * HTTP Client to send and receive HTTP messages to the API
     *
     * @var \Http\Client\HttpClient
     */
    protected $httpClient;

    /**
     * Message Provider for the API HTTP messages
     *
     * @var \Http\Message\MessageFactory
     */
    protected $messageProvider;

    /**
     * Mapped endpoints for this API client
     *
     * @var array
     */
    protected $endpoints = [
        'balance' => \ABWebDevelopers\PinPayments\Endpoint\Balance::class,
        'bankAccounts' => \ABWebDevelopers\PinPayments\Endpoint\BankAccounts::class,
        'cards' => \ABWebDevelopers\PinPayments\Endpoint\Cards::class,
        'charges' => \ABWebDevelopers\PinPayments\Endpoint\Charges::class,
        'recipients' => \ABWebDevelopers\PinPayments\Endpoint\Recipients::class,
        'transfers' => \ABWebDevelopers\PinPayments\Endpoint\Transfers::class,
        'customers' => \ABWebDevelopers\PinPayments\Endpoint\Customers::class
    ];

    /**
     * Constructor method.
     *
     * @param string $apiKey Your Pin Payments API secret key. Note that if you are in test mode, your API key
     * may be different.
     * @param boolean $testMode If true, use the test Pin Payments gateway.
     * @param HttpClient $httpClient Sets the HTTP client to use for requests and responses. If null,
     * the API client will attempt to find a suitable client. If one cannot be found, an exception will be
     * thrown.
     * @param MessageFactory $messageProvider Set the PSR-7 message provider to use for requests and responses.
     * If null, the API client will attempt to find a suitable message provider. If one cannot be found, an
     * exception will be thrown.
     *
     * @throws \Http\Discovery\Exception\DiscoveryFailedException If the HTTP client or PSR-7 message provider
     * are not specified, and the API client could not find a suitable candidate to use.
     */
    public function __construct(
        string $apiKey,
        bool $testMode = false,
        HttpClient $httpClient = null,
        MessageFactory $messageProvider = null
    ) {
        $this->apiKey = $apiKey;
        $this->testMode = $testMode;
        $this->httpClient = $httpClient ?? HttpClientDiscovery::find();
        $this->messageProvider = $messageProvider ?? MessageFactoryDiscovery::find();
    }

    /**
     * __get() magic method.
     *
     * Provides an interface to selecting an API endpoint. For example, to use the cards endpoint, you could use:
     * ```php
     * $client->cards->method()
     * ```
     *
     * If the API endpoint does not exist, an exception will be thrown.
     *
     * @param string $endpoint
     * @return void
     *
     * @throws \ABWebDevelopers\PinPayments\Endpoint\Exception\InvalidEndpointException If the selected API endpoint
     * does not exist.
     */
    public function __get(string $endpoint)
    {
        if (isset($this->endpoints[$endpoint])) {
            return new $this->endpoints[$endpoint]($this);
        } else {
            throw new InvalidEndpointException('The specified API endpoint does not exist.');
        }
    }

    /**
     * Gets the currently entered API key
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Sets the API key to use for this client.
     *
     * @param string $apiKey Your Pin Payments API secret key. Note that if you are in test mode, your API key
     * may be different.
     * @return void
     */
    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = strval($apiKey);
    }

    /**
     * Gets whether we are using the test gateway.
     *
     * @return boolean
     */
    public function getTestMode(): bool
    {
        return $this->testMode;
    }

    /**
     * Sets whether to use the test gateway or not.
     *
     * @param boolean $testMode If true, use the test Pin Payments gateway.
     * @return void
     */
    public function setTestMode(bool $testMode): void
    {
        $this->testMode = $testMode;
    }

    /**
     * Gets the HTTP client in use in this API client.
     *
     * This function is used by the endpoints to call the API. It wraps the client with the Authentication
     * Plugin in order to send the necessary credentials to Pin Payments.
     *
     * @return \Http\Client\HttpClient;
     */
    public function getHttpClient(): HttpClient
    {
        $plugins = [
            new AuthenticationPlugin(
                new BasicAuth($this->getApiKey(), '')
            )
        ];

        return new PluginClient(
            $this->httpClient,
            $plugins
        );
    }

    /**
     * Sets the HTTP client to use in this API client.
     *
     * @param \Http\Client\HttpClient $httpClient A valid PHP-HTTP client interface.
     * @return void
     */
    public function setHttpClient(HttpClient $httpClient): void
    {
        $this->httpClient = strval($httpClient);
    }

    /**
     * Gets the PSR-7 Message provider in use in this API client.
     *
     * @return \Http\Message\MessageFactory;
     */
    public function getMessageProvider(): MessageFactory
    {
        return $this->messageProvider;
    }

    /**
     * Sets the PSR-7 Message provider to use in this API client.
     *
     * @param MessageFactory $messageProvider A valid PSR-7 Messages interface.
     * @return void
     */
    public function setMessageProvider(MessageFactory $messageProvider): void
    {
        $this->messageProvider = strval($messageProvider);
    }
}
