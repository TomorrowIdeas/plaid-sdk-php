<?php

namespace TomorrowIdeas\Plaid\Tests;

use DateTime;
use TomorrowIdeas\Plaid\Entities\PaymentSchedule;

/**
 * @covers TomorrowIdeas\Plaid\Entities\PaymentSchedule
 */
class PaymentScheduleEntityTest extends TestCase
{
	public function test_get_properties(): void
	{
		$payment_schedule = new PaymentSchedule(
			PaymentSchedule::INTERVAL_MONTHLY,
			15,
			new DateTime("2020-10-01")
		);

		$this->assertEquals(
			"MONTHLY",
			$payment_schedule->getInterval()
		);

		$this->assertEquals(15, $payment_schedule->getIntervalExecutionDay());

		$this->assertEquals(
			"2020-10-01",
			$payment_schedule->getStartDate()->format("Y-m-d")
		);
	}
}