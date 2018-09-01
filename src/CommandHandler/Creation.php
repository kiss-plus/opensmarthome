<?php

namespace App\CommandHandler;

use App\Command\CreateActuator;
use App\Domain\Actuator\Actuator;
use JMS\Serializer\SerializerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class Creation implements ConsumerInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function execute(AMQPMessage $msg): bool
    {
        /**
         * @var CreateActuator $createCommand
         */
        $createCommand = $this->serializer->deserialize($msg->getBody(), CreateActuator::class, 'json');
        $actuator = new Actuator();
        $actuator->handle($createCommand);

        return true;
    }
}