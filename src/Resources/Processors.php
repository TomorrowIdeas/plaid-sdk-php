<?php

namespace TomorrowIdeas\Plaid\Resources;

class Processors extends AbstractResource
{
	/**
	 * Create a processor token.
	 *
	 * @param string $access_token
	 * @param string $account_id
	 * @param string $processor
	 * @return object
	 */
	public function createToken(string $access_token, string $account_id, string $processor): object
	{
		$params = [
			"access_token" => $access_token,
			"account_id" => $account_id,
			"processor" => $processor
		];

		return $this->sendRequest(
			"post",
			"processor/token/create",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get processor auth data.
	 *
	 * @param string $processor_token
	 * @return object
	 */
	public function getAuth(string $processor_token): object
	{
		$params = [
			"processor_token" => $processor_token
		];

		return $this->sendRequest(
			"post",
			"processor/auth/get",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get the balance of accounts from processor.
	 *
	 * @param string $processor_token
	 * @return object
	 */
	public function getBalance(string $processor_token): object
	{
		$params = [
			"processor_token" => $processor_token
		];

		return $this->sendRequest(
			"post",
			"processor/balance/get",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get account holder information from the processor.
	 *
	 * @param string $processor_token
	 * @return object
	 */
	public function getIdentity(string $processor_token): object
	{
		$params = [
			"processor_token" => $processor_token
		];

		return $this->sendRequest(
			"post",
			"processor/identity/get",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Create Stripe token.
	 *
	 * @param string $access_token
	 * @param string $account_id
	 * @return object
	 */
	public function createStripeToken(string $access_token, string $account_id): object
	{
		$params = [
			"access_token" => $access_token,
			"account_id" => $account_id
		];

		return $this->sendRequest(
			"post",
			"processor/stripe/bank_account_token/create",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Create Dwolla token.
	 *
	 * @param string $access_token
	 * @param string $account_id
	 * @return object
	 */
	public function createDwollaToken(string $access_token, string $account_id): object
	{
		$params = [
			"access_token" => $access_token,
			"account_id" => $account_id
		];

		return $this->sendRequest(
			"post",
			"processor/dwolla/processor_token/create",
			$this->paramsWithClientCredentials($params)
		);
	}
}