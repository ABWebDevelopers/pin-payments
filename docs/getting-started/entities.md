---
layout: default
title: Entities
---
All the types of information that can be passed back and forth through the Pin Payments API have been set up as Entities. Entities
extend the `Entity` class in the `src/Entity` directory. This allows you to set or get the information stored in the entity in several
different ways, and controls what attributes can be set for each entity.

## Getting an attribute value

You can get attribute values in several ways. You can retrieve the value directly using the lowercase-underscore or camel-case format:

```php
$bankNumber = $bankAccount->number;
$currency = $balance->available_currency;
$currency = $balance->availableCurrency;
```

Or you can retrieve it using a getter method, using camel-case:

```php
$bankNumber = $bankAccount->getNumber();
$currency = $balance->getAvailableCurrency();
```

Or you can use the `getValue()` method:

```php
$bankNumber = $bankAccount->getValue('number');
$currency = $balance->getValue('available_currency');
```

If an attribute does not exist in the Entity, a `MissingAttributeException` will be thrown.

## Getting all attribute values

You can retrieve all values in an entity as an array by using the `get()` method:

```php
$recipent = $recipient->get();
```

Entities are also converted to a JSON string when casted a string.

```php
$recipient = strval($recipient);
```

If you wish to get only the attributes that will be sent in the API call, you can use the `getApiData()` method to get this data as an array:

```php
$recipientApiData = $recipient->getApiData();
```

## Masked values

For security purposes, some attributes such as the credit card number or bank account number are returned as a masked value by Pin Payments. After setting some of these values and sending to the API, they will be masked with a *display* attribute. For example:

```php
$bankAccount = new BankAccount([
    'name' => 'John Smith',
    'bsb' => '123456',
    'number' => '987654321'
]);

$number = $bankAccount->getNumber(); // 987654321

$bankAccount = $pinClient->bankAccount->post();

$number = $bankAccount->getNumber(); // XXXXXX321
$number = $bankAccount->getDisplayNumber(); // XXXXXX321
```

You can force the unmasked value to be returned if it was previously available by using the `getValue()` method and setting the second parameter to `true`:

```php
$number = $bankAccount->getValue('number', true); // 987654321
```

Please note that if you have an entity that was loading directly from the Pin Payments API (eg: from a `get()` endpoint call), the original value will **not** be available.

## Setting an attribute value

Like with getting attributes, there are several different ways to set an attribute. You can set the value directly using the lowercase-underscore or camel-case format:

```php
$bankAccount->number = 12345678;
$balance->available_currency = 'AUD';
$balance->availableCurrency = 'AUD'
```

Or you can use a fluent-type interface with setter methods to set the details:

```php
$bankAccount->setNumber(12345678);

$bankAccount
    ->setNumber(12345678)
    ->setBsb(123456);
```

Or you can use the `setValue()` method:

```php
$bankAccount->setValue('number', 12345678);
$balance->setValue('available_currency', 'AUD');
```

All entities have a defined attribute list, and you can only set values for these defined attributes. Setting a value of a non-existent
attribute will throw a `MissingAttributeException` exception.
