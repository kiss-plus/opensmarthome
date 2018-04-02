<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

/**
 * @Entity()
 */
class ActuatorState
{
    public const OFF = 0;
    public const ON = 1;

    private $allowedStates = [
        self::OFF => 'Turned off',
        self::ON => 'Turned on',
    ];

    /**
     * @Id()
     * @GeneratedValue(strategy="UUID")
     * @Column(type="guid")
     */
    private $id;

    /**
     * @var int
     * @Column(type="integer")
     */
    private $code;

    /**
     * @param int $code
     */
    public function __construct(int $code)
    {
        if (!array_key_exists($code, $this->allowedStates)) {
            throw new ActuatorStateException($code);
        }
        $this->code = $code;
    }

    public function code(): int
    {
        return $this->code;
    }

    public function description(): string
    {
        return $this->allowedStates[$this->code()];
    }

    public function isOn(): bool
    {
        return $this->code() === self::ON;
    }

    public function isOff(): bool
    {
        return $this->code() === self::OFF;
    }
}