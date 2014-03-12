<?php

namespace Malwarebytes\GeneratorBundle\Populator;

use Faker\Generator;

class ObjectPopulator
{
    protected $generator;
    protected $entities = array();
    protected $quantities = array();
    protected $formatters = array();
    protected $modifiers = array();

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function addEntity($class, $number, $customColumnFormatters = array(), $customModifiers = array())
    {
        $this->entities[$class] = $class;
        $this->quantities[$class] = $number;
        $this->formatters[$class] = $customColumnFormatters;
        $this->modifiers[$class] = $customModifiers;
    }

    public function execute()
    {
        $objects = array();

        foreach($this->entities as $class) {
            $reflection = new \ReflectionClass($class);
            $props = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);

            for($i = 0; $i < $this->quantities[$class]; $i++) {
                $object = new $class();

                foreach($this->modifiers[$class] as $modifier) {
                    $modifier($object, $objects);
                }

                foreach($this->formatters[$class] as $field => $formatter) {
                    if(in_array($field, $props)) {
                        $object->$field = $formatter();
                    } else {
                        $method = 'set' . $field;
                        $object->$method($formatter());
                    }
                }

                $objects[$class][] = $object;
            }
        }

        return $objects;
    }
}