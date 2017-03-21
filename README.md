ValPal PHP
-------
[![Author](https://img.shields.io/badge/author-@jedkirby-blue.svg?style=flat-square)](https://twitter.com/jedkirby)
[![Build Status](https://img.shields.io/travis/jedkirby/valpal-php/master.svg?style=flat-square)](https://travis-ci.org/jedkirby/valpal-php)
[![Test Coverage](https://img.shields.io/coveralls/jedkirby/valpal-php/master.svg?style=flat-square)](https://coveralls.io/github/jedkirby/valpal-php)
[![Packagist](https://img.shields.io/packagist/vpre/jedkirby/valpal-php.svg?style=flat-square)](https://packagist.org/packages/jedkirby/valpal-php)
[![Packagist](https://img.shields.io/packagist/l/jedkirby/valpal-php.svg?style=flat-square)](https://github.com/jedkirby/valpal-php/blob/master/LICENSE)

A simple API wrapper, written in PHP, for the ValPal API, provided by Angels Media - https://valpal.co.uk.

Installation
-------

This package can be installed via [Composer]:

``` bash
$ composer require jedkirby/valpal-php
```

It requires **PHP >= 5.6.4**.

Usage
-------

Before using this package, a few steps need to be taken.

### Configuration

This package requires that you pass a configuration class, which holds connection details that persist across multiple valuation requests. The configuration class constructor has two required parameters, and two optional. In this order, these are:

- `$username` `string` : API Username **(Required)**
- `$password` `string` : API Password **(Required)**
- `$endpoint` `string` : API Endpoint
- `$debug` `boolean` : API Debugging

``` php
use Jedkirby\ValPal\Config;

$config = new Config(
  'james.kirby',
  '89b8v0gq9ea'
);
```

The class also has the following getter public methods:

- `$config->getUsername()` `string` : `james.kirby`
- `$config->getPassword()` `string` : `89b8v0gq9ea`
- `$config->getEndpoint()` `string` : `https://www.valpal.co.uk/api`
- `$config->isDebug()` `boolean` : `false`

And has the following setter methods:

- `$config->setUsername($username)` `string`
- `$config->setPassword($password)` `string`
- `$config->setEndpoint($endpoint)` `string`
- `$config->setDebug($debug)` `boolean`

### Valuation Request

Before being able to make any type of request, it's required that you create a valuation request object which, when combined with the above `Config` class, will eventually be passed through to the `Client` class to form a complete request.

All the below options are correct as defined by [PAF].

The valuation request constructor has six required parameters, and four optional. In this order, these are:

- `$buildingName` `string` : This is the name of a building containing more than one residence **(Required)**
- `$subBuildingName` `string` : This is the name or number of a sub building **(Required)**
- `$number` `string` : Number of the main property **(Required)**
- `$street` `string` : Street where property exists **(Required)**
- `$dependentStreet` `string` : Dependent Street where property exists **(Required)**
- `$postcode` `string` : Postcode of property **(Required)**
- `$email` `string` : Email address of the user who generated the lead
- `$name` `string` : Name of the user who generated the lead
- `$phone` `string` : Phone number of the user who generated the lead
- `$reference` `string` : This is the reference number supplied by the client

``` php
use Jedkirby\ValPal\Entity\ValuationRequest;

$request = new ValuationRequest(
  'Building Name',
  'Sub-Building Name',
  '2',
  'Street',
  'Dependent Street',
  'A12 3BC',
  'joe@email.com',
  'Joe Bloggs',
  '01789123456',
  '13S0A138G'
);
```

### Request Types

With the above `Config` and `ValuationRequest` you're now able to create the `Client` responsible for making the request. You'll need to pass the `$config` that was created earlier to the constuctor of this class, like so:

``` php
use Jedkirby\ValPal\Client;

$client = new Client($config);
```

With the client object, there are three public methods available to use, which dictate the type of request you may require. Each of these methods requires the `ValuationRequest` object.

- `$client->getLettingValuation(ValuationRequest $request)`
- `$client->getSalesValuation(ValuationRequest $request)`
- `$client->getBothValuations(ValuationRequest $request)`

Each of the above methods will return a single valuation entity, providing there were no errors during the request.

### Responses

Depending on the request type that's called, you'll receive a different type of response entity, all of which extend a base entity, which is `\Jedkirby\ValPal\Entity\AbstractValuation`. The following response entities are returned:

- **Letting Valuation**: `\Jedkirby\ValPal\Entity\LettingValuation`
- **Sales Valuation**: `\Jedkirby\ValPal\Entity\SalesValuation`

Both the above entities have the following public getter methods:

- `$valuation->getMinValuation()` `string` : `£130000`
- `$valuation->getValuation()` `string` : `£187500`
- `$valuation->getMaxValuation()` `string` : `£256800`
- `$valuation->getPropertyType()` `string` : `Flat`
- `$valuation->getTenure()` `string` : `Leasehold`
- `$valuation->getBedrooms()` `int` : `2`
- `$valuation->getPropertyConstructionYear()` `int` : `1988`

The third response entity is:

- **Both Valuations**: `\Jedkirby\ValPal\Entity\BothValuation`

In addition to the public getter methods in the `LettingValuation` and `SalesValuation` entities, the `BothValuation` entity provides the following:

- `$valuation->getMinRentalValuation()` `string` : `£400`
- `$valuation->getRentalValuation()` `string` : `£500`
- `$valuation->getMaxRentalValuation()` `string` : `£600`

All of the above three valuations have the following public getter helper methods:

- `$valuation->getType()` `string` : `letting`, `sales`, or `both`
- `$valuation->isLetting()` `boolean`
- `$valuation->isSales()` `boolean`
- `$valuation->isLettingAndSales()` `boolean`

### Exceptions

When something goes wrong during the request or the parsing of the API data, this package will throw a single exception with different error messages. The following is the exception that you'll be able to catch and process, it extends [PHP's default exception](http://php.net/manual/en/class.exception.php):

``` php
\Jedkirby\ValPal\Exception\ResponseException;
```

Testing
-------

Unit tests can be run inside the package:

``` bash
$ ./vendor/bin/phpunit
```

Contributing
-------

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

License
-------

**jedkirby/valpal-php** is licensed under the MIT license. See the [LICENSE](LICENSE) file for more details.

[Composer]: https://getcomposer.org
[PAF]: http://www.pcapredict.com/en-gb/royal-mail-paf
