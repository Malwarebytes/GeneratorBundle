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

        $rules = array();

        $reflection = new \ReflectionClass($class);
        $properties = $reflection->getProperties();

        foreach($properties as $property) {
            $rule = $this->reader->getPropertyAnnotation($property, $this->annotationName);
            if(!is_null($rule)) {
                $rules[$property->getName()] = $rule;
            }
        }

        return $rules;
    }
}