<?php

namespace TomorrowIdeas\Plaid\Tests;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 */
class AssetReportTest extends TestCase
{
	public function test_create_asset_report()
	{
		$response = $this->getPlaidClient()->createAssetReport(["access_token1", "access_token2"], 30);

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("Plaid-Version: 2018-05-22", $response->version);
        $this->assertEquals("Content-Type: application/json", $response->content);
        $this->assertEquals("/asset_report/create", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
		$this->assertEquals(["access_token1", "access_token2"], $response->params->access_tokens);
		$this->assertEquals(30, $response->params->days_requested);
        $this->assertEquals(new \StdClass, $response->params->options);
	}

	public function test_refresh_asset_report()
	{
		$response = $this->getPlaidClient()->refreshAssetReport('asset_report_token', 30);

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("Plaid-Version: 2018-05-22", $response->version);
        $this->assertEquals("Content-Type: application/json", $response->content);
        $this->assertEquals("/asset_report/refresh", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("asset_report_token", $response->params->asset_report_token);
		$this->assertEquals(30, $response->params->days_requested);
        $this->assertEquals(new \StdClass, $response->params->options);
	}

	public function test_filter_asset_report()
	{
		$response = $this->getPlaidClient()->filterAssetReport('asset_report_token', ['account1', 'account2']);

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("Plaid-Version: 2018-05-22", $response->version);
        $this->assertEquals("Content-Type: application/json", $response->content);
        $this->assertEquals("/asset_report/filter", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("asset_report_token", $response->params->asset_report_token);
		$this->assertEquals(['account1', 'account2'], $response->params->account_ids_to_exclude);
	}

	public function test_get_asset_report()
	{
		$response = $this->getPlaidClient()->getAssetReport('asset_report_token', true);

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("Plaid-Version: 2018-05-22", $response->version);
        $this->assertEquals("Content-Type: application/json", $response->content);
        $this->assertEquals("/asset_report/get", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("asset_report_token", $response->params->asset_report_token);
		$this->assertEquals(true, $response->params->include_insights);
	}

	public function test_get_asset_report_pdf()
	{
		$response = $this->getPlaidClient()->getAssetReportPdf('asset_report_token', true);

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("Plaid-Version: 2018-05-22", $response->version);
        $this->assertEquals("Content-Type: application/json", $response->content);
        $this->assertEquals("/asset_report/pdf/get", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("asset_report_token", $response->params->asset_report_token);
		$this->assertEquals(true, $response->params->include_insights);
	}

	public function test_remove_asset_report()
	{
		$response = $this->getPlaidClient()->removeAssetReport('asset_report_token');

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("Plaid-Version: 2018-05-22", $response->version);
        $this->assertEquals("Content-Type: application/json", $response->content);
        $this->assertEquals("/asset_report/remove", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("asset_report_token", $response->params->asset_report_token);
	}

	public function test_create_asset_report_audit_copy()
	{
		$response = $this->getPlaidClient()->createAssetReportAuditCopy('asset_report_token', 'auditor_id');

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("Plaid-Version: 2018-05-22", $response->version);
        $this->assertEquals("Content-Type: application/json", $response->content);
        $this->assertEquals("/asset_report/audit_copy/create", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("asset_report_token", $response->params->asset_report_token);
		$this->assertEquals("auditor_id", $response->params->auditor_id);
	}

	public function test_remove_asset_report_audit_copy()
	{
		$response = $this->getPlaidClient()->removeAssetReportAuditCopy('audit_copy_token');

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("Plaid-Version: 2018-05-22", $response->version);
        $this->assertEquals("Content-Type: application/json", $response->content);
        $this->assertEquals("/asset_report/audit_copy/remove", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("audit_copy_token", $response->params->audit_copy_token);
	}
}