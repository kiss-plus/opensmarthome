<?php

namespace App\Domain\Actuator\Type;

class Type
{
    const DIGITAL = 'digital';
    const ANALOG = 'analog';

    /**
     * @var string
     */
    private $type;

    private $knownTypes = [
        self::DIGITAL,
        self::ANALOG
    ];

    public function __construct(string $type)
    {
        $this->guardAgainstUnknownType($type);
        $this->type = $type;
    }

    private function guardAgainstUnknownType(string $type): void
    {
        if (!in_array($type, $this->knownTypes)) {
            throw new UnknownTypeException();
        }
    }

    public function isDigital(): bool
    {
        return self::DIGITAL === $this->type;
    }

    public function isAnalog(): bool
    {
        return self::ANALOG === $this->type;
    }

    public function __toString(): string
    {
        return $this->type;
    }
}