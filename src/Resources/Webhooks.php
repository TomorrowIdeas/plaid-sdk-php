<?php

namespace TomorrowIdeas\Plaid\Resources;

class Webhooks extends AbstractResource
{
	/**
	 * Get public key corresponding to key id inside webhook request.
	 *
	 * @deprecated 1.1
	 * @param string $key_id
	 * @return object
	 */
	public function getWebhookVerificationKey(string $key_id): object
	{
		return $this->getVerificationKey($key_id);
	}

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
}