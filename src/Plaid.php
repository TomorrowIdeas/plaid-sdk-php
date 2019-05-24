<?php

namespace TomorrowIdeas\Plaid;

use Capsule\Request;
use DateTime;
use Psr\Http\Client\ClientInterface;
use Shuttle\Shuttle;

final class Plaid
{
    /**
     * Plaid API version.
     */
    const PLAID_VERSION = "2018-05-22";

    /**
     * Plaid API host environment.
     *
     * @var string
     */
    private $environment = "production";

    /**
     * Plaid API host name.
     */
    private $plaidHost = [
        "production" => "https://production.plaid.com/",
        "development" => "https://development.plaid.com/",
        "sandbox" => "https://sandbox.plaid.com/",
    ];

    /**
     * Plaid client Id.
     *
     * @var string
     */
    private $client_id;

    /**
     * Plaid client secret.
     *
     * @var string
     */
    private $secret;

    /**
     * Plaid public key.
     *
     * @var string
     */
    private $public_key;

    /**
     * PSR-18 ClientInterface instance.
     *
     * @var ClientInterface|null
     */
    private $httpClient;

    /**
     * Plaid client constructor.
     *
     * @param string $client_id
     * @param string $secret
     * @param string $public_key
     * @param string $environment
     */
    public function __construct(string $client_id, string $secret, string $public_key, string $environment = "production")
    {
        $this->client_id = $client_id;
        $this->secret = $secret;
        $this->public_key = $public_key;

        $this->setEnvironment($environment);
    }

    /**
     * Set the Plaid API environment.
     * 
     * Possible values: "production", "development", "sandbox"
     *
     * @param string $environment
     * @return void
     */
    public function setEnvironment(string $environment): void
    {
        if( !\array_key_exists($environment, $this->plaidHost) ){
            throw new PlaidException("Unknown or unsupported environment \"{$environment}\".");
        }

        $this->environment = $environment;
    }

    /**
     * Get the current environment.
     *
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * Get the specific environment host name.
     *
     * @param string $environment
     * @return string|null
     */
    private function getHostname(string $environment): ?string
    {
        return $this->plaidHost[$environment] ?? null;
    }

    /**
     * Set the HTTP client to use.
     *
     * @param ClientInterface $clientInterface
     * @return void
     */
    public function setHttpClient(ClientInterface $clientInterface): void
    {
        $this->httpClient = $clientInterface;
    }

    /**
     * Get the HTTP Client interface.
     *
     * @return ClientInterface
     */
    private function getHttpClient(): ClientInterface
    {
        if( empty($this->httpClient) ){
            $this->httpClient = new Shuttle;
        }

        return $this->httpClient;
    }

    /**
     * Process the request and decode response as JSON.
     *
     * @param Request $request
     * @return object
     */
    private function doRequest(Request $request): object
    {
        $response = $this->getHttpClient()->sendRequest($request);

        if( $response->getStatusCode() < 200 || $response->getStatusCode() >= 300 ){
            //dd($response->getBody()->getContents());
            throw new PlaidRequestException($response);
        }

        return \json_decode($response->getBody()->getContents());
    }

    /**
     * Build a PSR-7 Request instance.
     *
     * @param string $method
     * @param string $path
     * @param array $params
     * @return Request
     */
    private function buildRequest(string $method, string $path, array $params = []): Request
    {
        return new Request(
            $method,
            ($this->getHostname($this->environment) ?? "") . $path,
            \json_encode($params),
            [
                "Plaid-Version" => self::PLAID_VERSION,
                "Content-Type" => "application/json"
            ]
        );
    }

    /**
     * Build request body with client credentials.
     *
     * @param array $params
     * @return array
     */
    private function clientCredentials(array $params = []): array
    {
        return \array_merge([
            "client_id" => $this->client_id,
            "secret" => $this->secret
        ], $params);
    }

    /**
     * Build request body with public credentials.
     *
     * @param array $params
     * @return array
     */
    private function publicCredentials(array $params = []): array
    {
        return \array_merge([
            "public_key" => $this->public_key
        ], $params);
    }

    /**
     * Get all Plaid categories.
     *
     * @return object
     */
    public function getCategories(): object
    {
        return $this->doRequest(
            $this->buildRequest("post", "categories/get")
        );
    }

    /**
     * Get Auth request.
     *
     * @param string $access_token
     * @param array $options
     * @return object
     */
    public function getAuth(string $access_token, array $options = []): object
    {
        return $this->doRequest(
            $this->buildRequest("post", "auth/get", $this->clientCredentials(["access_token" => $access_token, "options" => $options]))
        );
    }

    /**
     * Get an Item.
     *
     * @param string $access_token
     * @return object
     */
    public function getItem(string $access_token): object
    {
        return $this->doRequest(
            $this->buildRequest("post", "item/get", $this->clientCredentials(["access_token" => $access_token]))
        );
    }

