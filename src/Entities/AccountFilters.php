<?php

namespace TomorrowIdeas\Plaid\Entities;

class AccountFilters
{
	/**
	 * Filters to be applied.
	 *
	 * @var array<string,array<string,array<string>>>
	 */
	protected $filters = [];


	/**
	 * AccountFilters constructor.
	 *
	 * @param array<string,array<string>> $filters
	 */
	public function __construct(array $filters = [])
	{
		foreach( $filters as $name => $subtypes ){
			$this->setFilter($name, $subtypes);
		}
	}

	/**
	 * Set filters for the given type.
	 *
	 * @param string $type
	 * @param array<string> $subtypes
	 * @return void
	 */
	protected function setFilter(string $type, array $subtypes): void
	{
		if( empty($subtypes) ){
			return;
		}

		$this->filters[$type] = ["account_subtypes" => $subtypes];
	}

	/**
	 * Set depository subtype filters.
	 *
	 * Possible subtypes are:
	 *	auth
	 *	transactions
	 *	identity
	 *	income
	 *	assets
	 *	all
	 *
	 * @param array<string> $subtypes
	 * @return void
	 */
	public function setDepositoryFilters(array $subtypes): void
	{
		$this->setFilter("depository", $subtypes);
	}

	/**
	 * Set credit filters.
	 *
	 * Possible subtypes are:
	 *	transactions
	 *	identity
	 * 	liabilities
	 *	all
	 *
	 * @param array<string> $subtypes
	 * @return void
	 */
	public function setCreditFilters(array $subtypes): void
	{
		$this->setFilter("credit", $subtypes);
	}

	/**
	 * Set investment filters.
	 *
	 * Possible subtypes are:
	 * 	investment
	 * 	all
	 *
	 * @param array<string> $subtypes
	 * @return void
	 */
	public function setInvestmentFilters(array $subtypes): void
	{
		$this->setFilter("investment", $subtypes);
	}

	/**
	 * Set loan filters.
	 *
	 * Possible values are:
	 * 	transactions
	 * 	liabilities
	 * 	all
	 *
	 * @param array<string> $subtypes
	 * @return void
	 */
	public function setLoanFilters(array $subtypes): void
	{
		$this->setFilter("loan", $subtypes);
	}

	/**
	 * Set other filters.
	 *
	 * Possible values are:
	 * 	auth
	 * 	transactions
	 * 	identity
	 * 	assets
	 *	all
	 *
	 * @param array<string> $subtypes
	 * @return void
	 */
	public function setOtherFilters(array $subtypes): void
	{
		$this->setFilter("other", $subtypes);
	}

	/**
	 * Get all filters as array.
	 *
	 * @return array<string,array<string,array<string>>>
	 */
	public function toArray(): array
	{
		return $this->filters;
	}
}