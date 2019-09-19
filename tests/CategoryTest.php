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
        $this->assertEquals("2019-05-29", $response->version);
        $this->assertEquals("application/json", $response->content);
        $this->assertEquals("/categories/get", $response->path);
    }
}