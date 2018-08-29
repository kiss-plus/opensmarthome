<?php
namespace App\Domain;

interface Event
{
    public function aggregateId(): string;
}
