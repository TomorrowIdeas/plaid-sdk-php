<?php

namespace TomorrowIdeas\Plaid\Tests;

use Capsule\Request;
use Capsule\Response;
use Capsule\ResponseStatus;
use Shuttle\Handler\MockHandler;
use Shuttle\Shuttle;
use TomorrowIdeas\Plaid\Plaid;
use TomorrowIdeas\Plaid\PlaidRequestException;
use UnexpectedValueException;

/**
 * @covers TomorrowIdeas\Plaid\Plaid
 * @covers TomorrowIdeas\Plaid\Resources\AbstractResource
 * @covers TomorrowIdeas\Plaid\Resources\Items
 * @covers TomorrowIdeas\Plaid\PlaidRequestException
 * @uses TomorrowIdeas\Plaid\PlaidException
 */
class AbstractResourceTest extends TestCase
{
	public function test_build_request_with_no_params_sends_empty_object_in_body(): void
	{
		$itemsResource = $this->getPlaidClient()->items;

		$reflectionClass = new \ReflectionClass($itemsResource);

        $method = $reflectionClass->getMethod("buildRequest");
		$method->setAccessible(true);

		$request = $method->invokeArgs($itemsResource, ["post", "/endpoint"]);

		$this->assertEquals(
			(object) [],
			\json_decode($request->getBody()->getContents())
		);
	}

	public function test_request_exception_passes_through_plaid_display_message(): void
	{
		$httpClient = new Shuttle([
			'handler' => new MockHandler([
				function(Request $request) {

					$requestParams = [
						"display_message" => "DISPLAY MESSAGE",
					];

					return new Response(300, \json_encode($requestParams));

				}
			])
		]);

		$plaid = new Plaid("client_id", "secret");
		$plaid->setHttpClient($httpClient);

		try {
			$plaid->items->get("access_token");
		}
		catch( PlaidRequestException $plaidRequestException ){

			$this->assertEquals("DISPLAY MESSAGE", $plaidRequestException->getMessage());

		}
	}

	public function test_request_exception_passes_through_http_status_code(): void
	{
		$httpClient = new Shuttle([
			'handler' => new MockHandler([
				function(Request $request) {

					$requestParams = [
						"display_message" => "DISPLAY MESSAGE",
					];

					return new Response(300, \json_encode($requestParams));

				}
			])
		]);

		$plaid = new Plaid("client_id", "secret");
		$plaid->setHttpClient($httpClient);

		try {
			$plaid->items->get("access_token");
		}
		catch( PlaidRequestException $plaidRequestException ){

			$this->assertEquals(300, $plaidRequestException->getCode());

		}
	}

	public function test_1xx_responses_throw_exception(): void
	{
		$httpClient = new Shuttle([
			'handler' => new MockHandler([
				function(Request $request) {

					$requestParams = [
						"method" => $request->getMethod(),
						"version" => $request->getHeaderLine("Plaid-Version"),
						"content" => $request->getHeaderLine("Content-Type"),
						"scheme" => $request->getUri()->getScheme(),
						"host" => $request->getUri()->getHost(),
						"path" => $request->getUri()->getPath(),
						"params" => \json_decode($request->getBody()->getContents()),
					];

					return new Response(100, \json_encode($requestParams));

				}
			])
		]);

		$plaid = new Plaid("client_id", "secret");
		$plaid->setHttpClient($httpClient);

		$this->expectException(PlaidRequestException::class);
		$plaid->items->get("access_token");
	}

	public function test_3xx_responses_and_above_throw_exception(): void
	{
		$httpClient = new Shuttle([
			'handler' => new MockHandler([
				function(Request $request) {

					$requestParams = [
						"display_message" => "PLAID_ERROR",
					];

					return new Response(300, \json_encode($requestParams));

				}
			])
		]);

		$plaid = new Plaid("client_id", "secret");
		$plaid->setHttpClient($httpClient);

		$this->expectException(PlaidRequestException::class);
		$plaid->items->get("access_token");
	}

	public function test_invalid_json_when_parsing_response(): void
	{
		$httpClient = new Shuttle([
			'handler' => new MockHandler([
				new Response(ResponseStatus::OK, "invalid_json")
			])
		]);

		$plaid = new Plaid("client_id", "secret");
		$plaid->setHttpClient($httpClient);

		$this->expectException(UnexpectedValueException::class);

		$plaid->items->get("access_token");
	}
}