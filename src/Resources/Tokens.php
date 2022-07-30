<?php

namespace TomorrowIdeas\Plaid\Resources;

use TomorrowIdeas\Plaid\Entities\AccountFilters;
use TomorrowIdeas\Plaid\Entities\DepositSwitch;
use TomorrowIdeas\Plaid\Entities\IdentityVerification;
use TomorrowIdeas\Plaid\Entities\IncomeVerification;
use TomorrowIdeas\Plaid\Entities\InstitutionData;
use TomorrowIdeas\Plaid\Entities\PaymentInitiation;
use TomorrowIdeas\Plaid\Entities\Transfer;
use TomorrowIdeas\Plaid\Entities\Update;
use TomorrowIdeas\Plaid\Entities\User;
use TomorrowIdeas\Plaid\PlaidRequestException;

class Tokens extends AbstractResource
{
	/**
	 * Create a Link Token.
	 * @see https://plaid.com/docs/api/tokens/#linktokencreate
	 * @param string $client_name
	 * @param string $language Possible values are: en, fr, es, nl, de
	 * @param array<string> $country_codes Possible values are: US, GB, ES, NL, FR, IE, CA, DE, IT
	 * @param User $user
	 * @param array<string> $products Possible values are: assets, auth, employment, identity, income_verification, identity_verification, investments, liabilities, payment_initiation, standing_orders, transactions, transfer
	 * @param string|null $webhook
	 * @param string|null $link_customization_name
	 * @param AccountFilters|null $account_filters
	 * @param string|null $access_token
	 * @param string|null $redirect_uri
	 * @param string|null $android_package_name
	 * @param PaymentInitiation $payment_initiation
	 * @param string|null $institution_id
	 * @param InstitutionData|null $institution_data
	 * @param array<string> $additional_consented_products
	 * @param DepositSwitch|null $deposit_switch
	 * @param IncomeVerification|null $income_verification
	 * @param Auth|null $auth
	 * @param Transfer|null $transfer
	 * @param Update|null $update
	 * @param IdentityVerification $identity_verification
	 * @param string|null $user_token
	 * @throws PlaidRequestException
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
		?PaymentInitiation $payment_initiation = null,
		?string $institution_id = null,
		?InstitutionData $institution_data = null,
		array $additional_consented_products = [],
		?DepositSwitch $deposit_switch = null,
		?IncomeVerification $income_verification = null,
		?Auth $auth = null,
		?Transfer $transfer = null,
		?Update $update = null,
		?IdentityVerification $identity_verification = null,
		?string $user_token = null): object {

		$params = [
			"client_name" => $client_name,
			"language" => $language,
			"country_codes" => $country_codes,
			"user" => $user,
			"products" => $products,
			"webhook" => $webhook,
			"link_customization_name" => $link_customization_name,
			"account_filters" => $account_filters,
			"access_token" => $access_token,
			"redirect_uri" => $redirect_uri,
			"android_package_name" => $android_package_name,
			"payment_initiation" => $payment_initiation,
			"institution_id" => $institution_id,
			"institution_data" => $institution_data,
			"deposit_switch" => $deposit_switch,
			"income_verification" => $income_verification,
			"auth" => $auth,
			"transfer" => $transfer,
			"update" => $update,
			"identity_verification" => $identity_verification,
			"user_token" => $user_token
		];

		if( !empty($additional_consented_products) ){
			$params["additional_consented_products"] = $additional_consented_products;
		}

		$params = \array_filter($params, fn($item) => $item !== null);


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
	 * @throws PlaidRequestException
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