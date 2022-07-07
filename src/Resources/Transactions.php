<?php

namespace TomorrowIdeas\Plaid\Resources;

use DateTime;
use TomorrowIdeas\Plaid\PlaidRequestException;

class Transactions extends AbstractResource
{
	/**
	 * Get all transactions for a particular Account.
	 *
	 * @param string $access_token
	 * @param DateTime $start_date
	 * @param DateTime $end_date
	 * @param array<string,mixed> $options
	 * @throws PlaidRequestException
	 * @return object
	 */
	public function list(string $access_token, DateTime $start_date, DateTime $end_date, array $options = []): object
	{
		$params = [
			"access_token" => $access_token,
			"start_date" => $start_date->format("Y-m-d"),
			"end_date" => $end_date->format("Y-m-d"),
			"options" => (object) $options
		];

		return $this->sendRequest(
			"post",
			"transactions/get",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Refresh transactions for a particular Account.
	 *
	 * @param string $access_token
	 * @throws PlaidRequestException
	 * @return object
	 */
	public function refresh(string $access_token): object
	{
		$params = [
			"access_token" => $access_token
		];

		return $this->sendRequest(
			"post",
			"transactions/refresh",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get transactions for a Plaid Item since the last sync.
	 *
	 * @see https://plaid.com/docs/api/products/transactions/#transactionssync
	 *
	 * @param string $access_token
	 * @param string|null $cursor The "cursor" (or page identifier) provided from the
	 *               last sync request. Do not provide cursor for the first-ever
	 *               sync request for an item.
	 * @param int|null $count Number of transactions per response (or page size)
	 * @param array<string,mixed> $options
	 * @throws PlaidRequestException
	 * @return object
	 */
	public function sync(string $access_token, ?string $cursor = null, ?int $count = null, array $options = []): object
	{
		$params = [
			"access_token" => $access_token,
			"options" => (object) $options,
		];

		if( $cursor ) {
			$params["cursor"] = $cursor;
		}

		if( $count ) {
			$params["count"] = $count;
		}

		return $this->sendRequest(
			"post",
			"transactions/sync",
			$this->paramsWithClientCredentials($params)
		);
	}
}
