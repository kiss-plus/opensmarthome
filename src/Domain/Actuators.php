<?php

namespace App\Domain;

use App\Domain\Actuator\Actuator;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("none")
 * @Serializer\XmlRoot(name="actuators")
 */
class Actuators
{
    /**
     * @var \ArrayObject|Actuator[]
     * @Serializer\XmlList(entry="actuator", inline=true)
     * @Serializer\Type("array<App\Domain\Actuator\Actuator>")
     */
    private $actuators;

    /**
     * @param Actuator[]|\ArrayObject $itemsactuators
     */
    public function __construct(\ArrayObject $itemsactuators)
    {
        $this->actuators = $itemsactuators;
    }

    public function get(): \ArrayObject
    {
        return $this->actuators;
    }
}