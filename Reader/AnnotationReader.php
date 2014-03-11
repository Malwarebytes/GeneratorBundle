<?php

namespace Malwarebytes\GeneratorBundle\Reader;

use Doctrine\Common\Annotations\Reader;

class AnnotationReader
{
    protected $reader;
    protected $annotationName = '\\Malwarebytes\\GeneratorBundle\\Annotation\\Rule';

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function readClass($class)
    {
        if(!class_exists($class)) {
            return false;
        }

        $ruleset = array();

        $reflection = new \ReflectionClass($class);
        $properties = $reflection->getProperties();

        foreach($properties as $property) {
            $rules = $this->reader->getPropertyAnnotations($property);
            foreach($rules as $rule) {
                if($rule instanceof $this->annotationName) {
                    $ruleset[$property->getName()][] = $rule;
                }
            }
        }

        return $ruleset;
    }
}