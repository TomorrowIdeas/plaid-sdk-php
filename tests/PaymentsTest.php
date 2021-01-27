<?php

namespace TomorrowIdeas\Plaid\Tests;

use DateTime;
use TomorrowIdeas\Plaid\Entities\BacsAccount;
use TomorrowIdeas\Plaid\Entities\PaymentSchedule;
use TomorrowIdeas\Plaid\Entities\RecipientAddress;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 * @covers TomorrowIdeas\Plaid\Resources\AbstractResource
 * @covers TomorrowIdeas\Plaid\Resources\Payments
 * @covers TomorrowIdeas\Plaid\Entities\RecipientAddress
 * @covers TomorrowIdeas\Plaid\Entities\PaymentSchedule
 * @covers TomorrowIdeas\Plaid\Entities\BacsAccount
 */
class PaymentsTest extends TestCase
{
	public function test_create_recipient(): void
	{
		$response = $this->getPlaidClient()->payments->createRecipient(
			"name",
			"iban",
			new RecipientAddress("139 The Esplanade", null, "Weymouth", "DT4 7NR", "GB")
		);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/payment_initiation/recipient/create", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("name", $response->params->name);
		$this->assertEquals("iban", $response->params->iban);
		$this->assertEquals(
			(object) [
				"street" => ["139 The Esplanade"],
				"city" => "Weymouth",
				"postal_code" => "DT4 7NR",
				"country" => "GB"
			],
			$response->params->address
		);
	}

	public function test_create_recipient_with_bacs_account_entity(): void
	{
		$response = $this->getPlaidClient()->payments->createRecipient(
			"name",
			new BacsAccount("account", "sort_code"),
			new RecipientAddress("139 The Esplanade", null, "Weymouth", "DT4 7NR", "GB")
		);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/payment_initiation/recipient/create", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("name", $response->params->name);
		$this->assertEquals(
			(object) [
				"account" => "account",
				"sort_code" => "sort_code"
			],
			$response->params->bacs
		);
		$this->assertEquals(
			(object) [
				"street" => ["139 The Esplanade"],
				"city" => "Weymouth",
				"postal_code" => "DT4 7NR",
				"country" => "GB"
			],
			$response->params->address
		);
	}

	public function test_get_recipient(): void
	{
		$response = $this->getPlaidClient()->payments->getRecipient("rcp_1234");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/payment_initiation/recipient/get", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("rcp_1234", $response->params->recipient_id);
	}

	public function test_list_recipients(): void
	{
		$response = $this->getPlaidClient()->payments->listRecipients();

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/payment_initiation/recipient/list", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
	}

	public function test_create_payment(): void
	{
		$response = $this->getPlaidClient()->payments->create("rcp_1234", "ref_5678", 250.25, "GBP");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/payment_initiation/payment/create", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("rcp_1234", $response->params->recipient_id);
		$this->assertEquals("ref_5678", $response->params->reference);
		$this->assertEquals((object) [
			"value" => 250.25,
			"currency" => "GBP"
		], $response->params->amount);
	}

	public function test_create_payment_with_schedule(): void
	{
		$response = $this->getPlaidClient()->payments->create(
			"rcp_1234",
			"ref_5678",
			250.25,
			"GBP",
			new PaymentSchedule(
				PaymentSchedule::INTERVAL_MONTHLY,
				15,
				new DateTime("2020-10-15")
			)
		);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/payment_initiation/payment/create", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("rcp_1234", $response->params->recipient_id);
		$this->assertEquals("ref_5678", $response->params->reference);
		$this->assertEquals((object) [
			"value" => 250.25,
			"currency" => "GBP"
		], $response->params->amount);
		$this->assertEquals(
			(object) [
				"interval" => PaymentSchedule::INTERVAL_MONTHLY,
				"interval_execution_day" => 15,
				"start_date" => "2020-10-15"
			],
			$response->params->schedule
		);
	}

	public function test_create_payment_token(): void
	{
		$response = $this->getPlaidClient()->payments->createToken("pmt_1234");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/payment_initiation/payment/token/create", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("pmt_1234", $response->params->payment_id);
	}

	public function test_get_payment(): void
	{
		$response = $this->getPlaidClient()->payments->get("pmt_1234");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/payment_initiation/payment/get", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("pmt_1234", $response->params->payment_id);
	}

	public function test_list_payments(): void
	{
		$response = $this->getPlaidClient()->payments->list();

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/payment_initiation/payment/list", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
	}
}