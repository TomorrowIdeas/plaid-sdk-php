<?php

namespace TomorrowIdeas\Plaid\Entities;

use JsonSerializable;

class StatedIncomeSources implements JsonSerializable
{
	/**
	 * @see https://plaid.com/docs/api/tokens/#link-token-create-request-income-verification-stated-income-sources
	 * @param string $employer
	 * @param string $category Possible values: OTHER, SALARY, UNEMPLOYMENT, CASH, GIG_ECONOMY, RENTAL, CHILD_SUPPORT, MILITARY, RETIREMENT, LONG_TERM_DISABILITY, BANK_INTEREST
	 * @param float $pay_per_cycle
	 * @param float $pay_annual
	 * @param string $pay_type Possible values: UNKNOWN, GROSS, NET
	 * @param string $pay_frequency Possible values: UNKNOWN, WEEKLY, BIWEEKLY, SEMI_MONTHLY, MONTHLY
	 */
	public function __construct(
		protected string $employer,
		protected string $category,
		protected float $pay_per_cycle,
		protected float $pay_annual,
		protected string $pay_type,
		protected string $pay_frequency
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		return [
			"employer" => $this->employer,
			"category" => $this->category,
			"pay_per_cycle" => $this->pay_per_cycle,
			"pay_annual" => $this->pay_annual,
			"pay_type" => $this->pay_type,
			"pay_frequency" => $this->pay_frequency
		];
	}
}