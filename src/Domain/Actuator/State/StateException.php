<?php
namespace App\Domain\Actuator\State;

class StateException extends \DomainException
{

    public function __construct($stateValue)
    {
        parent::__construct(
            sprintf(
                'Impossible to create an actuator status with status value "%d"',
                $stateValue
            )
        );
    }
}