<?php

namespace TomorrowIdeas\Plaid\Entities;

use JsonSerializable;

class EUConfig implements JsonSerializable
{
	/**
	 * @see https://plaid.com/docs/api/tokens/#link-token-create-request-eu-config
	 * @param boolean $headless
	 */
	public function __construct(
		protected bool $headless
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		return [
			"headless" => $this->headless
		];
	}
}