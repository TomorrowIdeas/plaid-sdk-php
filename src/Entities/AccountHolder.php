<?php

namespace TomorrowIdeas\Plaid\Entities;

use JsonSerializable;

class AccountHolder implements JsonSerializable
{
	/**
	 * @param string $legal_name Legal name of account holder or business name.
	 * @param string|null $email Email address of account holder.
	 */
	public function __construct(
		protected string $legal_name,
		protected ?string $email = null
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		return [
			"legal_name" => $this->legal_name,
			"email_address" => $this->email
		];
	}
}