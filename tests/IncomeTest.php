<?php

namespace TomorrowIdeas\Plaid\Tests;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 */
class IncomeTest extends TestCase
{
    public function test_get_identity()
    {
        $response = $this->getPlaidClient()->getIncome("access_token");

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("2019-05-29", $response->version);
        $this->assertEquals("application/json", $response->content);
        $this->assertEquals("/income/get", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
        $this->assertEquals("access_token", $response->params->access_token);
    }
}