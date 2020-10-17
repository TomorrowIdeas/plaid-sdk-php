# Plaid SDK

[![Latest Stable Version](https://img.shields.io/packagist/v/tomorrow-ideas/plaid-sdk-php.svg?style=flat-square)](https://packagist.org/packages/tomorrow-ideas/plaid-sdk-php)
[![Build Status](https://img.shields.io/travis/TomorrowIdeas/plaid-sdk-php.svg?style=flat-square)](https://travis-ci.com/TomorrowIdeas/plaid-sdk-php)
[![Code Coverage](https://img.shields.io/coveralls/github/TomorrowIdeas/plaid-sdk-php.svg?style=flat-square)](https://coveralls.io/github/TomorrowIdeas/plaid-sdk-php)
[![License](https://img.shields.io/github/license/TomorrowIdeas/plaid-sdk-php.svg?style=flat-square)](https://packagist.org/packages/tomorrow-ideas/plaid-sdk-php)

Plaid PHP SDK supporting:
* Link tokens
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
* Investments
* Payment Initiation (UK only)
* Processors (Stripe & Dwolla)

## Official Plaid API docs

For full description of request and response payloads and properties, please see the [official Plaid API docs](https://plaid.com/docs/).

## Requirements

* PHP 7.2+
* ext-curl
* ext-json

## Installation

```bash
composer require tomorrow-ideas/plaid-sdk-php
```

## Configuration

Instantiate the Plaid client class with your credentials.

```php
$client = new \TomorrowIdeas\Plaid\Plaid("your-client-id", "your-secret", "your-public-key");
```

### Environments

The Plaid client by default uses the **production** Plaid API hostname for all API calls. You can change the environment by using the `setEnvironment` method.

Possible environments:

* production
* development
* sandbox

```php
$client->setEnvironment("sandbox");
```

### API Versions

The Plaid client by default uses API version **2019-05-29**. You can change the version by calling the `setVersion` method.

Possible API versions:

* 2019-05-29
* 2018-05-22
* 2017-03-08

```php
$client->setVersion("2019-05-29");
```

### Options

Many methods allow the passing of options to the Plaid endpoint. These options should be an associative array of key/value pairs. The exact options supported are dependent on the endpoint being called. Please refer to the official Plaid documentation for more information.

```php
$options = [
	"foo" => "bar",
	"baz" => "bat"
];
```

## Example
```php
use TomorrowIdeas\Plaid\Plaid;

require __DIR__ . "/vendor/autoload.php";

$plaid = new Plaid(
	\getenv("PLAID_CLIENT_ID"),
	\getenv("PLAID_CLIENT_SECRET"),
	\getevv("PLAID_PUBLIC_KEY")
);

$plaid->setEnvironment(
	\getenv("PLAID_ENVIRONMENT")
);

$item = $plaid->getItem("itm_1234");
```

## Methods

For a full description of the response payload, please see the [official Plaid API docs](https://plaid.com/docs/).

### Link Tokens

```php
createLinkToken(
	string $client_name,
	string $language,
	array $country_codes,
	string $client_user_id,
	array $products = [],
	?string $webhook = null,
	?string $link_customization_name = null,
	?AccountFilters $account_filters = null,
	?string $access_token = null,
	?string $redirect_url = null,
	?string $android_package_name = null,
	?string $payment_id = null): object
```

### Auth

* `getAuth(string $access_token, array $options = []): object` [[?]](https://plaid.com/docs/#auth)

### Liabilities

* `getLiabilities(string $access_token, array $options = []): object` [[?]](https://plaid.com/docs/#liabilities)

### Items

* `getItem(string $access_token): object` [[?]](https://plaid.com/docs/#retrieve-item)
* `removeItem(string $access_token): object` [[?]](https://plaid.com/docs/#remove-an-item)
* `createPublicToken(string $access_token): object` [[?]](https://plaid.com/docs/#creating-public-tokens)
* `exchangeToken(string $public_token): object` [[?]](https://plaid.com/docs/#exchange-token-flow)
* `rotateAccessToken(string $access_token): object` [[?]](https://plaid.com/docs/#rotate-access-token)

### Webhooks

* `getWebhookVerificationKey(string $key_id): object` [[?]](https://plaid.com/docs/#steps-for-verification)
* `updateWebhook(string $access_token, string $webhook): object` [[?]](https://plaid.com/docs/#update-webhook)

### Accounts

* `getAccounts(string $access_token): object` [[?]](https://plaid.com/docs/#accounts)


### Institutions

* `getInstitution(string $institution_id, array $options = []): object` [[?]](https://plaid.com/docs/#institutions-by-id)
* `getInstitutions(int $count, int $offset, array $options = []): object` [[?]](https://plaid.com/docs/#all-institutions)
* `findInstitution(string $query, array $products, array $options = []): object` [[?]](https://plaid.com/docs/#institution-search)

### Transactions

* `getTransactions(string $access_token, DateTime $start_date, DateTime $end_date, array $options = []): object` [[?]](https://plaid.com/docs/#transactions)

### Balance

* `getBalance(string $access_token, array $options = []): object` [[?]](https://plaid.com/docs/#balance)

### Identity

* `getIdentity(string $access_token): object` [[?]](https://plaid.com/docs/#identity)

### Income

* `getIncome(string $access_token): object` [[?]](https://plaid.com/docs/#income)

### Assets

* `createAssetReport(array $access_tokens, int $days_requested, array $options = []): object` [[?]](https://plaid.com/docs/#assets)
* `refreshAssetReport(string $asset_report_token, int $days_requested, array $options = []): object` [[?]](https://plaid.com/docs/#assets)
* `filterAssetReport(string $asset_report_token, array $exclude_accounts): object` [[?]](https://plaid.com/docs/#assets)
* `getAssetReport(string $asset_report_token, bool $include_insights = false): object` [[?]](https://plaid.com/docs/#assets)
* `getAssetReportPdf(string $asset_report_token): ResponseInterface` [[?]](https://plaid.com/docs/#assets) **Note:** Because this endpoint returns PDF content in the repsponse body, this method returns an instance of a PSR-7 `ResponseInterface`. You may leverage the `Response` object to stream the PDF back to the requesting client and access response headers. See [official Plaid API docs](https://plaid.com/docs/) for more information.
* `removeAssetReport(string $asset_report_token): object` [[?]](https://plaid.com/docs/#assets)
* `createAssetReportAuditCopy(string $asset_report_token, string $auditor_id): object` [[?]](https://plaid.com/docs/#assets)
* `removeAssetReportAuditCopy(string $audit_copy_token): object` [[?]](https://plaid.com/docs/#assets)

### Investments

* `getInvestmentHoldings(string $access_token, array $options = []): object` [[?]](https://plaid.com/docs/#investments)
* `getInvestmentTransactions(string $access_token, DateTime $start_date, DateTime $end_date, array $options = []): object` [[?]](https://plaid.com/docs/#investments)

### Payment Initiation (UK only)

* `createRecipient(string $name, string $iban, RecipientAddress $address): object` [[?]](https://plaid.com/docs/#payment-initiation) **Note:** See the **Entities** section for details about the `RecipientAddress` entity needed for this method.
* `getRecipient(string $recipient_id): object` [[?]](https://plaid.com/docs/#payment-initiation)
* `listRecipients(): object` [[?]](https://plaid.com/docs/#payment-initiation)
* `createPayment(string $recipient_id, string $reference, float $amount, string $currency, PaymentSchedule $payment_schedule = null): object` [[?]](https://plaid.com/docs/#payment-initiation)
* `createPaymentToken(string $payment_id): object` [[?]](https://plaid.com/docs/#payment-initiation)
* `getPayment(string $payment_id): object` [[?]](https://plaid.com/docs/#payment-initiation)
* `listPayments(array $options = []): object` [[?]](https://plaid.com/docs/#payment-initiation)

### Processors

* `createStripeToken(string $access_token, string $account_id): object` [[?]](https://plaid.com/docs/stripe)
* `createDwollaToken(string $access_token, string $account_id): object` [[?]](https://plaid.com/docs/dwolla)

## Entities

### RecipientAddress

The `TomorrowIdeas\Plaid\Entities\RecipientAddress` entity is used to represent an address object for the recipient of a payment request.

Example:

```php
$address = new TomorrowIdeas\Plaid\Entities\RecipientAddress("123 Elm St.", "Apt 1", "Anytown", "ABC 123", "GB");
```

### PaymentSchedule

Example:

The `TomorrowIdeas\Plaid\Entities\PaymnentSchedule` entity is used when creating a new payment that will be a recurring charge.
See `createPayment` method for more information.

```php
$payment_schedule = new TomorrowIdeas\Plaid\Entities\PaymnentSchedule(
    PaymentSchedule::INTERVAL_MONTHLY,
    15,
    new DateTime("2020-10-01")
);
```

## Errors

All unsuccessfull (non 2xx) responses will throw a `PlaidRequestException`. The full response object is available via the `getResponse()` method.