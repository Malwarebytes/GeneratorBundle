<?php

namespace Malwarebytes\GeneratorBundle\Ruleset;

use Malwarebytes\GeneratorBundle\Exception\InvalidArgumentException;

class RulesetBuilder
{
    protected $reader;
    protected $faker;

    public function __construct($reader, $faker)
    {
        $this->reader = $reader;
        $this->faker = $faker;
    }

    public function buildRuleset($entity, $category)
    {
        if(!class_exists($entity)) {
            throw new InvalidArgumentException('Specified entity class does not exist.');
        }

        $rules = array();
        $readannots = $this->reader->readClass($entity);

        $filled = array();
        foreach($readannots as $name => $annots) {
            foreach($annots as $annot) {
                $cat = $annot->getCategory();
                if($cat === $category) {
                    $rules[$name] = $this->wrapInClosure($annot->getFormatter(), $annot->getArguments());
                    $filled[] = $name;
                }
            }
        }

        foreach($readannots as $name => $annots) {
            foreach($annots as $annot) {
                $cat = $annot->getCategory();
                if(is_null($cat) && !in_array($name, $filled)) {
                    $rules[$name] = $this->wrapInClosure($annot->getFormatter(), $annot->getArguments());
                }
            }
        }

        return $rules;
    }

    protected function wrapInClosure($formatter, $args = null)
    {
        $faker = $this->faker;
        if(is_null($args) || count($args) === 0) {
            $func = function() use ($faker, $formatter) { return $faker->$formatter; };
        } else {
            $func = function() use ($faker, $formatter, $args) { return call_user_func_array(array($faker, $formatter), $args); };
        }

        return $func;
    }
}