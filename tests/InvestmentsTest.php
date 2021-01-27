<?php

namespace TomorrowIdeas\Plaid\Tests;

use DateTime;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 * @covers TomorrowIdeas\Plaid\Resources\AbstractResource
 * @covers TomorrowIdeas\Plaid\Resources\Investments
 */
class InvestmentsTest extends TestCase
{
	public function test_get_holdings(): void
	{
		$response = $this->getPlaidClient()->investments->listHoldings("access_token", []);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/investments/holdings/get", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("access_token", $response->params->access_token);
		$this->assertEquals((object) [], $response->params->options);
	}

	public function test_get_transactions(): void
	{
		$response = $this->getPlaidClient()->investments->listTransactions("access_token", new DateTime("2019-01-01 12:00:00"), new DateTime("2019-03-31 12:00:00"), []);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/investments/transactions/get", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("access_token", $response->params->access_token);
		$this->assertEquals("2019-01-01", $response->params->start_date);
		$this->assertEquals("2019-03-31", $response->params->end_date);
		$this->assertEquals((object) [], $response->params->options);
	}
}