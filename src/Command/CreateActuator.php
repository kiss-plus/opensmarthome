<?php
namespace App\Command;

use JMS\Serializer\Annotation as JMS;

class CreateActuator implements Command
{
    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Type("string")
     */
    private $type;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Type("string")
     */
    private $name;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Type("string")
     */
    private $uuid;

    public function __construct(string $type, string $name, string $uuid)
    {
        $this->type = $type;
        $this->name = $name;
        $this->uuid = $uuid;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }
}
