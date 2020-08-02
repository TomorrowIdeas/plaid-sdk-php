<?php

use TomorrowIdeas\Plaid\Entities\AccountFilters;
use TomorrowIdeas\Plaid\Tests\TestCase;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 * @covers TomorrowIdeas\Plaid\Entities\AccountFilters
 */
class CreateLinkTokenTest extends TestCase
{
	public function test_required_parameters(): void
	{
		$response = $this->getPlaidClient()->createLinkToken(
			"client_name",
			"en",
			["US"],
			"usr_12345",
			["transactions", "auth"]
		);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2019-05-29", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/link/token/create", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("client_name", $response->params->client_name);
		$this->assertEquals("en", $response->params->language);
		$this->assertEquals(["US"], $response->params->country_codes);
		$this->assertEquals((object) ["client_user_id" => "usr_12345"], $response->params->user);
		$this->assertEquals(["transactions", "auth"], $response->params->products);
	}

	public function test_webhook(): void
	{
		$response = $this->getPlaidClient()->createLinkToken(
			"client_name",
			"en",
			["US"],
			"usr_12345",
			[],
			"http://webhook.url"
		);

		$this->assertEquals("http://webhook.url", $response->params->webhook);
	}

	public function test_link_customization_name(): void
	{
		$response = $this->getPlaidClient()->createLinkToken(
			"client_name",
			"en",
			["US"],
			"usr_12345",
			[],
			null,
			"link customization name"
		);

		$this->assertEquals("link customization name", $response->params->link_customization_name);
	}

	public function test_account_filters(): void
	{
		$account_filters = new AccountFilters;
		$account_filters->setDepositoryFilters(["auth", "transactions"]);

		$response = $this->getPlaidClient()->createLinkToken(
			"client_name",
			"en",
			["US"],
			"usr_12345",
			[],
			null,
			null,
			$account_filters
		);

		$this->assertEquals(
			(object) [
				"depository" => ["auth", "transactions"]
			],
			$response->params->account_filters
		);
	}

	public function test_access_token(): void
	{
		$response = $this->getPlaidClient()->createLinkToken(
			"client_name",
			"en",
			["US"],
			"usr_12345",
			[],
			null,
			null,
			null,
			"access_token"
		);

		$this->assertEquals("access_token", $response->params->access_token);
	}

	public function test_redirect_url(): void
	{
		$response = $this->getPlaidClient()->createLinkToken(
			"client_name",
			"en",
			["US"],
			"usr_12345",
			[],
			null,
			null,
			null,
			null,
			"http://redirect.url"
		);

		$this->assertEquals("http://redirect.url", $response->params->redirect_url);
	}

	public function test_android_package_name(): void
	{
		$response = $this->getPlaidClient()->createLinkToken(
			"client_name",
			"en",
			["US"],
			"usr_12345",
			[],
			null,
			null,
			null,
			null,
			null,
			"android_package_name"
		);

		$this->assertEquals("android_package_name", $response->params->android_package_name);
	}

	public function test_payment_id(): void
	{
		$response = $this->getPlaidClient()->createLinkToken(
			"client_name",
			"en",
			["US"],
			"usr_12345",
			[],
			null,
			null,
			null,
			null,
			null,
			null,
			"pmt_12345"
		);

		$this->assertEquals(
			(object) ["payment_id" => "pmt_12345"],
			$response->params->payment_initiation
		);
	}
}