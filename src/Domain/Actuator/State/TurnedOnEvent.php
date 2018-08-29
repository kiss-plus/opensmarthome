<?php
namespace App\Domain\Actuator\State;

use App\Domain\Event;

class TurnedOnEvent implements Event
{
    /**
     * @var int
     */
    private $version;
    /**
     * @var string
     */
    private $actuatorId;

    public function __construct(string $actuatorId, int $version)
    {
        $this->version = $version;
        $this->actuatorId = $actuatorId;
    }

    public function version(): int
    {
        return $this->version;
    }

    public function aggregateId(): string
    {
        return $this->actuatorId;
    }
}
