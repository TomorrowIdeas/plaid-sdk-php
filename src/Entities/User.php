<?php

namespace TomorrowIdeas\Plaid\Entities;

use DateTime;
use JsonSerializable;

class User implements JsonSerializable
{
	/**
	 * @see https://plaid.com/docs/api/tokens/#link-token-create-request-user
	 * @param string $id Your unique identifier for the user.
	 * @param string|null $name User's legal full name.
	 * @param string|null $phone_number User's phone number in E-164 format.
	 * @param DateTime|null $phone_number_verified_time Timestamp when phone number was verified.
	 * @param string|null $email_address User's email address.
	 * @param DateTime|null $email_address_verified_time Timestamp when email address was verified.
	 * @param string|null $ssn User's social security number.
	 * @param DateTime|null $date_of_birth User's date of birth.
	 */
	public function __construct(
		protected string $id,
		protected ?string $name = null,
		protected ?string $phone_number = null,
		protected ?DateTime $phone_number_verified_time = null,
		protected ?string $email_address = null,
		protected ?DateTime $email_address_verified_time = null,
		protected ?string $ssn = null,
		protected ?DateTime $date_of_birth = null
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		return \array_filter(
			[
				"client_user_id" => $this->id,
				"legal_name" => $this->name,
				"phone_number" => $this->phone_number,
				"phone_number_verified_time" => $this->phone_number_verified_time?->format("c"),
				"email_address" => $this->email_address,
				"email_address_verified_time" => $this->email_address_verified_time?->format("c"),
				"ssn" => $this->ssn,
				"date_of_birth" => $this->date_of_birth?->format("Y-m-d")
			],
			fn($item) => $item !== null
		);
	}
}