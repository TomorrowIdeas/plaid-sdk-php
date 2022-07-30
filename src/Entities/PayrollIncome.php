<?php

namespace TomorrowIdeas\Plaid\Entities;

use JsonSerializable;

class PayrollIncome implements JsonSerializable
{
	/**
	 * @see https://plaid.com/docs/api/tokens/#link-token-create-request-income-verification-payroll-income
	 * @param array<string> $flow_types Possible values: payroll_digital_income, payroll_document_income
	 * @param boolean $is_update_mode
	 */
	public function __construct(
		protected array $flow_types,
		protected bool $is_update_mode = false
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		return [
			"flow_types" => $this->flow_types,
			"is_update_mode" => $this->is_update_mode
		];
	}
}