<?php

namespace TomorrowIdeas\Plaid\Entities;

use JsonSerializable;

class BacsAccount implements JsonSerializable
{
	public function __construct(
		protected string $account,
		protected string $sort_code
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		return [
			"account" => $this->account,
			"sort_code" => $this->sort_code
		];
	}
}