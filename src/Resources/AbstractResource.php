<?php

namespace TomorrowIdeas\Plaid\Resources;

use Capsule\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use TomorrowIdeas\Plaid\Plaid;
use TomorrowIdeas\Plaid\PlaidRequestException;
use UnexpectedValueException;

abstract class AbstractResource
{
	/**
	 * @param ClientInterface $httpClient PSR-6 ClientInterface instance.
	 * @param string $client_id Plaid client Id.
	 * @param string $client_secret Plaid client secret.
	 * @param string $hostname Plaid hostname to use.
	 */
	public function __construct(
		protected ClientInterface $httpClient,
		protected string $client_id,
		protected string $client_secret,
		protected string $hostname)
	{
	}

	/**
	 * Build request body with client credentials.
	 *
	 * @param array<array-key,mixed> $params
	 * @return array
	 */
	protected function paramsWithClientCredentials(array $params = []): array
	{
		return \array_merge([
			"client_id" => $this->client_id,
			"secret" => $this->client_secret
		], $params);
	}

	/**
	 * Send a request and parse the response.
	 *
	 * @param string $method
	 * @param string $path
	 * @param array<array-key,mixed> $params
	 * @throws PlaidRequestException
	 * @throws UnexpectedValueException
	 * @return object
	 */
	protected function sendRequest(string $method, string $path, array $params = []): object
	{
		$response = $this->sendRequestRawResponse($method, $path, $params);

		$payload = \json_decode($response->getBody()->getContents());

		if( \json_last_error() !== JSON_ERROR_NONE ){
			throw new UnexpectedValueException("Invalid JSON response returned by Plaid");
		}

		return (object) $payload;
	}

	/**
	 * Make an HTTP request and get back the ResponseInterface instance.
	 *
	 * @param string $method
	 * @param string $path
	 * @param array<array-key,mixed> $params
	 * @throws PlaidRequestException
	 * @return ResponseInterface
	 */
	protected function sendRequestRawResponse(string $method, string $path, array $params = []): ResponseInterface
	{
		$response = $this->httpClient->sendRequest(
			$this->buildRequest($method, $path, $params)
		);

		if( $response->getStatusCode() < 200 || $response->getStatusCode() >= 300 ){
			throw new PlaidRequestException($response);
		}

		return $response;
	}

	/**
	 * Build the RequestInterface instance to be sent by the HttpClientInterface instance.
	 *
	 * @param string $method
	 * @param string $path
	 * @param array<array-key,mixed> $params
	 * @return RequestInterface
	 */
	protected function buildRequest(string $method, string $path, array $params = []): RequestInterface
	{
		return new Request(
			$method,
			$this->hostname . \trim($path, "/"),
			\json_encode((object) $params),
			[
				"Plaid-Version" => Plaid::API_VERSION,
				"Content-Type" => "application/json"
			]
		);
	}
}