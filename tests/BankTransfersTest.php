<?php

namespace TomorrowIdeas\Plaid\Tests;

use DateTime;
use TomorrowIdeas\Plaid\Entities\AccountHolder;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 * @covers TomorrowIdeas\Plaid\Resources\AbstractResource
 * @covers TomorrowIdeas\Plaid\Resources\BankTransfers
 * @covers TomorrowIdeas\Plaid\Entities\AccountHolder
 */
class BankTransfersTest extends TestCase
{
	public function test_create_bank_transfer(): void
	{
		$response = $this->getPlaidClient()->bank_transfers->create(
			"access_token",
			"idempotency_key",
			"type",
			"account_id",
			"network",
			"10.00",
			"USD",
			new AccountHolder("Test Name", "test@example.com"),
			"description",
			"ach_class",
			"custom_tag",
			["meta1" => "value1"],
			"origination_account_id"
		);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/bank_transfer/create", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("access_token", $response->params->access_token);
		$this->assertEquals("idempotency_key", $response->params->idempotency_key);
		$this->assertEquals("type", $response->params->type);
		$this->assertEquals("account_id", $response->params->account_id);
		$this->assertEquals("network", $response->params->network);
		$this->assertEquals("10.00", $response->params->amount);
		$this->assertEquals("USD", $response->params->iso_currency_code);
		$this->assertEquals(
			(object) [
				"legal_name" => "Test Name",
				"email" => "test@example.com"
			],
			$response->params->user
		);
		$this->assertEquals("descript", $response->params->description);
		$this->assertEquals("ach_class", $response->params->ach_class);
		$this->assertEquals("custom_tag", $response->params->custom_tag);
		$this->assertEquals((object) ["meta1" => "value1"], $response->params->metadata);
		$this->assertEquals("origination_account_id", $response->params->origination_account_id);
	}

	public function test_cancel_bank_transfer(): void
	{
		$response = $this->getPlaidClient()->bank_transfers->cancel("bank_transfer_id");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/bank_transfer/cancel", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("bank_transfer_id", $response->params->bank_transfer_id);
	}

	public function test_get_bank_transfer(): void
	{
		$response = $this->getPlaidClient()->bank_transfers->get("bank_transfer_id");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/bank_transfer/get", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("bank_transfer_id", $response->params->bank_transfer_id);
	}

	public function test_list_bank_transfers(): void
	{
		$response = $this->getPlaidClient()->bank_transfers->list(
			new DateTime("2019-01-01"),
			new DateTime("2019-01-31"),
			100,
			500,
			"asc",
			"origination_account_id"
		);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/bank_transfer/list", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("2019-01-01T00:00:00+00:00", $response->params->start_date);
		$this->assertEquals("2019-01-31T00:00:00+00:00", $response->params->end_date);
		$this->assertEquals(100, $response->params->count);
		$this->assertEquals(500, $response->params->offset);
		$this->assertEquals("asc", $response->params->direction);
		$this->assertEquals("origination_account_id", $response->params->origination_account_id);
	}

	public function test_get_event_list(): void
	{
		$response = $this->getPlaidClient()->bank_transfers->listEvents(
			new DateTime("2019-01-01"),
			new DateTime("2019-01-31"),
			"bank_transfer_id",
			"account_id",
			"bank_transfer_type",
			["type1"],
			100,
			500,
			"asc",
			"origination_account_id"
		);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/bank_transfer/event/list", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("2019-01-01T00:00:00+00:00", $response->params->start_date);
		$this->assertEquals("2019-01-31T00:00:00+00:00", $response->params->end_date);
		$this->assertEquals("bank_transfer_id", $response->params->bank_transfer_id);
		$this->assertEquals("account_id", $response->params->account_id);
		$this->assertEquals("bank_transfer_type", $response->params->bank_transfer_type);
		$this->assertEquals(100, $response->params->count);
		$this->assertEquals(500, $response->params->offset);
		$this->assertEquals("asc", $response->params->direction);
		$this->assertEquals("origination_account_id", $response->params->origination_account_id);
	}

	public function test_sync_events(): void
	{
		$response = $this->getPlaidClient()->bank_transfers->syncEvents("after_id", 100);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/bank_transfer/event/sync", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("after_id", $response->params->after_id);
		$this->assertEquals(100, $response->params->count);
	}

	public function test_migrate_account(): void
	{
		$response = $this->getPlaidClient()->bank_transfers->migrateAccount(
			"account_number",
			"routing_number",
			"account_type"
		);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/bank_transfer/migrate_account", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("account_number", $response->params->account_number);
		$this->assertEquals("routing_number", $response->params->routing_number);
		$this->assertEquals("account_type", $response->params->account_type);
	}

	public function test_get_account_balance(): void
	{
		$response = $this->getPlaidClient()->bank_transfers->getOriginationAccountBalance("origination_account_id");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/bank_transfer/balance/get", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("origination_account_id", $response->params->origination_account_id);
	}
}