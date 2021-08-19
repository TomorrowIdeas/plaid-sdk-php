<?php
namespace TomorrowIdeas\Plaid\Exceptions;

use Psr\Http\Message\ResponseInterface;

class Handler
{
	/**
	 * List of mapped exceptions and their corresponding error types.
	 *
	 * @var array
	 */
	protected $exceptionsByErrorType = [
		'ITEM_ERROR' => 'ItemError',
		'INSTITUTION_ERROR' => 'InstitutionError',
		'API_ERROR' => 'ServerError',
		'ASSET_REPORT_ERROR' => 'AssetError',
		'PAYMENT_ERROR' => 'PaymentError',
		'BANK_TRANSFER_ERROR' => 'BankTransferError',
		'DEPOSIT_SWITCH_ERROR' => 'DepositSwitchError',
		'INCOME_VERIFICATION_ERROR' => 'IncomeError',
		'SANDBOX_ERROR' => 'SandboxError',
		'INVALID_REQUEST' => 'InvalidRequestError',
		'INVALID_INPUT' => 'InvalidInputError',
		'INVALID_RESULT' => 'InvalidResultError',
		'RATE_LIMIT_EXCEEDED' => 'RateLimitExceededError',
		'RECAPTCHA_ERROR' => 'RecaptchaError',
		'OAUTH_ERROR' => 'OAuthError',
	];

    /**
     * Constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return void
     * @throws \TomorrowIdeas\Plaid\Exceptions\PlaidException
     */
    public function __construct(ResponseInterface $responseInterface)
    {
        $headers = $responseInterface->getHeaders();

        $statusCode = $responseInterface->getStatusCode();

		$response = \json_decode($responseInterface->getBody()->getContents());

        $errorCode = $response->error_code ?? null;

        $errorType = $response->error_type ?? null;

        $message = $response->display_message ?? $response->error_message ?? $responseInterface->getReasonPhrase();

        $this->handleException($message, $headers, $statusCode, $errorType, $errorCode);
    }

    /**
     * Guesses the FQN of the exception to be thrown.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @param  string  $errorType
     * @param  string  $errorCode
     *
     * @return void
     * @throws \TomorrowIdeas\Plaid\Exceptions\PlaidException
     */
    protected function handleException($message, $headers, $statusCode, $errorType, $errorCode)
    {
		if (array_key_exists($errorType, $this->exceptionsByErrorType)) {
			$class = $this->exceptionsByErrorType[$errorType];
		} else {
			$class = 'Plaid';
		}

		$class = "\\TomorrowIdeas\\Plaid\\Exceptions\\{$class}Exception";

		$instance = new $class($message, $statusCode);

        $instance->setHeaders($headers);
        $instance->setErrorCode($errorCode);
        $instance->setErrorType($errorType);

        throw $instance;
    }
}
