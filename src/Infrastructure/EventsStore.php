<?php

namespace App\Infrastructure;

use App\Domain\Event;
use App\Domain\EventsStream;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class EventsStore
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(Event $event): void
    {
        try {
            $this->entityManager->persist($actuator);
        } catch (ORMException $exception) {
            throw new PersistenceException($exception->getCode(), $exception->getMessage(), $exception);
        }
    }

    public function find(string $uuid): EventsStream
    {

    }
}