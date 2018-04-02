<?php

namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("none")
 * @Serializer\XmlRoot(name="actuators")
 */
class Actuators
{
    /**
     * @var \ArrayObject|DigitalActuator[]
     * @Serializer\XmlList(entry="actuator", inline=true)
     * @Serializer\Type("array<App\Entity\DigitalActuator>")
     */
    private $actuators;

    /**
     * @param DigitalActuator[]|\ArrayObject $itemsactuators
     */
    public function __construct(\ArrayObject $itemsactuators)
    {
        $this->actuators = $itemsactuators;
    }
}