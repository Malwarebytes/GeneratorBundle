<?php

namespace Malwarebytes\GeneratorBundle\Data;

use Faker\Generator as Faker;
use Malwarebytes\GeneratorBundle\Data\Factory\ScenarioFactory;
use Malwarebytes\GeneratorBundle\Exception\InvalidArgumentException;
use Malwarebytes\GeneratorBundle\Exception\InvalidConfigurationException;
use Malwarebytes\GeneratorBundle\Ruleset\RulesetBuilder;

class Generator
{
    protected $builder;
    protected $populator;
    protected $scenarios = array();

    public function __construct(ScenarioFactory $factory, RulesetBuilder $builder, $populator, $config)
    {
        $this->builder = $builder;
        $this->populator = $populator;
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

            $rules = $this->builder->buildRuleset($item->getEntity(), $item->getCategory());
            $this->populator->addEntity($item->getEntity(), $item->getQuantity(), $rules);
        }
        $items = $this->populator->execute();

        return $items;
    }
}