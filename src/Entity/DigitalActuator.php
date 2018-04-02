<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class DigitalActuator
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    private $id = "";

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name = "";

    /**
     * @var ActuatorState
     * @ORM\ManyToOne(targetEntity="App\Entity\ActuatorState")
     */
    private $state;

    public function turnOn(): void
    {
        $this->state = new ActuatorState(ActuatorState::ON);
    }

    public function turnOff(): void
    {
        $this->state = new ActuatorState(ActuatorState::OFF);
    }

    public function toggle(): void
    {
        if ($this->state->isOff()) {
            $this->turnOn();
        } else {
            $this->turnOff();
        }
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }
}