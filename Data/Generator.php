<?php

namespace Malwarebytes\GeneratorBundle\Data;

use Faker\Generator as Faker;

class Generator
{
    protected $faker;
    protected $scenarios = array();

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    public function addScenario(Scenario $scenario)
    {

    }
}