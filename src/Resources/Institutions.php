<?php

namespace TomorrowIdeas\Plaid\Resources;

class Institutions extends AbstractResource
{
	/**
	 * Get a specific Insitution.
	 *
	 * @deprecated 1.1 Use get() method.
	 * @param string $institution_id
	 * @param array<string,string> $options
	 * @return object
	 */
	public function getInstitution(string $institution_id, array $options = []): object
	{
		return $this->get($institution_id, $options);
	}

	/**
	 * Get a specific Insitution.
	 *
	 * @param string $institution_id
	 * @param array<string,string> $options
	 * @return object
	 */
	public function get(string $institution_id, array $options = []): object
	{
		$params = [
			"institution_id" => $institution_id,
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
	 * @deprecated 1.1 Use list() method.
	 * @param integer $count
	 * @param integer $offset
	 * @param array<string,string> $options
	 * @return object
	 */
	public function getInstitutions(int $count, int $offset, array $options = []): object
	{
		return $this->list($count, $offset, $options);
	}

	/**
	 * Get all Institutions.
	 *
	 * @param integer $count
	 * @param integer $offset
	 * @param array<string,string> $options
	 * @return object
	 */
	public function list(int $count, int $offset, array $options = []): object
	{
		$params = [
			"count" => $count,
			"offset" => $offset,
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
	 * @deprecated 1.1 Use find() method.
	 * @param string $query
	 * @param array<string> $products
	 * @param array<string> $country_codes Possible values: US, GB, ES, NL, FR, IE, CA
	 * @param array<string,string> $options
	 * @return object
	 */
	public function findInstitution(
		string $query,
		array $country_codes,
		array $products = [],
		array $options = []): object
	{
		return $this->find($query, $country_codes, $products, $options);
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