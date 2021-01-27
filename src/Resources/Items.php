<?php

namespace TomorrowIdeas\Plaid\Resources;


class Items extends AbstractResource
{
	/**
	 * Get an Item.
	 *
	 * @deprecated 1.1 Use get() method.
	 * @param string $access_token
	 * @return object
	 */
	public function getItem(string $access_token): object
	{
		return $this->get($access_token);
	}

	/**
	 * Get an Item.
	 *
	 * @param string $access_token
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
	 * @deprecated 1.1 Use remove() method.
	 * @param string $access_token
	 * @return object
	 */
	public function removeItem(string $access_token): object
	{
		return $this->remove($access_token);
	}

	/**
	 * Remove an Item.
	 *
	 * @param string $access_token
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
	 * Update an Item webhook.
	 *
	 * @param string $access_token
	 * @param string $webhook
	 * @return object
	 */
	public function updateWebhook(string $access_token, string $webhook): object
	{
		$params = [
			"access_token" => $access_token,
			"webhook" => $webhook
		];

		return $this->sendRequest(
			"post",
			"item/webhook/update",
			$this->paramsWithClientCredentials($params)
		);
	}
}