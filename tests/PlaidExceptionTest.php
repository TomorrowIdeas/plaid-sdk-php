<?php

namespace TomorrowIdeas\Plaid\Tests;

use Capsule\Response;
use TomorrowIdeas\Plaid\Exceptions\BankTransferErrorException;
use TomorrowIdeas\Plaid\Exceptions\DepositSwitchErrorException;
use TomorrowIdeas\Plaid\Exceptions\Handler;
use TomorrowIdeas\Plaid\Exceptions\IncomeErrorException;
use TomorrowIdeas\Plaid\Exceptions\InstitutionErrorException;
use TomorrowIdeas\Plaid\Exceptions\InvalidInputErrorException;
use TomorrowIdeas\Plaid\Exceptions\InvalidRequestErrorException;
use TomorrowIdeas\Plaid\Exceptions\InvalidResultErrorException;
use TomorrowIdeas\Plaid\Exceptions\ItemErrorException;
use TomorrowIdeas\Plaid\Exceptions\OAuthErrorException;
use TomorrowIdeas\Plaid\Exceptions\PaymentErrorException;
use TomorrowIdeas\Plaid\Exceptions\PlaidException;
use TomorrowIdeas\Plaid\Exceptions\RateLimitExceededErrorException;
use TomorrowIdeas\Plaid\Exceptions\RecaptchaErrorException;
use TomorrowIdeas\Plaid\Exceptions\SandboxErrorException;
use TomorrowIdeas\Plaid\Exceptions\ServerErrorException;

/**
 * @covers \TomorrowIdeas\Plaid\Exceptions\PlaidException
 * @uses   \TomorrowIdeas\Plaid\Exceptions\PlaidException
 */
class PlaidExceptionTest extends TestCase
{
	public function test_getting_code_from_exception(): void
	{
		$this->expectException(PlaidException::class);
		$this->expectExceptionCode(404);

		$response = new Response(
			404,
			'{"display_message": "Foo not found"}'
		);

		new Handler($response);
	}

	public function test_getting_display_message_on_exception(): void
	{
		$this->expectException(PlaidException::class);
		$this->expectExceptionMessage("Foo not found");

		$response = new Response(
			404,
			'{"display_message": "Foo not found"}'
		);

		new Handler($response);
	}

	public function test_getting_fallback_message(): void
	{
		$this->expectException(PlaidException::class);
		$this->expectExceptionMessage("Not Found");

		$response = new Response(
			404,
			'{"error": "Foo not found"}'
		);

		new Handler($response);
	}

	public function test_getting_fallback_message_for_unknown_payload(): void
	{
		$this->expectException(PlaidException::class);
		$this->expectExceptionMessage("Not Found");

		$response = new Response(
			404,
			"Foo not found"
		);

		new Handler($response);
	}

	public function test_item_error_exception(): void
	{
		$this->expectException(ItemErrorException::class);

		$response = new Response(
			400,
			'{"error_type": "ITEM_ERROR", "error_code": "INSTANT_MATCH_FAILED"}'
		);

		new Handler($response);
	}

	public function test_institution_error_exception(): void
	{
		$this->expectException(InstitutionErrorException::class);

		$response = new Response(
			400,
			'{"error_type": "INSTITUTION_ERROR", "error_code": "INSTITUTION_DOWN"}'
		);

		new Handler($response);
	}

	public function test_server_error_exception(): void
	{
		$this->expectException(ServerErrorException::class);

		$response = new Response(
			500,
			'{"error_type": "API_ERROR", "error_code": "INTERNAL_SERVER_ERROR"}'
		);

		new Handler($response);
	}

	public function test_payment_error_exception(): void
	{
		$this->expectException(PaymentErrorException::class);

		$response = new Response(
			500,
			'{"error_type": "PAYMENT_ERROR", "error_code": "PAYMENT_BLOCKED"}'
		);

		new Handler($response);
	}

	public function test_bank_transfer_error_exception(): void
	{
		$this->expectException(BankTransferErrorException::class);

		$response = new Response(
			500,
			'{"error_type": "BANK_TRANSFER_ERROR", "error_code": "BANK_TRANSFER_LIMIT_EXCEEDED"}'
		);

		new Handler($response);
	}

	public function test_deposit_switch_error_exception(): void
	{
		$this->expectException(DepositSwitchErrorException::class);

		$response = new Response(
			500,
			'{"error_type": "DEPOSIT_SWITCH_ERROR", "error_code": "INVALID_DEPOSIT_SWITCH_ID"}'
		);

		new Handler($response);
	}

	public function test_income_error_exception(): void
	{
		$this->expectException(IncomeErrorException::class);

		$response = new Response(
			500,
			'{"error_type": "INCOME_VERIFICATION_ERROR", "error_code": "PRODUCT_NOT_ENABLED"}'
		);

		new Handler($response);
	}

	public function test_sandbox_error_exception(): void
	{
		$this->expectException(SandboxErrorException::class);

		$response = new Response(
			500,
			'{"error_type": "SANDBOX_ERROR", "error_code": "SANDBOX_PRODUCT_NOT_ENABLED"}'
		);

		new Handler($response);
	}

	public function test_invalid_request_error_exception(): void
	{
		$this->expectException(InvalidRequestErrorException::class);

		$response = new Response(
			500,
			'{"error_type": "INVALID_REQUEST", "error_code": "INCOMPATIBLE_API_VERSION"}'
		);

		new Handler($response);
	}

	public function test_invalid_input_error_exception(): void
	{
		$this->expectException(InvalidInputErrorException::class);

		$response = new Response(
			500,
			'{"error_type": "INVALID_INPUT", "error_code": "DIRECT_INTEGRATION_NOT_ENABLED"}'
		);

		new Handler($response);
	}

	public function test_invalid_result_error_exception(): void
	{
		$this->expectException(InvalidResultErrorException::class);

		$response = new Response(
			400,
			'{"error_type": "INVALID_RESULT", "error_code": "LAST_UPDATED_DATETIME_OUT_OF_RANGE"}'
		);

		new Handler($response);
	}

	public function test_rate_limit_execeeded_error_exception(): void
	{
		$this->expectException(RateLimitExceededErrorException::class);

		$response = new Response(
			429,
			'{"error_type": "RATE_LIMIT_EXCEEDED", "error_code": "ADDITION_LIMIT"}'
		);

		new Handler($response);
	}

	public function test_recaptcha_error_exception(): void
	{
		$this->expectException(RecaptchaErrorException::class);

		$response = new Response(
			400,
			'{"error_type": "RECAPTCHA_ERROR", "error_code": "RECAPTCHA_REQUIRED"}'
		);

		new Handler($response);
	}

	public function test_oauth_error_exception(): void
	{
		$this->expectException(OAuthErrorException::class);

		$response = new Response(
			400,
			'{"error_type": "OAUTH_ERROR", "error_code": "INCORRECT_OAUTH_NONCE"}'
		);

		new Handler($response);
	}
}