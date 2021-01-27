<?php

namespace TomorrowIdeas\Plaid\Resources;

use Psr\Http\Message\ResponseInterface;

class Reports extends AbstractResource
{
	/**
	 * Create an Asset Report.
	 *
	 * @param array<string> $access_tokens
	 * @param integer $days_requested
	 * @param array<string,string> $options
	 * @return object
	 */
	public function createAssetReport(array $access_tokens, int $days_requested, array $options = []): object
	{
		$params = [
			"access_tokens" => $access_tokens,
			"days_requested" => $days_requested,
			"options" => (object) $options
		];

		return $this->sendRequest(
			"post",
			"asset_report/create",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Refresh an Asset Report.
	 *
	 * @param string $asset_report_token
	 * @param integer $days_requested
	 * @param array<string,string> $options
	 * @return object
	 */
	public function refreshAssetReport(string $asset_report_token, int $days_requested, array $options = []): object
	{
		$params = [
			"asset_report_token" => $asset_report_token,
			"days_requested" => $days_requested,
			"options" => (object) $options
		];

		return $this->sendRequest(
			"post",
			"asset_report/refresh",
			$this->paramsWithClientCredentials($params)
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
			"asset_report_token" => $asset_report_token,
			"account_ids_to_exclude" => $exclude_accounts
		];

		return $this->sendRequest(
			"post",
			"asset_report/filter",
			$this->paramsWithClientCredentials($params)
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

		return $this->sendRequest(
			"post",
			"asset_report/get",
			$this->paramsWithClientCredentials($params)
		);
	}

	/**
	 * Get an Asset report in PDF format.
	 *
	 * @param string $report_token
	 * @return ResponseInterface
	 */
	public function getAssetReportPdf(string $asset_report_token): ResponseInterface
	{
		$params = [
			"asset_report_token" => $asset_report_token
		];

		return $this->sendRequestRawResponse(
			"post",
			"asset_report/pdf/get",
			$this->paramsWithClientCredentials($params)
		);
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

		return $this->sendRequest(
			"post",
			"asset_report/remove",
			$this->paramsWithClientCredentials($params)
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

		return $this->sendRequest(
			"post",
			"asset_report/audit_copy/create",
			$this->paramsWithClientCredentials($params)
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

		return $this->sendRequest(
			"post",
			"asset_report/audit_copy/remove",
			$this->paramsWithClientCredentials($params)
		);
	}
}