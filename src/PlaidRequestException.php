<?php

namespace TomorrowIdeas\Plaid;

use Psr\Http\Message\ResponseInterface;

class PlaidRequestException extends PlaidException
{
	/**
	 * Get the response payload.
	 *
	 * @var object|null
	 */
	protected $response;

	/**
	 * PlaidRequestException constructor.
	 *
	 * @param ResponseInterface $responseInterface
	 */
	public function __construct(ResponseInterface $responseInterface)
	{
		$response = \json_decode($responseInterface->getBody()->getContents());

		$this->code = $responseInterface->getStatusCode();

		if( \is_object($response) ){
			$this->response = $response;
			$this->message = (string) ($this->response->display_message ?? $responseInterface->getReasonPhrase());
		}

		else {
			$this->message = $responseInterface->getReasonPhrase();
		}
	}

	/**
	 * Get the Plaid specific error payload.
	 *
	 * @return object|null
	 */
	public function getResponse(): ?object
	{
		return $this->response;
	}
}