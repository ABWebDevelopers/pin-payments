ABWebDevelopers\PinPayments\Entity\Entity
===============

Entity Class.

An entity class represents a single instance of data that can be sent through the Pin Payments API. This can
be a card, or a recipient, or a charge, etc. Entities have


* Class name: Entity
* Namespace: ABWebDevelopers\PinPayments\Entity
* This is an **abstract** class





Properties
----------


### $attributes

    protected array $attributes = array()

An array of available attributes for this entity.

Attributes should be specified as an array in the following format:
[attribute name] => [attribute type]
`attribute type` can be any one of the following: `string`, `bool`, `int`, `float` and `array`
or a fully-qualified class name.

* Visibility: **protected**


### $apiAttributes

    protected array $apiAttributes = array()

An array of attributes that are sent with the Pin Payments API request.

This should contain a list of attribute names that will be sent through to the Pin Payments API on request.

* Visibility: **protected**


### $masked

    protected array $masked = array()

An array of attributes that are masked by another value.

Some attributes, for security purposes, may be masked by a "display" value. To define this, use the following
array:

[original attribute] => [masked attribute]

Masked values will be displayed using any normal "get" method calls, and will only be returned unmasked if the
first parameter of the main "get" method is true.

* Visibility: **protected**


### $data

    protected array $data = array()

An array containing the current attritube data for this entity.



* Visibility: **protected**


### $inflector

    protected \ABWebDevelopers\PinPayments\Entity\ICanBoogie\Inflector $inflector

Inflector class.



* Visibility: **protected**


Methods
-------


### __construct

    mixed ABWebDevelopers\PinPayments\Entity\Entity::__construct($data)





* Visibility: **public**


#### Arguments
* $data **mixed**



### __call

    mixed ABWebDevelopers\PinPayments\Entity\Entity::__call(\ABWebDevelopers\PinPayments\Entity\string $name, array $arguments)





* Visibility: **public**


#### Arguments
* $name **ABWebDevelopers\PinPayments\Entity\string**
* $arguments **array**



### __get

    mixed ABWebDevelopers\PinPayments\Entity\Entity::__get(\ABWebDevelopers\PinPayments\Entity\string $attribute)





* Visibility: **public**


#### Arguments
* $attribute **ABWebDevelopers\PinPayments\Entity\string**



### __set

    mixed ABWebDevelopers\PinPayments\Entity\Entity::__set(\ABWebDevelopers\PinPayments\Entity\string $attribute, $newValue)





* Visibility: **public**


#### Arguments
* $attribute **ABWebDevelopers\PinPayments\Entity\string**
* $newValue **mixed**



### __isset

    mixed ABWebDevelopers\PinPayments\Entity\Entity::__isset(\ABWebDevelopers\PinPayments\Entity\string $attribute)





* Visibility: **public**


#### Arguments
* $attribute **ABWebDevelopers\PinPayments\Entity\string**



### __unset

    mixed ABWebDevelopers\PinPayments\Entity\Entity::__unset(\ABWebDevelopers\PinPayments\Entity\string $attribute)





* Visibility: **public**


#### Arguments
* $attribute **ABWebDevelopers\PinPayments\Entity\string**



### __toString

    mixed ABWebDevelopers\PinPayments\Entity\Entity::__toString()





* Visibility: **public**




### get

    mixed ABWebDevelopers\PinPayments\Entity\Entity::get(\ABWebDevelopers\PinPayments\Entity\bool $unmasked)





* Visibility: **public**


#### Arguments
* $unmasked **ABWebDevelopers\PinPayments\Entity\bool**



### set

    mixed ABWebDevelopers\PinPayments\Entity\Entity::set(array $data)





* Visibility: **public**


#### Arguments
* $data **array**



### getApiData

    mixed ABWebDevelopers\PinPayments\Entity\Entity::getApiData(\ABWebDevelopers\PinPayments\Entity\bool $association)





* Visibility: **public**


#### Arguments
* $association **ABWebDevelopers\PinPayments\Entity\bool**



### getValue

    mixed ABWebDevelopers\PinPayments\Entity\Entity::getValue(\ABWebDevelopers\PinPayments\Entity\string $attribute, \ABWebDevelopers\PinPayments\Entity\bool $unmasked)





* Visibility: **public**


#### Arguments
* $attribute **ABWebDevelopers\PinPayments\Entity\string**
* $unmasked **ABWebDevelopers\PinPayments\Entity\bool**



### setValue

    mixed ABWebDevelopers\PinPayments\Entity\Entity::setValue(\ABWebDevelopers\PinPayments\Entity\string $attribute, $newValue)





* Visibility: **public**


#### Arguments
* $attribute **ABWebDevelopers\PinPayments\Entity\string**
* $newValue **mixed**



### listAttributes

    mixed ABWebDevelopers\PinPayments\Entity\Entity::listAttributes()





* Visibility: **public**




### listApiAttributes

    mixed ABWebDevelopers\PinPayments\Entity\Entity::listApiAttributes()





* Visibility: **public**




### hasAttribute

    mixed ABWebDevelopers\PinPayments\Entity\Entity::hasAttribute(\ABWebDevelopers\PinPayments\Entity\string $attribute)





* Visibility: **public**


#### Arguments
* $attribute **ABWebDevelopers\PinPayments\Entity\string**



### validateValue

    mixed ABWebDevelopers\PinPayments\Entity\Entity::validateValue(\ABWebDevelopers\PinPayments\Entity\string $attribute, $value)





* Visibility: **protected**


#### Arguments
* $attribute **ABWebDevelopers\PinPayments\Entity\string**
* $value **mixed**



### castValue

    mixed ABWebDevelopers\PinPayments\Entity\Entity::castValue(\ABWebDevelopers\PinPayments\Entity\string $attribute, $value)





* Visibility: **protected**


#### Arguments
* $attribute **ABWebDevelopers\PinPayments\Entity\string**
* $value **mixed**



### booleanCheck

    mixed ABWebDevelopers\PinPayments\Entity\Entity::booleanCheck(\ABWebDevelopers\PinPayments\Entity\string $attribute, \ABWebDevelopers\PinPayments\Entity\bool $isFalse)





* Visibility: **protected**


#### Arguments
* $attribute **ABWebDevelopers\PinPayments\Entity\string**
* $isFalse **ABWebDevelopers\PinPayments\Entity\bool**



### onGetApiData

    mixed ABWebDevelopers\PinPayments\Entity\Entity::onGetApiData(array $data, \ABWebDevelopers\PinPayments\Entity\bool $associated)





* Visibility: **protected**


#### Arguments
* $data **array**
* $associated **ABWebDevelopers\PinPayments\Entity\bool**


