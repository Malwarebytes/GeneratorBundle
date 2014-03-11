<?php

namespace Malwarebytes\GeneratorBundle\Populator;

use Faker\Generator;

class ObjectPopulator
{
    protected $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function addEntity($entity, $number, $customColumnModifiers = array(), $customModifiers = array(), $generateId = false)
    {

    }

    public function execute()
    {

    }
}