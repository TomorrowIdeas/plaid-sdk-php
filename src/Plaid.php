<?php

namespace TomorrowIdeas\Plaid;

use Capsule\Request;
use Capsule\Response;
use DateTime;
use Psr\Http\Client\ClientInterface;
use Shuttle\Shuttle;

final class Plaid
{
    /**
     * Plaid API host environment.
     *
     * @var string
     */
    private $environment = "production";

    /**
     * Plaid API version.
     *
     * @var string
     */
    private $version = "2018-05-22";

    /**
     * Plaid API environments and matching hostname.
     *
     * @var array<string, string>
     */
    private $plaidEnvironments = [
        "production" => "https://production.plaid.com/",
        "development" => "https://development.plaid.com/",
        "sandbox" => "https://sandbox.plaid.com/",
    ];

    /**
     * Plaid API versions.
     *
     * @var array<string>
     */
    private $plaidVersions = [
        "2017-03-08",
        "2018-05-22",
        "2019-05-29",
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
     * @param string $version
     */
    public function __construct(string $client_id, string $secret, string $public_key, string $environment = "production", string $version = "2018-05-22")
    {
        $this->client_id = $client_id;
        $this->secret = $secret;
        $this->public_key = $public_key;

        $this->setEnvironment($environment);
        $this->setVersion($version);
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
        if( !\array_key_exists($environment, $this->plaidEnvironments) ){
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
     * Set the Plaid API version to use.
     *
     * Possible values: "2017-03-08", "2018-05-22", "2019-05-29"
     *
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        if( !\in_array($version, $this->plaidVersions) ){
            throw new PlaidException("Unknown or unsupported version \"{$version}\".");
        }

        $this->version = $version;
    }

    /**
     * Get the current Plaid version.
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Get the specific environment host name.
     *
     * @param string $environment
     * @return string|null
     */
    private function getHostname(string $environment): ?string
    {
        return $this->plaidEnvironments[$environment] ?? null;
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
                "Plaid-Version" => $this->version,
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
		$params = [
			"access_token" => $access_token,
			"options" => (object) $options
		];

        return $this->doRequest(
            $this->buildRequest("post", "auth/get", $this->clientCredentials($params))
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
		$params = [
			"access_token" => $access_token
		];

        return $this->doRequest(
            $this->buildRequest("post", "item/get", $this->clientCredentials($params))
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
		$params = [
			"access_token" => $access_token
		];

        return $this->doRequest(
            $this->buildRequest("post", "item/remove", $this->clientCredentials($params))
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
		$params = [
			"access_token" => $access_token
		];

        return $this->doRequest(
            $this->buildRequest("post", "item/public_token/create", $this->clientCredentials($params))
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
		$params = [
			"public_token" => $public_token
		];

        return $this->doRequest(
            $this->buildRequest("post", "item/public_token/exchange", $this->clientCredentials($params))
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
		$params = [
			"access_token" => $access_token
		];

        return $this->doRequest(
            $this->buildRequest("post", "item/access_token/invalidate", $this->clientCredentials($params))
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
		$params = [
			"access_token" => $access_token,
			"webhook" => $webhook
		];

        return $this->doRequest(
            $this->buildRequest("post", "item/webhook/update", $this->clientCredentials($params))
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
		$params = [
			"access_token" => $access_token
		];

        return $this->doRequest(
            $this->buildRequest("post", "accounts/get", $this->clientCredentials($params))
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
            "options" => (object) $options
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
            "options" => (object) $options
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
            "options" => (object) $options
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
            "options" => (object) $options
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
		$params = [
			"access_token" => $access_token,
			"options" => (object) $options
		];

        return $this->doRequest(
            $this->buildRequest("post", "accounts/balance/get", $this->clientCredentials($params))
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
		$params = [
			"access_token" => $access_token
		];

        return $this->doRequest(
            $this->buildRequest("post", "identity/get", $this->clientCredentials($params))
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
		$params = [
			"access_token" => $access_token
		];

        return $this->doRequest(
            $this->buildRequest("post", "income/get", $this->clientCredentials($params))
        );
	}

	/**
	 * Create an Asset Report.
	 *
	 * @param array<string> $access_tokens
	 * @param integer $days_requested
	 * @param array<string, string> $options
	 * @return object
	 */
	public function createAssetReport(array $access_tokens, int $days_requested, array $options = []): object
	{
		$params = [
			'access_tokens' => $access_tokens,
			'days_requested' => $days_requested,
			'options' => (object) $options
		];

		return $this->doRequest(
			$this->buildRequest("post", "asset_report/create", $this->clientCredentials($params))
		);
	}

	/**
	 * Refresh an Asset Report.
	 *
	 * @param string $asset_report_token
	 * @param integer $days_requested
	 * @param array<string, string> $options
	 * @return object
	 */
	public function refreshAssetReport(string $asset_report_token, int $days_requested, array $options = []): object
	{
		$params = [
			'asset_report_token' => $asset_report_token,
			'days_requested' => $days_requested,
			'options' => (object) $options
		];

		return $this->doRequest(
			$this->buildRequest("post", "asset_report/refresh", $this->clientCredentials($params))
		);
	}

	/**
	 * Filter an Asset Report by specifying which Accounts to exclude.
	 *
	 * @param string $asset_report_token
	 * @param array<string> $exclude_accounts
	 * @return object
	 */
	public function filterAssetReport(string $asset_report_token, array $exclude_accounts): object
	{
		$params = [
			'asset_report_token' => $asset_report_token,
			'account_ids_to_exclude' => $exclude_accounts
		];

		return $this->doRequest(
			$this->buildRequest("post", "asset_report/filter", $this->clientCredentials($params))
		);
	}

	/**
	 * Get an Asset report.
	 *
	 * @param string $asset_report_token
	 * @param boolean $include_insights
	 * @return object
	 */
	public function getAssetReport(string $asset_report_token, bool $include_insights = false): object
	{
		$params = [
			"asset_report_token" => $asset_report_token,
			"include_insights" => $include_insights
		];

		return $this->doRequest(
			$this->buildRequest("post", "asset_report/get", $this->clientCredentials($params))
		);
	}

	/**
	 * Get an Asset report in PDF format.
	 *
	 * @param string $report_token
	 * @param boolean $include_insights
	 * @return Response
	 */
	public function getAssetReportPdf(string $asset_report_token, bool $include_insights = false): Response
	{
		$params = [
			"asset_report_token" => $asset_report_token,
			"include_insights" => $include_insights
		];

		$response = $this->getHttpClient()->sendRequest(
			$this->buildRequest("post", "asset_report/pdf/get", $this->clientCredentials($params))
		);

        if( $response->getStatusCode() < 200 || $response->getStatusCode() >= 300 ){
            throw new PlaidRequestException($response);
		}

        return $response;
	}

	/**
	 * Remove an Asset Report.
	 *
	 * @param string $asset_report_token
	 * @return object
	 */
	public function removeAssetReport(string $asset_report_token): object
	{
		$params = [
			"asset_report_token" => $asset_report_token
		];

		return $this->doRequest(
			$this->buildRequest("post", "asset_report/remove", $this->clientCredentials($params))
		);
	}

	/**
	 * Create an Audit Copy of an Asset Report.
	 *
	 * @param string $asset_report_token
	 * @param string $auditor_id
	 * @return object
	 */
	public function createAssetReportAuditCopy(string $asset_report_token, string $auditor_id): object
	{
		$params = [
			"asset_report_token" => $asset_report_token,
			"auditor_id" => $auditor_id
		];

		return $this->doRequest(
			$this->buildRequest("post", "asset_report/audit_copy/create", $this->clientCredentials($params))
		);
	}

	/**
	 * Remove an Audit Copy.
	 *
	 * @param string $audit_copy_token
	 * @return object
	 */
	public function removeAssetReportAuditCopy(string $audit_copy_token): object
	{
		$params = [
			"audit_copy_token" => $audit_copy_token
		];

		return $this->doRequest(
			$this->buildRequest("post", "asset_report/audit_copy/remove", $this->clientCredentials($params))
		);
	}
}