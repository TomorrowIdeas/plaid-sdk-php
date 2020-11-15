<?php

namespace TomorrowIdeas\Plaid\Tests;

/**
 * @covers \TomorrowIdeas\Plaid\Plaid
 * @covers \TomorrowIdeas\Plaid\Resources\AbstractResource
 * @covers TomorrowIdeas\Plaid\Resources\Categories
 */
class CategoriesTest extends TestCase
{
	public function test_get_identity(): void
	{
		$response = $this->getPlaidClient()->categories->getCategories();

		$this->assertEquals("POST", $response->method);
		$this->assertEquals("2020-09-14", $response->version);
		$this->assertEquals("application/json", $response->content);
		$this->assertEquals("/categories/get", $response->path);
	}
}