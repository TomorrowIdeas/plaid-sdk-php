<?php

namespace TomorrowIdeas\Plaid\Tests;

use DateTime;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 * @covers TomorrowIdeas\Plaid\Resources\AbstractResource
 * @covers TomorrowIdeas\Plaid\Resources\Transactions
 */
class TransactionsTest extends TestCase
{
	public function test_get_transactions(): void
	{
		$response = $this->getPlaidClient()->transactions->list(
			"access_token",
			new DateTime("2019-01-01 12:00:00"),
			new DateTime("2019-03-31 12:00:00")
		);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/transactions/get", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("access_token", $response->params->access_token);
		$this->assertEquals("2019-01-01", $response->params->start_date);
		$this->assertEquals("2019-03-31", $response->params->end_date);
		$this->assertEquals((object) [], $response->params->options);
	}

	public function test_refresh_transactions(): void
	{
		$response = $this->getPlaidClient()->transactions->refresh("access_token");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/transactions/refresh", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("access_token", $response->params->access_token);
	}

	public function test_sync_transactions_minimal(): void
	{
		$response = $this->getPlaidClient()->transactions->sync(
            "access_token"
        );

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/transactions/sync", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("access_token", $response->params->access_token);
		$this->assertEquals((object) [], $response->params->options);
	}

	public function test_sync_transactions_cursor_only(): void
	{
		$response = $this->getPlaidClient()->transactions->sync(
            "access_token",
            "last_cursor_123",
        );

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/transactions/sync", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("access_token", $response->params->access_token);
		$this->assertEquals("last_cursor_123", $response->params->cursor);
		$this->assertEquals((object) [], $response->params->options);
	}

	public function test_sync_transactions_all_params(): void
	{
		$response = $this->getPlaidClient()->transactions->sync(
            "access_token",
            "last_cursor_123",
            100,
            ["include_personal_finance_category" => true],
        );

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/transactions/sync", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("access_token", $response->params->access_token);
		$this->assertEquals("last_cursor_123", $response->params->cursor);
		$this->assertEquals(100, $response->params->count);
		$this->assertEquals((object) ["include_personal_finance_category" => true], $response->params->options);
	}
}
