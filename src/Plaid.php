<?php

namespace TomorrowIdeas\Plaid;

use Psr\Http\Client\ClientInterface;
use ReflectionClass;
use Shuttle\Shuttle;
use TomorrowIdeas\Plaid\Resources\AbstractResource;
use UnexpectedValueException;

/**
 * @property \TomorrowIdeas\Plaid\Resources\Accounts $accounts
 * @property \TomorrowIdeas\Plaid\Resources\Auth $auth
 * @property \TomorrowIdeas\Plaid\Resources\BankTransfers $bank_transfers
 * @property \TomorrowIdeas\Plaid\Resources\Categories $categories
 * @property \TomorrowIdeas\Plaid\Resources\Institutions $institutions
 * @property \TomorrowIdeas\Plaid\Resources\Investments	$investments
 * @property \TomorrowIdeas\Plaid\Resources\Items $items
 * @property \TomorrowIdeas\Plaid\Resources\Liabilities $liabilities
 * @property \TomorrowIdeas\Plaid\Resources\Tokens $tokens
 * @property \TomorrowIdeas\Plaid\Resources\Payments $payments
 * @property \TomorrowIdeas\Plaid\Resources\Processors $processors
 * @property \TomorrowIdeas\Plaid\Resources\Reports $reports
 * @property \TomorrowIdeas\Plaid\Resources\Sandbox $sandbox
 * @property \TomorrowIdeas\Plaid\Resources\Transactions $transactions
 * @property \TomorrowIdeas\Plaid\Resources\Webhooks $webhooks
 */
class Plaid
{
	const API_VERSION = "2020-09-14";

	/**
	 * Plaid client Id.
	 *
	 * @var string
	 */
	protected $client_id;

	/**
	 * Plaid client secret.
	 *
	 * @var string
	 */
	protected $client_secret;

	/**
	 * Plaid API host environment.
	 *
	 * @var string
	 */
	protected $environment = "production";

	/**
	 * Plaid API environments and matching hostname.
	 *
	 * @var array<string,string>
	 */
	protected $plaidEnvironments = [
		"production" => "https://production.plaid.com/",
		"development" => "https://development.plaid.com/",
		"sandbox" => "https://sandbox.plaid.com/",
	];

	/**
	 * ClientInterface instance.
	 *
	 * @var ClientInterface|null
	 */
	protected $httpClient;

	/**
	 * Resource instance cache.
	 *
	 * @var array<AbstractResource>
	 */
	protected $resource_cache = [];

	/**
	 * @param string $client_id
	 * @param string $client_secret
	 * @param string $environment Possible values are: production, development, sandbox
	 */
	public function __construct(
		string $client_id,
		string $client_secret,
		string $environment = "production")
	{
		if( !\array_key_exists($environment, $this->plaidEnvironments) ){
			throw new UnexpectedValueException("Invalid environment. Environment must be one of: production, development, or sandbox.");
		}

		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->environment = $environment;
	}

	/**
	 * Magic getter for resources.
	 *
	 * @param string $resource
	 * @throws UnexpectedValueException
	 * @return AbstractResource
	 */
	public function __get(string $resource): AbstractResource
	{
		if( !isset($this->resource_cache[$resource]) ){

			$resource = \str_replace([" "], "", \ucwords(\str_replace(["_"], " ", $resource)));

			$resource_class = "\\TomorrowIdeas\\Plaid\\Resources\\" . $resource;

			if( !\class_exists($resource_class) ){
				throw new UnexpectedValueException("Unknown Plaid resource: {$resource}");
			}

			$reflectionClass = new ReflectionClass($resource_class);

			/**
			 * @var AbstractResource $resource_instance
			 */
			$resource_instance = $reflectionClass->newInstanceArgs([
				$this->getHttpClient(),
				$this->client_id,
				$this->client_secret,
				$this->plaidEnvironments[$this->environment]
			]);

			$this->resource_cache[$resource] = $resource_instance;
		}

		return $this->resource_cache[$resource];
	}

	/**
	 * Set a specific ClientInterface instance to be used to make HTTP calls.
	 *
	 * @param ClientInterface $httpClient
	 * @return void
	 */
	public function setHttpClient(ClientInterface $httpClient): void
	{
		$this->httpClient = $httpClient;
	}

	/**
	 * Get the ClientInterface instance being used to make HTTP calls.
	 *
	 * @return ClientInterface
	 */
	public function getHttpClient(): ClientInterface
	{
		if( empty($this->httpClient) ){
			$this->httpClient = new Shuttle;
		}

		return $this->httpClient;
	}
}
