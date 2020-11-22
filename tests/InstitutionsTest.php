<?php

namespace TomorrowIdeas\Plaid\Tests;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 * @covers TomorrowIdeas\Plaid\Resources\AbstractResource
 * @covers TomorrowIdeas\Plaid\Resources\Institutions
 */
class InstitutionsTest extends TestCase
{
	public function test_get_institutions(): void
	{
		$response = $this->getPlaidClient()->institutions->getInstitutions(100, 200);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/institutions/get", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals(100, $response->params->count);
		$this->assertEquals(200, $response->params->offset);
		$this->assertEquals((object) [], $response->params->options);
	}

	public function test_get_institution(): void
	{
		$response = $this->getPlaidClient()->institutions->getInstitution("ins_12345");

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/institutions/get_by_id", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("ins_12345", $response->params->institution_id);
		$this->assertEquals((object) [], $response->params->options);
	}

	public function test_find_institution(): void
	{
		$response = $this->getPlaidClient()->institutions->findInstitution("boeing", ["US"], ["transactions", "mfa"]);

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/institutions/search", $response->path);
		$this->assertEquals("client_id", $response->params->client_id);
		$this->assertEquals("secret", $response->params->secret);
		$this->assertEquals("boeing", $response->params->query);
		$this->assertEquals(["US"], $response->params->country_codes);
		$this->assertEquals(["transactions", "mfa"], $response->params->products);
		$this->assertEquals((object) [], $response->params->options);
	}
}