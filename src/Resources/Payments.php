<?php

namespace TomorrowIdeas\Plaid\Resources;

use TomorrowIdeas\Plaid\Entities\BacsAccount;
use TomorrowIdeas\Plaid\Entities\PaymentSchedule;
use TomorrowIdeas\Plaid\Entities\RecipientAddress;

class Payments extends AbstractResource
{
	/**
	 * Create a recipient request for payment initiation.
	 *
	 * @param string $name
	 * @param BacsAccount|string $account
	 * @param RecipientAddress $address
	 * @return object
	 */
	public function createRecipient(string $name, $account, RecipientAddress $address): object
	{
		$params = [
			"name" => $name,
			"address" => (object) $address->toArray()
		];

		if( \is_string($account) ){
			$params["iban"] = $account;
		}
		else {
			$params["bacs"] = $account->toArray();
		}

		return $this->sendRequest(
			"post",
			"payment_initiation/recipient/create",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get a recipient request from a payment inititiation.
	 *
	 * @param string $recipient_id
	 * @return object
	 */
	public function getRecipient(string $recipient_id): object
	{
		$params = [
			"recipient_id" => $recipient_id
		];

		return $this->sendRequest(
			"post",
			"payment_initiation/recipient/get",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * List out all recipients for payment initiations.
	 *
	 * @return object
	 */
	public function listRecipients(): object
	{
		return $this->sendRequest(
			"post",
			"payment_initiation/recipient/list",
			$this->paramsWithClientCredentials()
		);
	}

	/**
	 * Create a payment request.
	 *
	 * @param string $recipient_id
	 * @param string $reference
	 * @param float $amount
	 * @param string $currency
	 * @param PaymentSchedule|null $payment_schedule
	 * @return object
	 */
	public function create(string $recipient_id, string $reference, float $amount, string $currency, PaymentSchedule $payment_schedule = null): object
	{
		$params = [
			"recipient_id" => $recipient_id,
			"reference" => $reference,
			"amount" => [
				"value" => $amount,
				"currency" => $currency
			]
		];

		if( $payment_schedule ){
			$params["schedule"] = [
				"interval" => $payment_schedule->getInterval(),
				"interval_execution_day" => $payment_schedule->getIntervalExecutionDay(),
				"start_date" => $payment_schedule->getStartDate()->format("Y-m-d")
			];
		}

		return $this->sendRequest(
			"post",
			"payment_initiation/payment/create",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Create a payment token.
	 *
	 * @param string $payment_id
	 * @return object
	 */
	public function createToken(string $payment_id): object
	{
		$params = [
			"payment_id" => $payment_id
		];

		return $this->sendRequest(
			"post",
			"payment_initiation/payment/token/create",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get payment details.
	 *
	 * @param string $payment_id
	 * @return object
	 */
	public function get(string $payment_id): object
	{
		$params = [
			"payment_id" => $payment_id
		];

		return $this->sendRequest(
			"post",
			"payment_initiation/payment/get",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * List all payments.
	 *
	 * @param array $options
	 * @return object
	 */
	public function list(array $options = []): object
	{
		$params = [
			"options" => (object) $options
		];

		return $this->sendRequest(
			"post",
			"payment_initiation/payment/list",
			$this->paramsWithClientCredentials($params)
		);
	}
}