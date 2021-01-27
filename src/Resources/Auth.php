<?php

namespace TomorrowIdeas\Plaid\Resources;

class Auth extends AbstractResource
{
	/**
	 * Get Auth request.
	 *
	 * @param string $access_token
	 * @param array<string,string> $options
	 * @return object
	 */
	public function get(string $access_token, array $options = []): object
	{
		$params = [
			"access_token" => $access_token,
			"options" => (object) $options
		];

		return $this->sendRequest(
			"post",
			"auth/get",
			$this->paramsWithClientCredentials($params)
		);
	}
}