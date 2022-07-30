<?php

namespace TomorrowIdeas\Plaid\Entities;

use JsonSerializable;

class InstitutionData implements JsonSerializable
{
	/**
	 * @see https://plaid.com/docs/api/tokens/#link-token-create-request-institution-data
	 *
	 * @param string $routing_number
	 */
	public function __construct(
		protected string $routing_number
	)
	{
	}

	/**
	 * Convert the object into a key=>value pair that can be used in HTTP requests.
	 *
	 * @return array
	 */
	public function jsonSerialize(): mixed
	{
		return [
			"routing_numer" => $this->routing_number
		];
	}
}