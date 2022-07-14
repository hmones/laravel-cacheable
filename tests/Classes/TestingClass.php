<?php

namespace Hmones\LaravelCacheable\Tests\Classes;

use Hmones\LaravelCacheable\Cacheable;

class TestingClass extends Cacheable
{
    public function getSubscriber(int $id): string
    {
        return "Subscriber id is: $id";
    }

    public function getEmployee(string $name, int $id): string
    {
        return "Employee name is $name and with id equals to $id";
    }

    public function getManagers(): array
    {
        return [
            'hello',
            'world',
            'Muller',
        ];
    }

    public function setVariable(string $variableName, $value): TestingClass
    {
        $this->$variableName = $value;

        return $this;
    }
}
