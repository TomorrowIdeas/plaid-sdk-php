<?php

namespace TomorrowIdeas\Plaid\Tests;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 */
class ItemTest extends TestCase
{
    public function test_get_items()
    {
        $response = $this->getPlaidClient()->getItem("access_token");

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("2019-05-29", $response->version);
        $this->assertEquals("application/json", $response->content);
        $this->assertEquals("/item/get", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
        $this->assertEquals("access_token", $response->params->access_token);
    }

    public function test_remove_item()
    {
        $response = $this->getPlaidClient()->removeItem("access_token");

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("2019-05-29", $response->version);
        $this->assertEquals("application/json", $response->content);
        $this->assertEquals("/item/remove", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
        $this->assertEquals("access_token", $response->params->access_token);
    }

    public function test_create_public_token()
    {
        $response = $this->getPlaidClient()->createPublicToken("access_token");

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("2019-05-29", $response->version);
        $this->assertEquals("application/json", $response->content);
        $this->assertEquals("/item/public_token/create", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
        $this->assertEquals("access_token", $response->params->access_token);
    }

    public function test_exchange_token()
    {
        $response = $this->getPlaidClient()->exchangeToken("public_token");

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("2019-05-29", $response->version);
        $this->assertEquals("application/json", $response->content);
        $this->assertEquals("/item/public_token/exchange", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
        $this->assertEquals("public_token", $response->params->public_token);
    }

    public function test_rotate_access_token()
    {
        $response = $this->getPlaidClient()->rotateAccessToken("access_token");

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("2019-05-29", $response->version);
        $this->assertEquals("application/json", $response->content);
        $this->assertEquals("/item/access_token/invalidate", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
        $this->assertEquals("access_token", $response->params->access_token);
    }

    public function test_update_webhook()
    {
        $response = $this->getPlaidClient()->updateWebhook("access_token", "webhook_url");

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("2019-05-29", $response->version);
        $this->assertEquals("application/json", $response->content);
        $this->assertEquals("/item/webhook/update", $response->path);
        $this->assertEquals("client_id", $response->params->client_id);
        $this->assertEquals("secret", $response->params->secret);
        $this->assertEquals("access_token", $response->params->access_token);
        $this->assertEquals("webhook_url", $response->params->webhook);
    }
}