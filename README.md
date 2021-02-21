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
* Processors (including Stripe & Dwolla)
* Bank Transfers (US only)
* Sandbox

## Official Plaid API docs

For full description of request and response payloads and properties, please see the [official Plaid API docs](https://plaid.com/docs/).

## Requirements

* PHP 7.3+
* ext-curl
* ext-json

## Installation

```bash
composer require tomorrow-ideas/plaid-sdk-php
```

## Configuration

Instantiate the Plaid client class with your credentials.

```php
$client = new \TomorrowIdeas\Plaid\Plaid("your-client-id", "your-secret", "environment");
```

### Environments

The Plaid client by default uses the **production** Plaid API hostname for all API calls. You can change the environment by using the `setEnvironment` method.

Possible environments:

* production
* development
* sandbox

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
	\getenv("PLAID_ENVIRONMENT")
);

$item = $plaid->items->get("itm_1234");
```

## Resources

For a full description of the response payload, please see the [official Plaid API docs](https://plaid.com/docs/).

### Accounts

Resource: `accounts`

Reference: https://plaid.com/docs/#accounts

Methods:

* `list(string $access_token, array $options = []): object`
* `getBalance(string $access_token, array $options = []): object`
* `getIdentity(string $access_token): object`


Example:
```php
$accounts = $plaid->accounts->list($access_token);
```

### Auth

Resource: `auth`

Reference: https://plaid.com/docs/#auth

Methods:

* `get(string $access_token, array $options = []): object`

Example:
```php
$auth = $plaid->auth->get($access_token);
```

### Bank Transfers (U.S. only)

Resource: `bank_transfers`

Reference: https://plaid.com/docs/bank-transfers/

Methods:

```php
create(
	string $access_token,
	string $idempotency_key,
	string $type,
	string $account_id,
	string $network,
	string $amount,
	string $currency_code,
	AccountHolder $account_holder,
	string $description,
	string $ach_class = null,
	string $custom_tag = null,
	array $metadata = [],
	string $origination_account_id = null): object
```

* `cancel(string $bank_transfer_id): object`
* `get(string $bank_transfer_id): object`
* `list(
		?DateTime $start_date = null,
		?DateTime $end_date = null,
		?int $count = null,
		?int $offset = null,
		?string $direction = null,
		?string $origination_account_id = null): object
`
* `getEventList(
		?DateTime $start_date = null,
		?DateTime $end_date = null,
		?string $bank_transfer_id = null,
		?string $account_id = null,
		?string $bank_transfer_type = null,
		array $event_type = [],
		?int $count = null,
		?int $offset = null,
		?string $direction = null,
		?string $origination_account_id = null): object
`
* `syncEvents(string $after_id, ?int $count = null): object`
* `migrateAccount(string $account_number, string $routing_number, string $account_type): object`
* `getOriginationAccountBalance(string $origination_account_id = null): object`

Example:
```php
$transfers = $plaid->bank_transfers->list();
```
### Categories

Resource: `categories`

Reference: https://plaid.com/docs/api/products/#categoriesget

Methods:

* `list(): object`

Example:
```php
$categories = $plaid->categories->list();
```

### Institutions

Resource: `insitutions`

Reference: https://plaid.com/docs/api/institutions/

Methods:

* `get(string $institution_id, array $country_codes, array $options = []): object`
* `list(int $count, int $offset, array $country_codes, array $options = []): object`
* `find(string $query, array $country_codes, array $products = [], array $options = []): object`

Example:
```php
$institutions = $plaid->institutions->list(20, 0);
```

### Investments

Resource: `investments`

Reference: https://plaid.com/docs/api/products/#investments

Methods:

* `listHoldings(string $access_token, array $options = []): object`
* `listTransactions(string $access_token, DateTime $start_date, DateTime $end_date, array $options = []): object`

Example:
```php
$holdings = $plaid->investments->listHoldings($access_token);
```
### Tokens

Resource: `tokens`

Reference: https://plaid.com/docs/api/tokens/

Methods:

```php
create(string $client_name,
	string $language,
	array $country_codes,
	User $user,
	array $products = [],
	?string $webhook = null,
	?string $link_customization_name = null,
	?AccountFilters $account_filters = null,
	?string $access_token = null,
	?string $redirect_url = null,
	?string $android_package_name = null,
	?string $payment_id = null): object
