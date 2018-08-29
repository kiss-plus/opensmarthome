<?php

use App\Command\CreateActuator;
use App\Entity\Actuator;
use App\Entity\ActuatorRenamedEvent;
use App\Entity\Type;

class ActuatorTest extends \Codeception\Test\Unit
{

    public function testFromEventsStream()
    {
        $actuatorUuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $createEvent = new \App\Entity\ActuatorCreatedEvent(1, $actuatorUuid);
        $newName = 'some new name';
        $renameEvent = new ActuatorRenamedEvent(2, $newName);
        $stream = new \App\EventsStream();
        $stream->append($createEvent);
        $stream->append($renameEvent);
        $actuator = Actuator::fromEventsStream($stream);
        $this->assertAttributeEquals($actuatorUuid, 'id', $actuator);
        $this->assertAttributeEquals($newName, 'name', $actuator);
    }

    public function testHandle()
    {
        $actuator = new Actuator();
        $actuator->handle(
            new CreateActuator(Type::DIGITAL, 'sample actuator name', Ramsey\Uuid\Uuid::uuid4())
        );
        $events = $actuator->raisedEvents();
        $this->assertCount(4, $events);
        $this->assertInstanceOf(\App\Entity\ActuatorCreatedEvent::class, $events->offsetGet(0));
        $this->assertInstanceOf(\App\Entity\ActuatorNameChangedEvent::class, $events->offsetGet(1));
        $this->assertInstanceOf(\App\Entity\ActuatorTypeChangedEvent::class, $events->offsetGet(2));
        $this->assertInstanceOf(\App\Entity\ActuatorTurnedOffEvent::class, $events->offsetGet(3));
    }
}
