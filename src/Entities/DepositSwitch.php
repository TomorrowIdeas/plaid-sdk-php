<?php

namespace TomorrowIdeas\Plaid\Entities;

use JsonSerializable;

class DepositSwitch implements JsonSerializable
{
	/**
	 * @see https://plaid.com/docs/api/tokens/#link-token-create-request-deposit-switch
	 * @param string $deposit_switch_id
	 */
	public function __construct(
		protected string $deposit_switch_id
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		return [
			"deposit_switch_id" => $this->deposit_switch_id
		];
	}
}