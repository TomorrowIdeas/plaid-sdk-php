<?php

namespace TomorrowIdeas\Plaid\Resources;

use TomorrowIdeas\Plaid\PlaidRequestException;

class Items extends AbstractResource
{
	/**
	 * Get an Item.
	 *
	 * @param string $access_token
	 * @throws PlaidRequestException
	 * @return object
	 */
	public function get(string $access_token): object
	{
		$params = [
			"access_token" => $access_token
		];

		return $this->sendRequest(
			"post",
			"item/get",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Remove an Item.
	 *
	 * @param string $access_token
	 * @throws PlaidRequestException
	 * @return object
	 */
	public function remove(string $access_token): object
	{
		$params = [
			"access_token" => $access_token
		];

		return $this->sendRequest(
			"post",
			"item/remove",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Create a new Item public token.
	 *
	 * @param string $access_token
	 * @throws PlaidRequestException
	 * @return object
	 */
	public function createPublicToken(string $access_token): object
	{
		$params = [
			"access_token" => $access_token
		];

		return $this->sendRequest(
			"post",
			"item/public_token/create",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Exchange an Item public token for an access token.
	 *
	 * @param string $public_token
	 * @throws PlaidRequestException
	 * @return object
	 */
	public function exchangeToken(string $public_token): object
	{
		$params = [
			"public_token" => $public_token
		];

		return $this->sendRequest(
			"post",
			"item/public_token/exchange",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Rotate an Item's access token.
	 *
	 * @param string $access_token
	 * @throws PlaidRequestException
	 * @return object
	 */
	public function rotateAccessToken(string $access_token): object
	{
		$params = [
			"access_token" => $access_token
		];

		return $this->sendRequest(
			"post",
			"item/access_token/invalidate",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get an Item's income information.
	 *
	 * @param string $access_token
	 * @throws PlaidRequestException
	 * @return object
	 */
	public function getIncome(string $access_token): object
	{
		$params = [
			"access_token" => $access_token
		];

		return $this->sendRequest(
			"post",
			"income/get",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get an Item's income information.
	 *
	 * @param array $params for user and employer
	 * @return object with precheck_id and confidence
	 */
	public function getIncomePrecheck(array $params = []): object
	{
		/*$params = [
			"access_token" => $access_token
		];*/

		return $this->doRequest(
			$this->buildRequest("post", "income/verification/precheck", $this->clientCredentials($params))
		);
	}

	/**
	 * Get an Item's income information.
	 *
	 * @param string $access_token
	 * @return object
	 */
	public function getIncomePaystubs(string $access_token): object
	{
		$params = [
			"access_token" => $access_token
		];

		return $this->doRequest(
			$this->buildRequest("post", "income/verification/paystubs/get", $this->clientCredentials($params))
		);
	}
}
