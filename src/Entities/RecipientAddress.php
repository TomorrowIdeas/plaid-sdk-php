<?php

namespace TomorrowIdeas\Plaid\Entities;

use JsonSerializable;

class RecipientAddress implements JsonSerializable
{
	/**
	 * @param string $street
	 * @param string|null $street2
	 * @param string $city
	 * @param string $postal_code
	 * @param string $country Country (2 character ISO)
	 */
	public function __construct(
		protected string $street,
		protected ?string $street2,
		protected string $city,
		protected string $postal_code,
		protected string $country)
	{
	}

	/**
	 * Convert the object into a key=>value pair that can be used in HTTP requests.
	 *
	 * @return array
	 */
	public function jsonSerialize(): mixed
	{
		$streetAddress = [$this->street];

		if( $this->street2 ){
			$streetAddress[] = $this->street2;
		}

		return [
			"street" => $streetAddress,
			"city" => $this->city,
			"postal_code" => $this->postal_code,
			"country" => $this->country
		];
	}
}