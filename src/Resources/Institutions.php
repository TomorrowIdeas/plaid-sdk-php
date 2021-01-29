<?php

namespace TomorrowIdeas\Plaid\Resources;

class Institutions extends AbstractResource
{
	/**
	 * Get a specific Insitution.
	 *
	 * @param string $institution_id
	 * @param array<string> $country_codes
	 * @param array<string,string> $options
	 * @return object
	 */
	public function get(string $institution_id, array $country_codes, array $options = []): object
	{
		$params = [
			"institution_id" => $institution_id,
			"country_codes" => $country_codes,
			"options" => (object) $options
		];

		return $this->sendRequest(
			"post",
			"institutions/get_by_id",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get all Institutions.
	 *
	 * @param integer $count
	 * @param integer $offset
	 * @param array<string> $country_codes
	 * @param array<string,string> $options
	 * @return object
	 */
	public function list(int $count, int $offset, array $country_codes, array $options = []): object
	{
		$params = [
			"count" => $count,
			"offset" => $offset,
			"country_codes" => $country_codes,
			"options" => (object) $options
		];

		return $this->sendRequest(
			"post",
			"institutions/get",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Find an Institution by a search query.
	 *
	 * @param string $query
	 * @param array<string> $products
	 * @param array<string> $country_codes Possible values: US, GB, ES, NL, FR, IE, CA
	 * @param array<string,string> $options
	 * @return object
	 */
	public function find(
		string $query,
		array $country_codes,
		array $products = [],
		array $options = []): object
	{
		$params = [
			"query" => $query,
			"products" => $products ? $products : null,
			"country_codes" => $country_codes,
			"options" => (object) $options
		];

		return $this->sendRequest(
			"post",
			"institutions/search",
			$this->paramsWithClientCredentials($params)
		);
	}
}