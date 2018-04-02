<?php

namespace App\Repository;

use App\Entity\DigitalActuator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class ActuatorRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAll(): \ArrayObject
    {
        return new \ArrayObject($this->entityManager->getRepository(DigitalActuator::class)->findAll());
    }

    public function find(string $id): DigitalActuator
    {
        return $this->entityManager->getRepository(DigitalActuator::class)->find($id);
    }
}