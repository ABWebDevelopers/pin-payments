ABWebDevelopers\PinPayments\ApiRequest
===============






* Class name: ApiRequest
* Namespace: ABWebDevelopers\PinPayments





Properties
----------


### $urls

    protected array $urls = array('live' => 'https://api.pinpayments.com/1/', 'test' => 'https://test-api.pinpayments.com/1/')

The main API URLs



* Visibility: **protected**


### $client

    protected \ABWebDevelopers\PinPayments\ABWebDevelopers\PinPayments\ApiClient $client

The API client



* Visibility: **protected**


### $endpoint

    protected string $endpoint

The API endpoint to use



* Visibility: **protected**


### $method

    protected string $method

The HTTP post method to use



* Visibility: **protected**


### $data

    protected array $data = array()

The data to send to the API



* Visibility: **protected**


### $endpointVars

    protected array $endpointVars = array()

Any endpoint variables that need to be injected into the URL



* Visibility: **protected**


Methods
-------


### __construct

    mixed ABWebDevelopers\PinPayments\ApiRequest::__construct(\ABWebDevelopers\PinPayments\ApiClient $client, \ABWebDevelopers\PinPayments\string $method, \ABWebDevelopers\PinPayments\string $endpoint, array $data, array $endpointVars)





* Visibility: **public**


#### Arguments
* $client **[ABWebDevelopers\PinPayments\ApiClient](ABWebDevelopers-PinPayments-ApiClient.md)**
* $method **ABWebDevelopers\PinPayments\string**
* $endpoint **ABWebDevelopers\PinPayments\string**
* $data **array**
* $endpointVars **array**



### send

    mixed ABWebDevelopers\PinPayments\ApiRequest::send()





* Visibility: **public**




### createRequest

    mixed ABWebDevelopers\PinPayments\ApiRequest::createRequest()





* Visibility: **protected**




### getRequestUrl

    mixed ABWebDevelopers\PinPayments\ApiRequest::getRequestUrl()





* Visibility: **protected**




### getPostData

    mixed ABWebDevelopers\PinPayments\ApiRequest::getPostData()





* Visibility: **protected**



