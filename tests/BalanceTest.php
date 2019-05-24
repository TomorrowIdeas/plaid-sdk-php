<?php

namespace TomorrowIdeas\Plaid\Tests;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 */
class BalanceTest extends TestCase
{
    public function test_get_balance()
    {
        $response = $this->getPlaidClient()->getBalance("access_token");

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("Plaid-Version: 2018-05-22", $response->version);
        $this->assertEquals("Content-Type: application/json", $response->content);
        $this->assertEquals("/accounts/balance/get", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
        $this->assertEquals("access_token", $response->params->access_token);
        $this->assertEquals([], $response->params->options);
    }
}