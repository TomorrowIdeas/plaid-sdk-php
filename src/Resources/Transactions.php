<?php

namespace TomorrowIdeas\Plaid\Resources;

use DateTime;

class Transactions extends AbstractResource
{
	/**
	 * Get all transactions for a particular Account.
	 *
	 * @deprecated 1.1
	 * @param string $access_token
	 * @param DateTime $start_date
	 * @param DateTime $end_date
	 * @param array<string,string> $options
	 * @return object
	 */
	public function getTransactions(string $access_token, DateTime $start_date, DateTime $end_date, array $options = []): object
	{
		return $this->list($access_token, $start_date, $end_date, $options);
	}

	/**
	 * Get all transactions for a particular Account.
	 *
	 * @param string $access_token
	 * @param DateTime $start_date
	 * @param DateTime $end_date
	 * @param array<string,string> $options
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
	 * @deprecated 1.1
	 * @param string $access_token
	 * @return object
	 */
	public function refreshTransactions(string $access_token): object
	{
		return $this->refresh($access_token);
	}

	/**
	 * Refresh transactions for a particular Account.
	 *
	 * @param string $access_token
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
}