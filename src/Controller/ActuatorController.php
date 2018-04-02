<?php

namespace App\Controller;

use App\Entity\DigitalActuator;
use App\Repository\ActuatorRepository;
use App\Entity\Actuators;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;

class ActuatorController implements ClassResourceInterface
{
    /**
     * @var ActuatorRepository
     */
    private $actuatorRepository;

    public function __construct(ActuatorRepository $actuatorRepository)
    {
        $this->actuatorRepository = $actuatorRepository;
    }

    public function cgetAction(): Actuators
    {
        return new Actuators($this->actuatorRepository->findAll());
    }

    public function getAction(string $actuatorId): DigitalActuator
    {
        return $this->actuatorRepository->find($actuatorId);
    }

    public function postAction(Request $request)
    {
        return print_r($request->getContent(), true);
    }

    public function putAction(string $actuatorId)
    {

    }

    public function patchOnAction(string $actuatorId)
    {

    }

    public function patchOffAction(string $actuatorId)
    {

    }

    public function patchToggleAction(string $actuatorId)
    {

    }
}