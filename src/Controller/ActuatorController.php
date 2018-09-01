<?php

namespace App\Controller;

use App\Command\CreateActuator;
use App\Domain\Actuator\Actuator;
use App\Domain\Actuator\Type\Type;
use App\Domain\Actuators;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ActuatorController extends FOSRestController
{
    /**
     * @Rest\View()
     */
    public function getActuatorsAction(): Actuators
    {
        return new Actuators(new \ArrayObject());
    }

    /**
     * @Rest\View()
     */
    public function getActuatorAction(string $uuid): ?Actuator
    {
        return new Actuator();
    }

    public function postActuatorAction(Request $request): Response
    {
        error_reporting(E_ALL & ~E_NOTICE);
        try {
            $uuid = Uuid::uuid4();
            $createActuator = new CreateActuator(Type::DIGITAL, $request->get('name'), $uuid->toString());
            $serializedCommand = $this
                ->get('jms_serializer')
                ->serialize($createActuator, 'json');
            $this
                ->get('old_sound_rabbit_mq.actuators_producer')
                ->publish($serializedCommand);
        } catch (\Exception $ex) {
            return new Response(
                "I'm sorry, I could't register this request. Try again later",
                Response::HTTP_BAD_REQUEST
            );
        }
        return new Response(
            "Everything is cool, you can now take a look at resource with ID " . $uuid->toString(),
            Response::HTTP_ACCEPTED
        );
    }

    public function putActuatorAction(string $actuatorId)
    {

    }

    public function patchActuatorOnAction(string $actuatorId)
    {

    }

    public function patchActuatorOffAction(string $actuatorId)
    {

    }

    public function patchActuatorToggleAction(string $actuatorId)
    {

    }
}