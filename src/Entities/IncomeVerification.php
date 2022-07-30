<?php

namespace TomorrowIdeas\Plaid\Entities;

use JsonSerializable;

class IncomeVerification implements JsonSerializable
{
	/**
	 * @see https://plaid.com/docs/api/tokens/#link-token-create-request-income-verification
	 * @param string|null $income_verification_id
	 * @param string|null $asset_report_id
	 * @param string|null $precheck_id
	 * @param array $access_tokens
	 * @param array $income_source_types
	 * @param BankIncome|null $bankIncome
	 * @param PayrollIncome|null $payrollIncome
	 * @param StatedIncomeSources|null $statedIncomeSources
	 */
	public function __construct(
		protected ?string $income_verification_id = null,
		protected ?string $asset_report_id = null,
		protected ?string $precheck_id = null,
		protected array $access_tokens = [],
		protected array $income_source_types = [],
		protected ?BankIncome $bank_income = null,
		protected ?PayrollIncome $payroll_income = null,
		protected ?StatedIncomeSources $stated_income_sources = null,
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		return \array_filter([
			"income_verification_id" => $this->income_verification_id,
			"asset_report_id" => $this->asset_report_id,
			"precheck_id" => $this->precheck_id,
			"access_tokens" => $this->access_tokens,
			"income_source_types" => $this->income_source_types,
			"bank_income" => $this->bank_income,
			"payroll_income" => $this->payroll_income,
			"stated_income_sources" => $this->stated_income_sources
		],
			fn($item) => $item !== null
		);
	}
}