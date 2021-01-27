<?php

namespace TomorrowIdeas\Plaid\Resources;

use DateTime;

class Investments extends AbstractResource
{
	/**
	 * Get investment holdings.
	 *
	 * @param string $access_token
	 * @param array<string,string> $options
	 * @return object
	 */
	public function listHoldings(string $access_token, array $options = []): object
	{
		$params = [
			"access_token" => $access_token,
			"options" => (object) $options
		];

		return $this->sendRequest(
			"post",
			"investments/holdings/get",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get investment transactions.
	 *
	 * @param string $access_token
	 * @param DateTime $start_date
	 * @param DateTime $end_date
	 * @param array<string,string> $options
	 * @return object
	 */
	public function listTransactions(string $access_token, DateTime $start_date, DateTime $end_date, array $options = []): object
	{
		$params = [
			"access_token" => $access_token,
			"start_date" => $start_date->format("Y-m-d"),
			"end_date" => $end_date->format("Y-m-d"),
			"options" => (object) $options
		];

		return $this->sendRequest(
			"post",
			"investments/transactions/get",
			$this->paramsWithClientCredentials($params)
		);
	}
}