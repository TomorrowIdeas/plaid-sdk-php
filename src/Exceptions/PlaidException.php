<?php

namespace TomorrowIdeas\Plaid\Exceptions;

use Exception;

class PlaidException extends Exception
{
	/**
	 * The response headers sent by Stripe.
	 *
	 * @var array
	 */
	protected $headers = [];

	/**
	 * The error code returned by Stripe.
	 *
	 * @var string
	 */
	protected $errorCode;

	/**
	 * The error type returned by Stripe.
	 *
	 * @var string
	 */
	protected $errorType;


	/**
	 * Returns the response headers sent by Stripe.
	 *
	 * @return array
	 */
	public function getHeaders()
	{
		return $this->headers;
	}

	/**
	 * Sets the response headers sent by Stripe.
	 *
	 * @param  array  $headers
	 *
	 * @return $this
	 */
	public function setHeaders(array $headers)
	{
		$this->headers = $headers;

		return $this;
	}

	/**
	 * Returns the error type returned by Stripe.
	 *
	 * @return string
	 */
	public function getErrorCode()
	{
		return $this->errorCode;
	}

	/**
	 * Sets the error type returned by Stripe.
	 *
	 * @param  string  $errorCode
	 *
	 * @return $this
	 */
	public function setErrorCode($errorCode)
	{
		$this->errorCode = $errorCode;

		return $this;
	}

	/**
	 * Returns the error type returned by Stripe.
	 *
	 * @return string
	 */
	public function getErrorType()
	{
		return $this->errorType;
	}

	/**
	 * Sets the error type returned by Stripe.
	 *
	 * @param  string  $errorType
	 *
	 * @return $this
	 */
	public function setErrorType($errorType)
	{
		$this->errorType = $errorType;

		return $this;
	}
}
