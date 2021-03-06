<?php

namespace Uruloke\LaraCalender\Test;

use Carbon\Carbon;
use EventCollection;
use Illuminate\Database\Eloquent\Model;
use Uruloke\LaraCalendar\Contracts\Eventable;
use Uruloke\LaraCalendar\Days\Tuesday;
use Uruloke\LaraCalendar\EventBuilder;
use Uruloke\LaraCalendar\Models\Event;
use Uruloke\LaraCalendar\Models\HasEvent;
use Uruloke\LaraCalendar\Test\TestCase;

class CustomEvent extends TestCase
{

	/** @test */
	public function buildSimpleWeeklyRecurEvent ()
	{
		// Arrange
		$builder = new EventBuilder();
		$builder->setEvent(EventWithData::class);
		$builder->title('02332 - Forelæsning');
		$builder->place('Building 306, DTU');
		$builder->description('Rum: 033');
		$builder->startsAt(Carbon::parse("2017-09-05 08:00"));
		$builder->endsAt(Carbon::parse("2017-09-05 18:00"));
		$builder->weekly(Tuesday::class);

		// Act
		/** @var EventWithData|Model $event */
		$event = $builder->getNextEvent();

		// Assert
		$this->assertInstanceOf(EventWithData::class, $event);
		$this->assertEquals($event->startsAt(), Carbon::parse('2017-09-05 08:00'));
		$this->assertEquals($event->endsAt(), Carbon::parse('2017-09-05 18:00'));
		$this->assertArraySubset([
			'title' => '02332 - Forelæsning',
			'place' => 'Building 306, DTU',
			'description' => 'Rum: 033'
		], $event->getAttributes());

	}


}


class EventWithData extends Model implements Eventable {
	use HasEvent;

	protected static $properties = [
		'title',
		'place',
		'description'
	];
}


