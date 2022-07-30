<?php

namespace TomorrowIdeas\Plaid\Entities;

use DateTime;
use InvalidArgumentException;
use JsonSerializable;

class PaymentSchedule implements JsonSerializable
{
	const INTERVAL_WEEKLY = "WEEKLY";
	const INTERVAL_MONTHLY = "MONTHLY";

	/**
	 * @param string $interval You can use the class constants PaymentSchedule::WEEKLY and PaymentScheduler::MONTHLY. implements JsonSerializable
	 * @param integer $interval_execution_day
	 * @param DateTime $start_date
	 * @throws InvalidArgumentException
	 */
	public function __construct(
		protected string $interval,
		protected int $interval_execution_day,
		protected DateTime $start_date)
	{
		if( !\in_array($interval, [self::INTERVAL_MONTHLY, self::INTERVAL_WEEKLY]) ){
			throw new InvalidArgumentException("Interval must be \"WEEKLY\" or \"MONTHLY\".");
		}
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

	public function jsonSerialize(): mixed
	{
		return [];
	}
}