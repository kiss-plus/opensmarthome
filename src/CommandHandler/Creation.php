<?php

namespace App\CommandHandler;

use App\Command\CreateActuator;
use App\Domain\Actuator\Actuator;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class Creation implements ConsumerInterface
{
    /**
     * @param AMQPMessage $msg The message
     * @return bool false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        var_dump($msg->getBody());
        $actuator = new Actuator();
        $actuator->handle(new CreateActuator("digital", "some name", "kdsfsfdjkn-42342-gfsfs"));
        return true;
    }
}