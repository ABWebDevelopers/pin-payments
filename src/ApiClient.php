<?php
namespace ABWebDevelopers\PinPayments;

use Http\Client\HttpClient;
use Http\Client\Common\PluginClient;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Message\Authentication\BasicAuth;
use Http\Message\MessageFactory;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;

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
     * @var Http\Client\HttpClient
     */
    protected $httpClient;

    /**
     * Message Provider for the API HTTP messages
     *
     * @var Http\Message\MessageFactory
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
        'recipients' => \ABWebDevelopers\PinPayments\Endpoint\Recipients::class
    ];

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

    public function __get(string $endpoint)
    {
        if (isset($this->endpoints[$endpoint])) {
            return new $this->endpoints[$endpoint]($this);
        }
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = strval($apiKey);
    }

    public function getTestMode(): bool
    {
        return $this->testMode;
    }

    public function setTestMode(bool $testMode): void
    {
        $this->testMode = $testMode;
    }

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

    public function setHttpClient(HttpClient $httpClient): void
    {
        $this->httpClient = strval($httpClient);
    }

    public function getMessageProvider(): MessageFactory
    {
        return $this->messageProvider;
    }

    public function setMessageProvider(MessageFactory $messageProvider): void
    {
        $this->messageProvider = strval($messageProvider);
    }
}
