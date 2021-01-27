<?php

namespace TomorrowIdeas\Plaid\Tests;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 * @covers TomorrowIdeas\Plaid\Resources\AbstractResource
 * @covers TomorrowIdeas\Plaid\Resources\Processors
 */
class ProcessorsTest extends TestCase
{
	public function test_create_token(): void
	{
		$response = $this->getPlaidClient()->processors->createToken("access_token", "account_id", "processor");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/processor/token/create", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("access_token", $response->params->access_token);
		$this->assertEquals("account_id", $response->params->account_id);
		$this->assertEquals("processor", $response->params->processor);
	}

	public function test_get_auth(): void
	{
		$response = $this->getPlaidClient()->processors->getAuth("processor_token");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/processor/auth/get", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("processor_token", $response->params->processor_token);
	}

	public function test_get_balance(): void
	{
		$response = $this->getPlaidClient()->processors->getBalance("processor_token");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/processor/balance/get", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("processor_token", $response->params->processor_token);
	}

	public function test_get_identity(): void
	{
		$response = $this->getPlaidClient()->processors->getIdentity("processor_token");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/processor/identity/get", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("processor_token", $response->params->processor_token);
	}

	public function test_create_stripe_token(): void
	{
		$response = $this->getPlaidClient()->processors->createStripeToken("access_token", "account_id");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/processor/stripe/bank_account_token/create", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("access_token", $response->params->access_token);
		$this->assertEquals("account_id", $response->params->account_id);
	}

	public function test_create_dwolla_token(): void
	{
		$response = $this->getPlaidClient()->processors->createDwollaToken("access_token", "account_id");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/processor/dwolla/processor_token/create", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("access_token", $response->params->access_token);
		$this->assertEquals("account_id", $response->params->account_id);
	}
}