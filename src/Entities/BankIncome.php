<?php

namespace TomorrowIdeas\Plaid\Entities;

use JsonSerializable;

class BankIncome implements JsonSerializable
{
	/**
	 * @see https://plaid.com/docs/api/tokens/#link-token-create-request-income-verification-bank-income
	 * @param integer $days_requested
	 * @param boolean $enable_multiple_items
	 */
	public function __construct(
		protected int $days_requested,
		protected bool $enable_multiple_items = false
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		return [
			"days_requested" => $this->days_requested,
			"enable_multiple_items" => $this->enable_multiple_items
		];
	}
}