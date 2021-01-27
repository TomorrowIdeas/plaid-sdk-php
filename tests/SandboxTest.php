<?php

namespace TomorrowIdeas\Plaid\Tests;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 * @covers TomorrowIdeas\Plaid\Resources\AbstractResource
 * @covers TomorrowIdeas\Plaid\Resources\Sandbox
 */
class SandboxTest extends TestCase
{
	public function test_create_public_token(): void
	{
		$response = $this->getPlaidClient()->sandbox->createPublicToken(
			"institution_id",
			["product1", "product2"]
		);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/sandbox/public_token/create", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("institution_id", $response->params->institution_id);
		$this->assertEquals(["product1", "product2"], $response->params->initial_products);
		$this->assertEquals((object) [], $response->params->options);
	}

	public function test_reset_login(): void
	{
		$response = $this->getPlaidClient()->sandbox->resetLogin("access_token");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/sandbox/item/reset_login", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("access_token", $response->params->access_token);
	}

	public function test_set_verification_status(): void
	{
		$response = $this->getPlaidClient()->sandbox->setVerificationStatus("access_token", "account_id", "verification_status");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/sandbox/item/reset_verification_status", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("access_token", $response->params->access_token);
		$this->assertEquals("account_id", $response->params->account_id);
		$this->assertEquals("verification_status", $response->params->verification_status);
	}

	public function test_fire_webhook(): void
	{
		$response = $this->getPlaidClient()->sandbox->fireWebhook("access_token");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/sandbox/item/fire_webhook", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("access_token", $response->params->access_token);
		$this->assertEquals("DEFAULT_UPDATE", $response->params->webhook_code);
	}

	public function test_simulate_bank_transfer(): void
	{
		$response = $this->getPlaidClient()->sandbox->simulateBankTransfer(
			"bank_transfer_id",
			"event_type",
			"ach_return_code",
			"failure_description"
		);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/sandbox/bank_transfer/simulate", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("bank_transfer_id", $response->params->bank_transfer_id);
		$this->assertEquals("event_type", $response->params->event_type);
		$this->assertEquals(
			(object) ["ach_return_code" => "ach_return_code", "description" => "failure_description"],
			$response->params->failure_reason
		);
	}
}