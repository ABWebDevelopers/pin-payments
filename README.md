# Pin Payments API

![Build Status](https://api.travis-ci.org/ABWebDevelopers/pin-payments.svg?branch=master)

This library facilitates the communication between a PHP application and the [Pin Payments](https://pinpayments.com) API.

We recommend using this library if you would like to use the full suite of the Pin Payments API. If you are intending to just charge a credit card as part of a payment or checkout process, we recommend the use of the [Omnipay](https://omnipay.thephpleague.com/) library instead, which has support for Pin Payments among many other payment gateways.

## Requirements

- PHP 7.1 or above

## Installation

Include this library in your application through [Composer](https://getcomposer.org):

```
composer require abwebdevelopers/pin-payments "dev-master"
```

## Currently supported API endpoints

- **Balance**
  - GET /balance
- **Cards**
  - POST /cards

## How to use

Details will be forthcoming once we have some more API endpoints supported.
