<?php

namespace App\Domain\Actuator;

use App\Domain\Event;

abstract class ActuatorEvent implements Event
{
    /**
     * @var string
     */
    private $aggregateId;

    public function __construct(string $id)
    {
        $this->aggregateId = $id;
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }
}