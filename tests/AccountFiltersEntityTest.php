<?php

use TomorrowIdeas\Plaid\Entities\AccountFilters;
use TomorrowIdeas\Plaid\Tests\TestCase;

/**
 * @covers TomorrowIdeas\Plaid\Entities\AccountFilters
 */
class AccountFiltersEntityTest extends TestCase
{
	public function test_constructor_sets_filters(): void
	{
		$filters = [
			"depository" => ["auth", "identity"]
		];

		$accountFilters = new AccountFilters($filters);

		$this->assertEquals(
			[
				"depository" => [
					"account_subtypes" => ["auth", "identity"]
				]
			],
			$accountFilters->jsonSerialize()
		);
	}

	public function test_set_filter_ignores_empty_subtype_array(): void
	{
		$accountFilters = new AccountFilters;

		$reflectionClass = new ReflectionClass($accountFilters);
		$reflectionMethod = $reflectionClass->getMethod("setFilter");
		$reflectionMethod->setAccessible(true);

		$reflectionMethod->invokeArgs($accountFilters, ["loan", []]);

		$this->assertEmpty(
			$accountFilters->jsonSerialize()
		);
	}

	public function test_set_depository_filters(): void
	{
		$accountFilters = new AccountFilters;
		$accountFilters->setDepositoryFilters(["auth", "transactions", "identity", "income", "assets"]);

		$this->assertEquals(
			[
				"depository" => [
					"account_subtypes" => ["auth", "transactions", "identity", "income", "assets"]
				]
			],
			$accountFilters->jsonSerialize()
		);
	}

	public function test_set_credit_filters(): void
	{
		$accountFilters = new AccountFilters;
		$accountFilters->setCreditFilters(["transactions", "identity", "liabilities"]);

		$this->assertEquals(
			[
				"credit" => [
					"account_subtypes" => ["transactions", "identity", "liabilities"]
				]
			],
			$accountFilters->jsonSerialize()
		);
	}

	public function test_set_investment_filters(): void
	{
		$accountFilters = new AccountFilters;
		$accountFilters->setInvestmentFilters(["investments"]);

		$this->assertEquals(
			[
				"investment" => [
					"account_subtypes" => ["investments"]
				]
			],
			$accountFilters->jsonSerialize()
		);
	}

	public function test_set_loan_filters(): void
	{
		$accountFilters = new AccountFilters;
		$accountFilters->setLoanFilters(["transactions", "liabilities"]);

		$this->assertEquals(
			[
				"loan" => [
					"account_subtypes" => ["transactions", "liabilities"]
				]
			],
			$accountFilters->jsonSerialize()
		);
	}

	public function test_set_other_filters(): void
	{
		$accountFilters = new AccountFilters;
		$accountFilters->setOtherFilters(["auth", "transactions", "identity", "assets"]);

		$this->assertEquals(
			[
				"other" => [
					"account_subtypes" => ["auth", "transactions", "identity", "assets"]
				]
			],
			$accountFilters->jsonSerialize()
		);
	}
}