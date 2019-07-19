<?php

namespace TomorrowIdeas\Plaid\Tests;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 */
class IdentityTest extends TestCase
{
    public function test_get_identity()
    {
        $response = $this->getPlaidClient()->getIdentity("access_token");

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("Plaid-Version: 2019-05-29", $response->version);
        $this->assertEquals("Content-Type: application/json", $response->content);
        $this->assertEquals("/identity/get", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
        $this->assertEquals("access_token", $response->params->access_token);
    }
}