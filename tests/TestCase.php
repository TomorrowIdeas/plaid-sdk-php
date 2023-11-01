<?php

namespace TomorrowIdeas\Plaid\Tests;

use Nimbly\Capsule\Request;
use Nimbly\Capsule\Response;
use Nimbly\Shuttle\Handler\MockHandler;
use Nimbly\Shuttle\Shuttle;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use TomorrowIdeas\Plaid\Plaid;

abstract class TestCase extends PHPUnitTestCase
{
	protected function getPlaidClient(string $environment = "production"): Plaid
	{
		$httpClient = new Shuttle(
			new MockHandler([
				function (Request $request) {
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
		);

		$plaid = new Plaid("client_id", "secret", $environment);
		$plaid->setHttpClient($httpClient);

		return $plaid;
	}
}