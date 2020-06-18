<?php

namespace TomorrowIdeas\Plaid\Tests;

/**
 * @covers \TomorrowIdeas\Plaid\Plaid
 */
class WebhookTest extends TestCase
{
	public function test_get_webhook_key()
	{
		$response = $this->getPlaidClient()->getWebhookVerificationKey("key_id");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2019-05-29", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/webhook_verification_key/get", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
	}
}
