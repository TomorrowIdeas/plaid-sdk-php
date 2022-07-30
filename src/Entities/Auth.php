<?php

namespace TomorrowIdeas\Plaid\Entities;

use JsonSerializable;

class Auth implements JsonSerializable
{
	/**
	 * @see https://plaid.com/docs/api/tokens/#link-token-create-request-auth
	 * @param boolean|null $auth_type_select_enabled
	 * @param boolean|null $automated_microdeposits_enabled
	 * @param boolean|null $instant_match_enabled
	 * @param boolean|null $same_day_microdeposits_enabled
	 */
	public function __construct(
		protected ?bool $auth_type_select_enabled = null,
		protected ?bool $automated_microdeposits_enabled = null,
		protected ?bool $instant_match_enabled = null,
		protected ?bool $same_day_microdeposits_enabled = null,
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		$payload = [
			"auth_type_select_enabled" => $this->auth_type_select_enabled,
			"automated_microdeposits_enabled" => $this->automated_microdeposits_enabled,
			"instant_match_enabled" => $this->instant_match_enabled,
			"same_day_microdeposits_enabled" => $this->same_day_microdeposits_enabled
		];

		return \array_filter($payload, fn($item) => $item !== null);
	}
}