<?php

namespace TomorrowIdeas\Plaid\Tests;

/**
 * @covers \TomorrowIdeas\Plaid\Plaid
 * @covers \TomorrowIdeas\Plaid\Resources\AbstractResource
 * @covers \TomorrowIdeas\Plaid\Resources\Webhooks
 */
class WebhooksTest extends TestCase
{
	public function test_get_webhook_key(): void
	{
		$response = $this->getPlaidClient()->webhooks->getWebhookVerificationKey("key_id");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/webhook_verification_key/get", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
	}
}
