<?php

namespace TomorrowIdeas\Plaid\Resources;

use DateTime;
use TomorrowIdeas\Plaid\Entities\AccountHolder;

class BankTransfers extends AbstractResource
{
	/**
	 * Create a new bank transfer.
	 *
	 * @param string $access_token
	 * @param string $idempotency_key
	 * @param string $type
	 * @param string $account_id
	 * @param string $network
	 * @param string $amount
	 * @param string $currency_code
	 * @param AccountHolder $account_holder
	 * @param string $description
	 * @param string $ach_class
	 * @param string $custom_tag
	 * @param array $metadata
	 * @param string $origination_account_id
	 * @return object
	 */
	public function create(
		string $access_token,
		string $idempotency_key,
		string $type,
		string $account_id,
		string $network,
		string $amount,
		string $currency_code,
		AccountHolder $account_holder,
		string $description,
		string $ach_class = null,
		string $custom_tag = null,
		array $metadata = [],
		string $origination_account_id = null): object
	{
		$params = [
			"access_token" => $access_token,
			"idempotency_key" => $idempotency_key,
			"type" => $type,
			"account_id" => $account_id,
			"network" => $network,
			"amount" => $amount,
			"iso_currency_code" => $currency_code,
			"description" => \substr($description, 0, 8),
			"user" => $account_holder->toArray(),
			"metadata" => $metadata ? (object) $metadata : null
		];

		if( $ach_class ){
			$params["ach_class"] = $ach_class;
		}

		if( $custom_tag ){
			$params["custom_tag"] = $custom_tag;
		}

		if( $origination_account_id ){
			$params["origination_account_id"] = $origination_account_id;
		}

		return $this->sendRequest(
			"post",
			"bank_transfer/create",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Cancel a bank transfer.
	 *
	 * @param string $bank_transfer_id
	 * @return object
	 */
	public function cancel(string $bank_transfer_id): object
	{
		$params = [
			"bank_transfer_id" => $bank_transfer_id
		];

		return $this->sendRequest(
			"post",
			"bank_transfer/cancel",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get details about a bank transfer.
	 *
	 * @param string $bank_transfer_id
	 * @return object
	 */
	public function get(string $bank_transfer_id): object
	{
		$params = [
			"bank_transfer_id" => $bank_transfer_id
		];

		return $this->sendRequest(
			"post",
			"bank_transfer/get",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get list of bank transfers.
	 *
	 * @param DateTime|null $start_date
	 * @param DateTime|null $end_date
	 * @param integer|null $count
	 * @param integer|null $offset
	 * @param string|null $direction
	 * @param string|null $origination_account_id
	 * @return object
	 */
	public function list(
		?DateTime $start_date = null,
		?DateTime $end_date = null,
		?int $count = null,
		?int $offset = null,
		?string $direction = null,
		?string $origination_account_id = null): object
	{
		$params = [];

		if( $start_date ){
			$params["start_date"] = $start_date->format("c");
		}

		if( $end_date ){
			$params["end_date"] = $end_date->format("c");
		}

		if( $count ){
			$params["count"] = $count;
		}

		if( $offset ){
			$params["offset"] = $offset;
		}

		if( $direction ){
			$params["direction"] = $direction;
		}

		if( $origination_account_id ){
			$params["origination_account_id"] = $origination_account_id;
		}

		return $this->sendRequest(
			"post",
			"bank_transfer/list",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get list of bank transfer events.
	 *
	 * @param DateTime|null $start_date
	 * @param DateTime|null $end_date
	 * @param string|null $bank_transfer_id
	 * @param string|null $account_id
	 * @param string|null $bank_transfer_type
	 * @param array<string> $event_type
	 * @param integer|null $count
	 * @param integer|null $offset
	 * @param string|null $direction
	 * @param string|null $origination_account_id
	 * @return object
	 */
	public function listEvents(
		?DateTime $start_date = null,
		?DateTime $end_date = null,
		?string $bank_transfer_id = null,
		?string $account_id = null,
		?string $bank_transfer_type = null,
		array $event_type = [],
		?int $count = null,
		?int $offset = null,
		?string $direction = null,
		?string $origination_account_id = null): object
	{
		$params = [];

		if( $start_date ){
			$params["start_date"] = $start_date->format("c");
		}

		if( $end_date ){
			$params["end_date"] = $end_date->format("c");
		}

		if( $bank_transfer_id ){
			$params["bank_transfer_id"] = $bank_transfer_id;
		}

		if( $account_id ){
			$params["account_id"] = $account_id;
		}

		if( $bank_transfer_type ){
			$params["bank_transfer_type"] = $bank_transfer_type;
		}

		if( $event_type ){
			$params["event_type"] = $event_type;
		}

		if( $count ){
			$params["count"] = $count;
		}

		if( $offset ){
			$params["offset"] = $offset;
		}

		if( $direction ){
			$params["direction"] = $direction;
		}

		if( $origination_account_id ){
			$params["origination_account_id"] = $origination_account_id;
		}

		return $this->sendRequest(
			"post",
			"bank_transfer/event/list",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Sync bank transfer events.
	 *
	 * @param string $after_id
	 * @param integer|null $count
	 * @return object
	 */
	public function syncEvents(string $after_id, ?int $count = null): object
	{
		$params = [
			"after_id" => $after_id
		];

		if( $count ){
			$params["count"] = $count;
		}

		return $this->sendRequest(
			"post",
			"bank_transfer/event/sync",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Migrate an account.
	 *
	 * @param string $account_number
	 * @param string $routing_number
	 * @param string $account_type
	 * @return object
	 */
	public function migrateAccount(
		string $account_number,
		string $routing_number,
		string $account_type): object
	{
		$params = [
			"account_number" => $account_number,
			"routing_number" => $routing_number,
			"account_type" => $account_type
		];

		return $this->sendRequest(
			"post",
			"bank_transfer/migrate_account",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get the origination account balance.
	 *
	 * @param string|null $origination_account_id
	 * @return object
	 */
	public function getOriginationAccountBalance(string $origination_account_id = null): object
	{
		$params = [];

		if( $origination_account_id ){
			$params["origination_account_id"] = $origination_account_id;
		}

		return $this->sendRequest(
			"post",
			"bank_transfer/balance/get",
			$this->paramsWithClientCredentials($params)
		);
	}
}