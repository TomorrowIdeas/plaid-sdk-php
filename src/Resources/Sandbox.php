<?php

namespace TomorrowIdeas\Plaid\Resources;

class Sandbox extends AbstractResource
{
	/**
	 * Create a new public token.
	 *
	 * @param string $institution_id
	 * @param array $initial_products
	 * @param array $options
	 * @return object
	 */
	public function createPublicToken(
		string $institution_id,
		array $initial_products,
		array $options = []): object
	{
		$params = [
			"institution_id" => $institution_id,
			"initial_products" => $initial_products,
			"options" => (object) $options
		];

		return $this->sendRequest(
			"post",
			"sandbox/public_token/create",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Reset an Item's login status.
	 *
	 * @param string $access_token
	 * @return object
	 */
	public function resetLogin(string $access_token): object
	{
		$params = [
			"access_token" => $access_token
		];

		return $this->sendRequest(
			"post",
			"sandbox/item/reset_login",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Reset an Item's verification status.
	 *
	 * @param string $access_token
	 * @param string $account_id
	 * @param string $verification_status
	 * @return object
	 */
	public function setVerificationStatus(
		string $access_token,
		string $account_id,
		string $verification_status): object
	{
		$params = [
			"access_token" => $access_token,
			"account_id" => $account_id,
			"verification_status" => $verification_status
		];

		return $this->sendRequest(
			"post",
			"sandbox/item/reset_verification_status",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Fire off a webhook event for an Item.
	 *
	 * @param string $access_token
	 * @param string $webhook_code
	 * @return object
	 */
	public function fireWebhook(
		string $access_token,
		string $webhook_code = "DEFAULT_UPDATE"): object
	{
		$params = [
			"access_token" => $access_token,
			"webhook_code" => $webhook_code
		];

		return $this->sendRequest(
			"post",
			"sandbox/item/fire_webhook",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Simulate a Bank Transfer.
	 *
	 * @param string $bank_transfer_id
	 * @param string $event_type
	 * @param string|null $ach_return_code
	 * @param string|null $failure_description
	 * @return object
	 */
	public function simulateBankTransfer(
		string $bank_transfer_id,
		string $event_type,
		?string $ach_return_code = null,
		?string $failure_description = null): object
	{
		$params = [
			"bank_transfer_id" => $bank_transfer_id,
			"event_type" => $event_type
		];

		if( $ach_return_code || $failure_description ){
			$params["failure_reason"] = [
				"ach_return_code" => $ach_return_code,
				"description" => $failure_description
			];
		}

		return $this->sendRequest(
			"post",
			"sandbox/bank_transfer/simulate",
			$this->paramsWithClientCredentials($params)
		);
	}
}