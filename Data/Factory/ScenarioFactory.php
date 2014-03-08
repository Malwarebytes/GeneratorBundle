<?php

namespace Malwarebytes\GeneratorBundle\Data\Factory;

use Malwarebytes\GeneratorBundle\Data\Item;
use Malwarebytes\GeneratorBundle\Data\Scenario;

class ScenarioFactory
{
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

        if(!in_array(array('entity', 'quantity', 'category'), array_keys($config))) {
            return false;
        }

        if(!is_numeric($quantity)) {
            return false;
        }

        $item->setEntity($config['entity']);
        $item->setQuantity($config['quantity']);
        $item->setCategory($config['category']);

        return $item;
    }
}