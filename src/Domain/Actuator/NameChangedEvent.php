<?php
namespace App\Domain\Actuator;

class NameChangedEvent extends ActuatorEvent
{
    /**
     * @var string
     */
    private $newName;

    public function __construct(string $actuatorId, int $version, string $newName)
    {
        parent::__construct($actuatorId, $version);
        $this->newName = $newName;
    }

    public function newName(): string
    {
        return $this->newName;
    }
}
