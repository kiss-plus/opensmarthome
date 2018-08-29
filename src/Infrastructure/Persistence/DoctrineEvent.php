<?php

namespace App\Infrastructure\Persistence;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class DoctrineEvent
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $aggregateId;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $payload;

    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $version;

    /**
     * @param string $aggregateId
     * @param string $payload
     * @param int $version
     */
    public function __construct(string $aggregateId, string $payload, int $version)
    {
        $this->aggregateId = $aggregateId;
        $this->payload = $payload;
        $this->version = $version;
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function payload(): string
    {
        return $this->payload;
    }

    public function version(): int
    {
        return $this->version;
    }
}
