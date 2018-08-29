<?php
namespace App\Domain;

interface EventsStream extends \Traversable
{
    public function current(): Event;
}
