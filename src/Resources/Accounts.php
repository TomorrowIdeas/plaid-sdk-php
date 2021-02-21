<?php

namespace TomorrowIdeas\Plaid\Resources;

class Accounts extends AbstractResource
{
	/**
	 * Get all Accounts.
	 *
	 * @param string $access_token
	 * @param array<string,mixed> $options
	 * @return object
	 */
	public function list(string $access_token, array $options = []): object
	{
		$params = [
			"access_token" => $access_token,
			"options" => (object) $options
		];

		return $this->sendRequest(
			"post",
			"accounts/get",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get Account balance.
	 *
	 * @param string $access_token
	 * @param array<string,string> $options
	 * @return object
	 */
	public function getBalance(string $access_token, array $options = []): object
	{
		$params = [
			"access_token" => $access_token,
			"options" => (object) $options
		];

		return $this->sendRequest(
			"post",
			"accounts/balance/get",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get Account identity information.
	 *
	 * @param string $access_token
	 * @param array<string,mixed> $options
	 * @return object
	 */
	public function getIdentity(string $access_token, array $options = []): object
	{
		$params = [
			"access_token" => $access_token,
			"options" => (object) $options
		];

		return $this->sendRequest(
			"post",
			"identity/get",
			$this->paramsWithClientCredentials($params)
		);
	}
}