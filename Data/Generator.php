<?php

namespace Malwarebytes\GeneratorBundle\Data;

use Faker\Generator as Faker;
use Malwarebytes\GeneratorBundle\Data\Factory\ScenarioFactory;
use Malwarebytes\GeneratorBundle\Exception\InvalidArgumentException;
use Malwarebytes\GeneratorBundle\Exception\InvalidConfigurationException;
use Malwarebytes\GeneratorBundle\Ruleset\RulesetBuilder;

class Generator
{
    protected $faker;
    protected $builder;
    protected $scenarios = array();

    public function __construct(Faker $faker, ScenarioFactory $factory, RulesetBuilder $builder, $config)
    {
        $this->faker = $faker;
        $this->builder = $builder;
        foreach($config as $name => $scenario) {
            $this->scenarios[$name] = $factory->getNewScenario($scenario);
        }
    }

    public function addScenario($name, Scenario $scenario)
    {
        $this->scenarios[$name] = $scenario;
    }

    public function runScenario($name)
    {
        if(!isset($this->scenarios[$name])) {
            throw new InvalidArgumentException("No scenario defined with the name '$name'");
        }

        $s = $this->scenarios[$name];

        $items = array();
        foreach($s->getItems() as $item) {
            if(!class_exists($item->getEntity())) {
                throw new InvalidConfigurationException("The entity " . $item->getEntity() . " does not exist.");
            }

            for($i = 0; $i < $item->getQuantity(); $i++) {
                $items[] = $this->doGenerate($item);
            }
        }

        return $items;
    }

    protected function doGenerate($item)
    {
        $class = $item->getEntity();
        $obj = new $class();
        $reflection = new \ReflectionClass($class);
        $props = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);

        $rules = $this->builder->buildRuleset($item->getEntity(), $item->getCategory());

        foreach($rules as $field => $generator) {
            if(in_array($field, $props)) {
                $obj->$field = $generator();
            } else {
                $method = 'set' . $field;
                $obj->$method($generator());
            }
        }

        return $obj;
    }
}