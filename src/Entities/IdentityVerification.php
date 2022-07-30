<?php

namespace TomorrowIdeas\Plaid\Entities;

use JsonSerializable;

class IdentityVerification implements JsonSerializable
{
	/**
	 * @see https://plaid.com/docs/api/tokens/#link-token-create-request-identity-verification
	 * @param string $template_id
	 * @param boolean $gave_consent
	 */
	public function __construct(
		protected string $template_id,
		protected bool $gave_consent = false
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		return [
			"template_id" => $this->template_id,
			"gave_consent" => $this->gave_consent
		];
	}
}