<?php

namespace TomorrowIdeas\Plaid\Tests;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 */
class CategoryTest extends TestCase
{
    public function test_get_identity()
    {
        $response = $this->getPlaidClient()->getCategories();

        $this->assertEquals("POST", $response->method);
        $this->assertEquals("Plaid-Version: 2018-05-22", $response->version);
        $this->assertEquals("Content-Type: application/json", $response->content);
        $this->assertEquals("/categories/get", $response->path);
    }
}