```

`get(string $link_token): object`

Example:
```php
$token = $plaid->tokens->create($client_name, $language, ["US","CA"], $user_id);
```

### Liabilities

Resource: `liabilities`

Reference: https://plaid.com/docs/api/products/#liabilities

Methods:

* `list(string $access_token, array $options = []): object`

Example:
```php
$liabilities = $plaid->liabilities->list($access_token);
```

### Items

Resource: `items`

Reference: https://plaid.com/docs/api/items/

Methods:

* `get(string $access_token): object`
* `remove(string $access_token): object`
* `getIncome(string $access_token): object`
* `createPublicToken(string $access_token): object`
* `exchangeToken(string $public_token): object`
* `rotateAccessToken(string $access_token): object`

```php
$item = $plaid->items->get($access_token);
```

### Webhooks

Resource: `webhooks`

Reference: https://plaid.com/docs/api/webhooks/

Methods:

* `getVerificationKey(string $key_id): object`
* `update(string $access_token, string $webhook): object`

Example:
```php
$verification_key = $plaid->webhooks->getVerificationKey($key_id);
```

### Transactions

Resource: `transactions`

Reference: https://plaid.com/docs/api/products/#transactions

Methods:

* `list(string $access_token, DateTime $start_date, DateTime $end_date, array $options = []): object`
* `refresh(string $access_token): object`

Example:
```php
$transactions = $plaid->transactions->list($access_token, $start_date, $end_date);
```

### Reports

Resource: `reports`

Reference: https://plaid.com/docs/assets/

Methods:

* `createAssetReport(array $access_tokens, int $days_requested, array $options = []): object`
* `refreshAssetReport(string $asset_report_token, int $days_requested, array $options = []): object`
* `filterAssetReport(string $asset_report_token, array $exclude_accounts): object`
* `getAssetReport(string $asset_report_token, bool $include_insights = false): object`
* `getAssetReportPdf(string $asset_report_token): ResponseInterface` **Note:** Because this endpoint returns PDF content in the repsponse body, this method returns an instance of a PSR-7 `ResponseInterface`. You may leverage the `Response` object to stream the PDF back to the requesting client and access response headers
* `removeAssetReport(string $asset_report_token): object`
* `createAssetReportAuditCopy(string $asset_report_token, string $auditor_id): object`
* `removeAssetReportAuditCopy(string $audit_copy_token): object`


### Payment Initiation (UK only)

Resource: `payments`

Reference: https://plaid.com/docs/#payment-initiation

Methods:

* `createRecipient(string $name, string $iban, RecipientAddress $address): object`
* `getRecipient(string $recipient_id): object`
* `listRecipients(): object`
* `create(string $recipient_id, string $reference, float $amount, string $currency, PaymentSchedule $payment_schedule = null): object`
* `createToken(string $payment_id): object`
* `get(string $payment_id): object`
* `list(array $options = []): object`

Example:
```php
$plaid->payments->createRecipient($name, $iban, $address);
```

### Processors

Resource: `processors`

Reference: https://plaid.com/docs/api/processors

Methods:

* `createToken(string $access_token, string $account_id, string $processor): object`
* `getAuth(string $processor_token): object`
* `getBalance(string $processor_token): object`
* `getIdentity(string $processor_token): object`
* `createStripeToken(string $access_token, string $account_id): object` [[?]](https://plaid.com/docs/stripe)
* `createDwollaToken(string $access_token, string $account_id): object` [[?]](https://plaid.com/docs/dwolla)

### Sandbox

Resource: `sandbox`

Reference: https://plaid.com/docs/api/sandbox/

Methods:
* `createPublicToken(string $institution_id, array $initial_products, array $options = []): object`
* `resetLogin(string $access_token): object`
* `setVerificationStatus(string $access_token, string $account_id, string $verification_status): object`
* `fireWebhook(string $access_token, string $webhook_code = "DEFAULT_UPDATE"): object`
* `simulateBankTransfer(string $bank_transfer_id, string $event_type, ?string $ach_return_code = null, ?string $failure_description = null): object`

Example:
```php
$response = $plaid->sandbox->fireWebhook($access_token);
```

## Entities

### User

The `TomorrowIdeas\Plaid\Entities\User` entity is used to represent your end user when creating a new link token.

Example:

```php
$token_user = new User($user->id, $user->name, $user->phone);
```

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