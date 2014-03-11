<?php

namespace Malwarebytes\GeneratorBundle\Data;

class Scenario
{
    protected $items = array();

    public function addItem($item)
    {
        if(!in_array($item, $this->items)) {
            $this->items[] = $item;
        }
    }

    /**
     * @param array $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }
}