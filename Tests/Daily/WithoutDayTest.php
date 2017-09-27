<?php


namespace Uruloke\LaraCalendar\Test\Daily;


use Uruloke\LaraCalendar\Carbon;
use Uruloke\LaraCalendar\EventBuilder;
use Uruloke\LaraCalendar\Test\TestCase;

class WithoutDayTest extends TestCase
{
	/** @test */
	public function can_remove_specific_day()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->startsAt(Carbon::parse("2017-09-05 08:00"));
		$builder->endsAt(Carbon::parse("2017-09-05 18:00"));
		$builder->allWeekDays();
		$builder->withoutDay(Carbon::parse("2017-09-07"));


		// Act
		$events = $builder->getNextEvents(3);

		// Assert
		$this->assertTrue($events->first()->startsAt()->isSameDay(Carbon::parse("2017-09-05")));
		$this->assertTrue($events->get(1)->startsAt()->isSameDay(Carbon::parse("2017-09-06")));
		$this->assertTrue($events->get(2)->startsAt()->isSameDay(Carbon::parse("2017-09-08")));
	}
}