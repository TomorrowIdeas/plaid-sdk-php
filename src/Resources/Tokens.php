<?php

namespace TomorrowIdeas\Plaid\Resources;

use TomorrowIdeas\Plaid\Entities\AccountFilters;
use TomorrowIdeas\Plaid\Entities\User;

class Tokens extends AbstractResource
{
	/**
	 * Create a Link Token.
	 *
	 * @param string $client_name
	 * @param string $language Possible values are: en, fr, es, nl
	 * @param array<string> $country_codes Possible values are: CA, FR, IE, NL, ES, GB, US
	 * @param User $user
	 * @param array<string> $products Possible values are: transactions, auth, identity, income, assets, investments, liabilities, payment_initiation
	 * @param string|null $webhook
	 * @param string|null $link_customization_name
	 * @param AccountFilters|null $account_filters
	 * @param string|null $access_token
	 * @param string|null $redirect_uri
	 * @param string|null $android_package_name
	 * @param string|null $payment_id
	 * @return object
	 */
	public function create(
		string $client_name,
		string $language,
		array $country_codes,
		User $user,
		array $products = [],
		?string $webhook = null,
		?string $link_customization_name = null,
		?AccountFilters $account_filters = null,
		?string $access_token = null,
		?string $redirect_uri = null,
		?string $android_package_name = null,
		?string $payment_id = null): object {

		$params = [
			"client_name" => $client_name,
			"language" => $language,
			"country_codes" => $country_codes,
			"user" => $user->toArray(),
			"products" => $products
		];

		if( $webhook ){
			$params["webhook"] = $webhook;
		}

		if( $link_customization_name ){
			$params["link_customization_name"] = $link_customization_name;
		}

		if( $account_filters ){
			$params["account_filters"] = $account_filters->toArray();
		}

		if( $access_token ){
			$params["access_token"] = $access_token;
		}

		if( $redirect_uri ){
			$params["redirect_uri"] = $redirect_uri;
		}

		if( $android_package_name ){
			$params["android_package_name"] = $android_package_name;
		}

		if( $payment_id ){
			$params["payment_initiation"] = [
				"payment_id" => $payment_id
			];
		}

		return $this->sendRequest(
			"post",
			"link/token/create",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get information about a previously created Link token.
	 *
	 * @param string $link_token
	 * @return object
	 */
	public function get(string $link_token): object
	{
		$params = [
			"link_token" => $link_token
		];

		return $this->sendRequest(
			"post",
			"link/token/get",
			$this->paramsWithClientCredentials($params)
		);
	}
}