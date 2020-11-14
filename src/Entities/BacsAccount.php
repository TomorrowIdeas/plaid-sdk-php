<?php

namespace TomorrowIdeas\Plaid\Entities;

class BacsAccount
{
	/**
	 * Account number.
	 *
	 * @var string
	 */
	protected $account;

	/**
	 * Sort code.
	 *
	 * @var string
	 */
	protected $sort_code;

	public function __construct(
		string $account,
		string $sort_code
	)
	{
		$this->account = $account;
		$this->sort_code = $sort_code;
	}

	public function toArray(): array
	{
		return [
			"account" => $this->account,
			"sort_code" => $this->sort_code
		];
	}
}