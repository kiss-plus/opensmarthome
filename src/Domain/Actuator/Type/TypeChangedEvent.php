<?php
namespace App\Domain\Actuator\Type;

use App\Domain\Event;

class TypeChangedEvent implements Event
{
    /**
     * @var string
     */
    private $newTypeName;
    /**
     * @var string
     */
    private $actuatorId;

    public function __construct(string $actuatorId, int $version, string $newTypeName)
    {
        $this->version = $version;
        $this->newTypeName = $newTypeName;
        $this->actuatorId = $actuatorId;
    }

    public function version(): int
    {
        return $this->version;
    }

    public function newTypeName(): string
    {
        return $this->newTypeName;
    }

    public function aggregateId(): string
    {
        return $this->actuatorId;
    }
}