    /**
     * Remove an Item.
     *
     * @param string $access_token
     * @return object
     */
    public function removeItem(string $access_token): object
    {
        return $this->doRequest(
            $this->buildRequest("post", "item/remove", $this->clientCredentials(["access_token" => $access_token]))
        );
    }

    /**
     * Create a new Item public token.
     *
     * @param string $access_token
     * @return object
     */
    public function createPublicToken(string $access_token): object
    {
        return $this->doRequest(
            $this->buildRequest("post", "item/public_token/create", $this->clientCredentials(["access_token" => $access_token]))
        );
    }

    /**
     * Exchange an Item public token for an access token.
     *
     * @param string $public_token
     * @return object
     */
    public function exchangeToken(string $public_token): object
    {
        return $this->doRequest(
            $this->buildRequest("post", "item/public_token/exchange", $this->clientCredentials(["public_token" => $public_token]))
        );
    }

    /**
     * Rotate an Item's access token.
     *
     * @param string $access_token
     * @return object
     */
    public function rotateAccessToken(string $access_token): object
    {
        return $this->doRequest(
            $this->buildRequest("post", "item/access_token/invalidate", $this->clientCredentials(["access_token" => $access_token]))
        );
    }

    /**
     * Update an Item webhook.
     *
     * @param string $access_token
     * @param string $webhook
     * @return object
     */
    public function updateWebhook(string $access_token, string $webhook): object
    {
        return $this->doRequest(
            $this->buildRequest("post", "item/webhook/update", $this->clientCredentials(["access_token" => $access_token, "webhook" => $webhook]))
        );
    }

    /**
     * Get all Accounts.
     *
     * @param string $access_token
     * @return object
     */
    public function getAccounts(string $access_token): object
    {
        return $this->doRequest(
            $this->buildRequest("post", "accounts/get", $this->clientCredentials(["access_token" => $access_token]))
        );
    }

    /**
     * Get a specific Insitution.
     *
     * @param string $institution_id
     * @param array<string, string> $options
     * @return object
     */
    public function getInstitution(string $institution_id, array $options = []): object
    {
        $params = [
            "institution_id" => $institution_id,
            "options" => $options
        ];

        return $this->doRequest(
            $this->buildRequest("post", "institutions/get_by_id", $this->publicCredentials($params))
        );
    }

    /**
     * Get all Institutions.
     *
     * @param integer $count
     * @param integer $offset
     * @param array<string, string> $options
     * @return object
     */
    public function getInstitutions(int $count, int $offset, array $options = []): object
    {
        $params = [
            "count" => $count,
            "offset" => $offset,
            "options" => $options
        ];

        return $this->doRequest(
            $this->buildRequest("post", "institutions/get", $this->clientCredentials($params))
        );
    }
    
    /**
     * Find an Institution by a search query.
     *
     * @param string $query
     * @param array<string> $products
     * @param array<string, string> $options
     * @return object
     */
    public function findInstitution(string $query, array $products, array $options = []): object
    {
        $params = [
            "query" => $query,
            "products" => $products,
            "options" => $options
        ];

        return $this->doRequest(
            $this->buildRequest("post", "institutions/search", $this->publicCredentials($params))
        );
    }

    /**
     * Get all transactions for a particular Account.
     *
     * @param string $access_token
     * @param DateTime $start_date
     * @param DateTime $end_date
     * @param array<string, string> $options
     * @return object
     */
    public function getTransactions(string $access_token, DateTime $start_date, DateTime $end_date, array $options = []): object
    {
        $params = [
            "access_token" => $access_token,
            "start_date" => $start_date->format("Y-m-d"),
            "end_date" => $end_date->format("Y-m-d"),
            "options" => $options
        ];

        return $this->doRequest(
            $this->buildRequest("post", "transactions/get", $this->clientCredentials($params))
        );
    }

    /**
     * Get Account balance.
     *
     * @param string $access_token
     * @param array<string, string> $options
     * @return object
     */
    public function getBalance(string $access_token, array $options = []): object
    {
        return $this->doRequest(
            $this->buildRequest("post", "accounts/balance/get", $this->clientCredentials(["access_token" => $access_token, "options" => $options]))
        );
    }

    /**
     * Get Account identity information.
     *
     * @param string $access_token
     * @return object
     */
    public function getIdentity(string $access_token): object
    {
        return $this->doRequest(
            $this->buildRequest("post", "identity/get", $this->clientCredentials(["access_token" => $access_token]))
        );
    }

    /**
     * Get an Item's income information.
     *
     * @param string $access_token
     * @return object
     */
    public function getIncome(string $access_token): object
    {
        return $this->doRequest(
            $this->buildRequest("post", "income/get", $this->clientCredentials(["access_token" => $access_token]))
        );
    }
}