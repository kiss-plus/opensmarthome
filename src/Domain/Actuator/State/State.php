<?php
namespace App\Domain\Actuator\State;

class State
{
    public const OFF = 0;
    public const ON = 1;

    /**
     * @var int
     */
    private $code;

    private $allowedStates = [
        self::OFF => 'Turned off',
        self::ON => 'Turned on',
    ];

    public function __construct(int $code)
    {
        if (!array_key_exists($code, $this->allowedStates)) {
            throw new StateException($code);
        }
        $this->code = $code;
    }

    private function code(): int
    {
        return $this->code;
    }

    public function description(): string
    {
        return $this->allowedStates[$this->code()];
    }

    public function isOff(): bool
    {
        return $this->code() === self::OFF;
    }

    public function turnOn(): void
    {
        $this->code = self::ON;
    }

    public function turnOff(): void
    {
        $this->code = self::OFF;
    }
}