<?php

namespace TomorrowIdeas\Plaid\Tests;

use Capsule\Request;
use Capsule\Response;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Shuttle\Handler\MockHandler;
use Shuttle\Shuttle;
use TomorrowIdeas\Plaid\Plaid;

abstract class TestCase extends PHPUnitTestCase
{
	protected function getPlaidClient(string $environment = "production"): Plaid
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

					return new Response(200, \json_encode($requestParams));

				}
			])
		]);

		$plaid = new Plaid("client_id", "secret", $environment);
		$plaid->setHttpClient($httpClient);

		return $plaid;
	}
}