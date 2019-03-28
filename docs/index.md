---
layout: default
title: PHP Pin Payments API Library
---

This library allows you to connect to the [Pin Payments API](https://pinpayments.com) from your PHP application. Simply
include the library using [Composer](https://getcomposer.org), or by downloading the builds above in `tar.gz` or `zip`
format, and follow the documentation below to make transfers and charges, save recipients and cards and use the wide
variety of functionality available through the Pin Payments API in your PHP app.

## Use Case

We recommend using this library if you would like to use the full suite of the Pin Payments API. If you are intending to
just charge a credit card as part of a payment or checkout process, we recommend the use of the
[Omnipay](https://omnipay.thephpleague.com/) library instead, which has support for Pin Payments among many other
payment gateways.

## Requirements

- PHP 7.1 or above

## Installation

Include this library in your application through [Composer](https://getcomposer.org):

```bash
composer require abwebdevelopers/pin-payments "dev-master"
```

This library uses the [HTTPlug](http://httplug.io/) abstraction layer to allow you to use your preferred HTTP client.
This will mean that your project will need a compatible HTTP client available to work. If you have the `curl` extension
enabled on your server, you may include the following libraries to satisy this requirement:

```bash
composer require php-http/curl-client "^1.7"
composer require guzzlehttp/psr7 "^1.4"
```

Alternatively, you can also use Guzzle as your HTTP client:

```bash
composer require guzzlehttp/guzzle "~6.0"
```

You may need to this before installing this library for your project. You may review the
[compatible clients and adapters here](http://docs.php-http.org/en/latest/clients.html).
