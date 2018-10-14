<?php

namespace App\CommandHandler;

use App\Command\CreateActuator;
use App\Domain\Actuator\Actuator;
use Doctrine\Common\Persistence\ObjectManager;
use JMS\Serializer\SerializerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class Creation implements ConsumerInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ObjectManager
     */
    private $repository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        SerializerInterface $serializer,
        ObjectManager $repository,
        LoggerInterface $logger
    ) {
        $this->serializer = $serializer;
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function execute(AMQPMessage $msg): bool
    {
        /**
         * @var CreateActuator $createCommand
         */
        $createCommand = $this->serializer->deserialize($msg->getBody(), CreateActuator::class, 'json');
        $actuator = new Actuator();
        $actuator->handle($createCommand);
        $this->repository->persist($actuator);
        $this->repository->flush();

        return true;
    }
}