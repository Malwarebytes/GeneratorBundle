<?php

namespace Malwarebytes\GeneratorBundle\Data\Factory;

use Malwarebytes\GeneratorBundle\Data\Item;
use Malwarebytes\GeneratorBundle\Data\Scenario;

class ScenarioFactory
{
    protected $fields = array('entity', 'quantity', 'category');

    public function getNewScenario($config)
    {
        $scenario = new Scenario();

        foreach($config as $i) {
            $item = $this->getNewItem($i);
            if($item) {
                $scenario->addItem($item);
            }
        }

        return $scenario;
    }

    protected function getNewItem($config)
    {
        $item = new Item();

        if(!array_intersect($this->fields, array_keys($config)) == $this->fields) {
            return false;
        }

        if(!is_numeric($config['quantity'])) {
            return false;
        }

        $item->setEntity($config['entity']);
        $item->setQuantity($config['quantity']);
        $item->setCategory($config['category']);

        return $item;
    }
}