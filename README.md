# Plaid SDK

[![Latest Stable Version](https://img.shields.io/packagist/v/tomorrow-ideas/plaid-sdk-php.svg?style=flat-square)](https://packagist.org/packages/tomorrow-ideas/plaid-sdk-php)
[![Build Status](https://img.shields.io/travis/TomorrowIdeas/plaid-sdk-php.svg?style=flat-square)](https://travis-ci.org/TomorrowIdeas/plaid-sdk-php)
[![Code Coverage](https://img.shields.io/coveralls/github/TomorrowIdeas/plaid-sdk-php.svg?style=flat-square)](https://coveralls.io/github/TomorrowIdeas/plaid-sdk-php)
[![License](https://img.shields.io/github/license/TomorrowIdeas/plaid-sdk-php.svg?style=flat-square)](https://packagist.org/packages/tomorrow-ideas/plaid-sdk-php)

Plaid PHP SDK supporting:
* Auth
* Items
* Accounts
* Institutions
* Webhooks
* Identity
* Income
* Assets
* Balance
* Liabilities
* Processors (Stripe)

## Official Plaid API docs

For full description of request and response payloads and properties, please see the [official Plaid API docs](https://plaid.com/docs/).

## Requirements

* PHP 7.2+
* ext-curl
* ext-json

## Installation

```bash
composer require tomorrow-ideas/plaid-sdk-php
````

## Configuration

Instantiate the Plaid client class with your credentials.

```php
$client = new Plaid("your-client-id", "your-secret", "your-public-key");
```

### Environments

The Plaid client by default uses the **production** Plaid API hostname for all API calls. You can change the environment by using the ```setEnvironment``` method.

Possible environments:

* production
* development
* sandbox

```php
$client->setEnvironment("sandbox");
```

### API Versions

The Plaid client by default uses API version **2019-05-29**. You can change the version by calling the ```setVersion``` method.

Possible API versions:

* 2019-05-29
* 2018-05-22
* 2017-03-08

```php
$client->setVersion("2019-05-29");
```

## Methods

For a full description of the response payload, please see the [official Plaid API docs](https://plaid.com/docs/).

### Auth

* ```getAuth(string $access_token, array $options = []): object```

### Liabilities

* ```getLiabilities(string $access_token, array $options = []): object```

### Items

* ```getItem(string $access_token): object```
* ```removeItem(string $access_token): object```
* ```createPublicToken(string $access_token): object```
* ```exchangeToken(string $public_token): object```
* ```rotateAccessToken(string $access_token): object```
* ```updateWebhook(string $access_token, string $webook): object```

### Accounts

* ```getAccounts(string $access_token): object```

### Institutions

* ```getInstitution(string $institution_id, array $options = []): object```
* ```getInstitutions(int $count, int $offset, array $options = []): object```
* ```findInstitution(string $query, array $products, array $options = []): object```

### Transactions

* ```getTransactions(string $access_token, DateTime $start_date, DateTime $end_date, array $options = []): object```

### Balance

* ```getBalance(string $access_token, array $options = []): object```

### Identity

* ```getIdentity(string $access_token): object```

### Income

* ```getIncome(string $access_token): object```

### Assets

* ```createAssetReport(array $access_tokens, int $days_requested, array $options = []): object```
* ```refreshAssetReport(string $asset_report_token, int $days_requested, array $options = []): object```
* ```filterAssetReport(string $asset_report_token, array $exclude_accounts): object```
* ```getAssetReport(string $asset_report_token, bool $include_insights = false): object```
* ```getAssetReportPdf(string $asset_report_token, bool $include_insights = false): ResponseInterface``` **Note:** Because this endpoint returns PDF content in the repsponse body, this method returns an instance of a PSR-7 ```ResponseInterface```. You may leverage the ```Response``` object to stream the PDF back to the requesting client and access response headers. See [official Plaid API docs](https://plaid.com/docs/) for more information.
* ```removeAssetReport(string $asset_report_token): object```
* ```createAssetReportAuditCopy(string $asset_report_token, string $auditor_id): object```
* ```removeAssetReportAuditCopy(string $audit_copy_token): object```

### Processors

* ```createStripeToken(string $access_token, string $account_id): object```

## Errors

All unsuccessfull (non 2xx) responses will throw a ```PlaidRequestException```. The full response object is available via the ```getResponse()``` method.
