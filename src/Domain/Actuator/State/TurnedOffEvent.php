<?php
namespace App\Domain\Actuator\State;

use App\Domain\Actuator\ActuatorEvent;

class TurnedOffEvent extends ActuatorEvent
{
    public function __construct(string $id, int $version)
    {
        parent::__construct($id, $version);
    }
}
