<?php

namespace TomorrowIdeas\Plaid\Entities;

use JsonSerializable;

class Update implements JsonSerializable
{
	/**
	 * @see https://plaid.com/docs/api/tokens/#link-token-create-request-update
	 * @param boolean $account_selection_enabled
	 */
	public function __construct(
		protected bool $account_selection_enabled = false
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		return [
			"account_selection_enabled" => $this->account_selection_enabled
		];
	}
}