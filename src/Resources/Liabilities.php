<?php

namespace TomorrowIdeas\Plaid\Resources;

class Liabilities extends AbstractResource
{
	/**
	 * Get Liabilities request.
	 *
	 * @param string $access_token
	 * @param array<string,string> $options
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