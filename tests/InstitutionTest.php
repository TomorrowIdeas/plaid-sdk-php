<?php

namespace TomorrowIdeas\Plaid\Tests;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 */
class InstitutionTest extends TestCase
{
    public function test_get_institutions()
    {
        $response = $this->getPlaidClient()->getInstitutions(100, 200);

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("Plaid-Version: 2019-05-29", $response->version);
        $this->assertEquals("Content-Type: application/json", $response->content);
        $this->assertEquals("/institutions/get", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
        $this->assertEquals(100, $response->params->count);
        $this->assertEquals(200, $response->params->offset);
        $this->assertEquals(new \StdClass, $response->params->options);
    }

    public function test_get_institution()
    {
        $response = $this->getPlaidClient()->getInstitution("ins_12345");

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("Plaid-Version: 2019-05-29", $response->version);
        $this->assertEquals("Content-Type: application/json", $response->content);
        $this->assertEquals("/institutions/get_by_id", $response->path);
        $this->assertEquals("public_key", $response->params->public_key);
        $this->assertEquals("ins_12345", $response->params->institution_id);
        $this->assertEquals(new \StdClass, $response->params->options);
    }

    public function test_find_institution()
    {
        $response = $this->getPlaidClient()->findInstitution("boeing", ["transactions", "mfa"]);

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("Plaid-Version: 2019-05-29", $response->version);
        $this->assertEquals("Content-Type: application/json", $response->content);
        $this->assertEquals("/institutions/search", $response->path);
        $this->assertEquals("public_key", $response->params->public_key);
        $this->assertEquals("boeing", $response->params->query);
        $this->assertEquals(["transactions", "mfa"], $response->params->products);
        $this->assertEquals(new \StdClass, $response->params->options);
    }
}