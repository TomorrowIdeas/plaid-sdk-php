# Plaid SDK
Plaid PHP SDK supporting Auth, Items, Accounts, Institutions, Webhooks, Identity, Income, and Balance.

## Official Plaid API docs
For full description of request and response payloads and properties, please see the [Plaid API docs](https://plaid.com/docs/).

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
The Plaid client by default uses the **production** Plaid API hostname for all API calls. You can update the environment by using the ```setEnvironment``` method.

Possible environments:

* production
* development
* sandbox

```php
$client = new Plaid("your-client-id", "your-secret", "your-public-key");

$client->setEnvironment("sandbox");
```

### API Versions
The Plaid client by default uses API version **2018-05-22**.

Possible API versions:
* 2019-05-29
* 2018-05-22
* 2017-03-08

```php
$client = new Plaid("your-client-id", "your-secret", "your-public-key");


$client->setPlaidVersion("2019-05-29");
```

## Methods

For a full description of the response payload, please see the [official Plaid API docs](https://plaid.com/docs/).

### Auth
* ```getAuth(string $access_token, array $options = []): object```

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

## Errors
All unsuccessfull (non 2xx) responses will throw a ```PlaidRequestException```. The full response object is available via ```getResponse()``` method.
