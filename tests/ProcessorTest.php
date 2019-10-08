<?php

namespace TomorrowIdeas\Plaid\Tests;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 */
class ProcessorTest extends TestCase
{
	public function test_create_stripe_token()
	{
		$response = $this->getPlaidClient()->createStripeToken("access_token", "account_id");

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("2019-05-29", $response->version);
        $this->assertEquals("application/json", $response->content);
        $this->assertEquals("/processor/stripe/bank_account_token/create", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("access_token", $response->params->access_token);
		$this->assertEquals("account_id", $response->params->account_id);
	}
}