<?php

namespace TomorrowIdeas\Plaid\Resources;

class Webhooks extends AbstractResource
{
	/**
	 * Get public key corresponding to key id inside webhook request.
	 *
	 * @param string $key_id
	 * @return object
	 */
	public function getVerificationKey(string $key_id): object
	{
		$params = [
			"key_id" => $key_id,
		];

		return $this->sendRequest(
			"post",
			"webhook_verification_key/get",
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
	public function update(string $access_token, string $webhook): object
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