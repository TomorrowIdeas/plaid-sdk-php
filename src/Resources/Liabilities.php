<?php

namespace TomorrowIdeas\Plaid\Resources;

use TomorrowIdeas\Plaid\PlaidRequestException;

class Liabilities extends AbstractResource
{
	/**
	 * Get Liabilities request.
	 *
	 * @param string $access_token
	 * @param array<string,mixed> $options
	 * @throws PlaidRequestException
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
			"liabilities/get",
			$this->paramsWithClientCredentials($params)
		);
	}
}