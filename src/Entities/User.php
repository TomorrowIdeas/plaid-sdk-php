<?php

namespace TomorrowIdeas\Plaid\Entities;

class User
{
	/**
	 * User ID
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * User legal full name
	 *
	 * @var string|null
	 */
	protected $name;

	/**
	 * User phone number
	 *
	 * @var string|null
	 */
	protected $phone_number;

	/**
	 * User phone number verified timestamp.
	 *
	 * @var string|null
	 */
	protected $phone_number_verified_time;

	/**
	 * User email address
	 *
	 * @var string|null
	 */
	protected $email_address;

	/**
	 * User social security number
	 *
	 * @var string|null
	 */
	protected $ssn;

	/**
	 * User date of birth
	 *
	 * @var string|null
	 */
	protected $date_of_birth;

	public function __construct(
		string $id,
		?string $name = null,
		?string $phone_number = null,
		?string $phone_number_verified_time = null,
		?string $email_address = null,
		?string $ssn = null,
		?string $date_of_birth = null
	)
	{
		$this->id = $id;
		$this->name = $name;
		$this->phone_number = $phone_number;
		$this->phone_number_verified_time = $phone_number_verified_time;
		$this->email_address = $email_address;
		$this->ssn = $ssn;
		$this->date_of_birth = $date_of_birth;
	}

	public function toArray(): array
	{
		return \array_filter(
			[
				"client_user_id" => $this->id,
				"legal_name" => $this->name,
				"phone_number" => $this->phone_number,
				"phone_number_verified_time" => $this->phone_number_verified_time,
				"email_address" => $this->email_address,
				"ssn" => $this->ssn,
				"date_of_birth" => $this->date_of_birth
			],
			function($value): bool {
				return $value !== null;
			}
		);
	}
}