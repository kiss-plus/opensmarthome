<?php
namespace App;

use App\Domain\Event;

class EventsStream extends \ArrayObject implements \App\Domain\EventsStream
{
    public function current(): Event
    {
        return $this->current();
    }
}