<?php

namespace TomorrowIdeas\Plaid\Entities;

use JsonSerializable;

class PaymentInitiation implements JsonSerializable
{
	/**
	 * @see https://plaid.com/docs/api/tokens/#link-token-create-request-payment-initiation
	 * @param string $payment_id
	 * @param string|null $consent_id
	 */
	public function __construct(
		protected string $payment_id,
		protected ?string $consent_id = null
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		return [
			"payment_id" => $this->payment_id,
			"consent_id" => $this->consent_id
		];
	}
}