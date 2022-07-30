<?php

namespace TomorrowIdeas\Plaid\Entities;

use JsonSerializable;

class Transfer implements JsonSerializable
{
	/**
	 * @see https://plaid.com/docs/api/tokens/#link-token-create-request-transfer
	 * @param string $intent_id
	 * @param string $payment_profile_id
	 */
	public function __construct(
		protected string $intent_id,
		protected string $payment_profile_id
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		return [
			"intent_id" => $this->intent_id,
			"payment_profile_id" => $this->payment_profile_id
		];
	}
}