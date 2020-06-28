<?php

namespace TomorrowIdeas\Plaid\Entities;

class RecipientAddress
{
	/**
	 * Street address.
	 *
	 * @var string
	 */
	protected $street;

	/**
	 * Additional street address.
	 *
	 * @var string|null
	 */
	protected $street2;

	/**
	 * City
	 *
	 * @var string
	 */
	protected $city;

	/**
	 * Postal code
	 *
	 * @var string
	 */
	protected $postal_code;

	/**
	 * Country (2 character ISO)
	 *
	 * @var string
	 */
	protected $country;

	/**
	 * Address constructor.
	 *
	 * The Address object is needed for certain requests to Plaid.
	 *
	 * @param string $street
	 * @param string|null $street2
	 * @param string $city
	 * @param string $postal_code
	 * @param string $country
	 */
	public function __construct(
		string $street,
		?string $street2,
		string $city,
		string $postal_code,
		string $country)
	{
		$this->street = $street;
		$this->street2 = $street2;
		$this->city = $city;
		$this->postal_code = $postal_code;
		$this->country = $country;
	}

	/**
	 * Convert the object into a key=>value pair that can be used in HTTP requests.
	 *
	 * @return array
	 */
	public function toArray(): array
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