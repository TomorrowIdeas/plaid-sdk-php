<?php

namespace TomorrowIdeas\Plaid\Entities;

use DateTime;
use InvalidArgumentException;

class PaymentSchedule
{
	const INTERVAL_WEEKLY = "WEEKLY";
	const INTERVAL_MONTHLY = "MONTHLY";

	/**
	 * Payment schedule interval.
	 *
	 * @var string
	 */
	protected $interval;

	/**
	 * Payment schedule execution day.
	 *
	 * @var int
	 */
	protected $interval_execution_day;

	/**
	 * Start date of scheduled payments.
	 *
	 * @var DateTime
	 */
	protected $start_date;

	public function __construct(
		string $interval,
		int $interval_execution_day,
		DateTime $start_date)
	{
		if( !\in_array($interval, [self::INTERVAL_MONTHLY, self::INTERVAL_WEEKLY]) ){
			throw new InvalidArgumentException("Interval must be WEEKLY or MONTHLY.");
		}

		$this->interval = $interval;
		$this->interval_execution_day = $interval_execution_day;
		$this->start_date = $start_date;
	}

	/**
	 * Get the payment schedule interval.
	 *
	 * @return string
	 */
	public function getInterval(): string
	{
		return $this->interval;
	}

	/**
	 * Get the interval execution day.
	 *
	 * @return integer
	 */
	public function getIntervalExecutionDay(): int
	{
		return $this->interval_execution_day;
	}

	/**
	 * Get the start date of the scheduled payment.
	 *
	 * @return DateTime
	 */
	public function getStartDate(): DateTime
	{
		return $this->start_date;
	}
}