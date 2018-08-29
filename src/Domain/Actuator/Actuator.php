<?php

namespace App\Domain\Actuator;

use App\Command\Command;
use App\Command\CreateActuator;
use App\Domain\Actuator\State\State;
use App\Domain\Actuator\State\TurnedOffEvent;
use App\Domain\Actuator\State\TurnedOnEvent;
use App\Domain\Actuator\Type\Type;
use App\Domain\Actuator\Type\TypeChangedEvent;
use App\Domain\Event;
use App\Domain\EventsStream;

class Actuator
{
    /**
     * @var \ArrayObject
     */
    private $raisedEvents;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name = "";

    /**
     * @var State
     */
    private $state;

    /**
     * @var Type
     */
    private $type;

    /**
     * @var \ArrayObject
     */
    private $handledCommands;

    /**
     * @var \ArrayObject|Event[]
     */
    private $applicableEvents;

    /**
     * @var int
     */
    protected $version = 0;

    public function __construct()
    {
        $this->handledCommands = new \ArrayObject();
        $this->raisedEvents = new \ArrayObject();
        $this->applicableEvents = new \ArrayObject();
    }

    public function handle(Command $command)
    {
        $this->initCommandHandlers();
        $commandType = get_class($command);
        if ($this->handledCommands->offsetExists($commandType)) {
            $this->handledCommands->offsetGet($commandType)($command);
        }
    }

    private function raiseEvent(Event $event): void
    {
        $this->raisedEvents->append($event);
    }

    private function rename(string $newName): void
    {
        $this->name = $newName;
        $this->version++;
        $this->raiseEvent(new NameChangedEvent($this->id, $this->version, $newName));
    }

    private function changeType(string $type): void
    {
        $this->type = new Type($type);
        $this->version++;
        $this->raiseEvent(new TypeChangedEvent($this->id, $this->version, $type));
    }

    private function init(string $uuid) {
        $this->id = $uuid;
        $this->version++;
        $this->raiseEvent(new CreatedEvent($uuid));
    }

    private function handleCreateActuator(): \Closure
    {
        return function (CreateActuator $createActuatorCommand): void {
            $this->init($createActuatorCommand->uuid());
            $this->rename($createActuatorCommand->name());
            $this->changeType($createActuatorCommand->type());
        };
    }

    public function raisedEvents(): \ArrayObject
    {
        return $this->raisedEvents;
    }

    public static function fromEventsStream(EventsStream $stream)
    {
        $obj = new static();
        $obj->initEventHandlers();
        foreach ($stream as $event) {
            $eventType = get_class($event);
            if ($obj->isEventApplicable($eventType)) {
                $obj->applicableEvents->offsetGet($eventType)($event);
            }
        }
        $obj->raisedEvents = new \ArrayObject();
        return $obj;
    }

    private function applyActuatorCreated(): \Closure
    {
        return function(CreatedEvent $createdEvent) {
            $this->init($createdEvent->aggregateId());
        };
    }

    private function applyActuatorRenamed(): \Closure
    {
        return function(NameChangedEvent $renamedEvent) {
            $this->rename($renamedEvent->newName());
        };
    }

    private function applyActuatorTurnedOn(): \Closure
    {
        return function() {
            $this->state->turnOn();
        };
    }

    private function applyActuatorTurnedOff(): \Closure
    {
        return function() {
            $this->state->turnOff();
        };
    }

    private function applyActuatorTypeChanged(): \Closure
    {
        return function(TypeChangedEvent $typeChangedEvent) {
            $this->changeType($typeChangedEvent->newTypeName());
        };
    }

    private function isEventApplicable(string $eventType): bool
    {
        return $this->applicableEvents->offsetExists($eventType);
    }

    private function initEventHandlers(): void
    {
        $this->applicableEvents->offsetSet(CreatedEvent::class, $this->applyActuatorCreated());
        $this->applicableEvents->offsetSet(NameChangedEvent::class, $this->applyActuatorRenamed());
        $this->applicableEvents->offsetSet(TypeChangedEvent::class, $this->applyActuatorTypeChanged());
        $this->applicableEvents->offsetSet(TurnedOnEvent::class, $this->applyActuatorTurnedOn());
        $this->applicableEvents->offsetSet(TurnedOffEvent::class, $this->applyActuatorTurnedOff());
    }

    private function initCommandHandlers(): void
    {
        $this->handledCommands->offsetSet(CreateActuator::class, $this->handleCreateActuator());
    }
}