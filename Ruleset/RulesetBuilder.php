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
                    $rules[$name] = $this->wrapInClosure($annot);
                    $filled[] = $name;
                }
            }
        }

        foreach($readannots as $name => $annots) {
            foreach($annots as $annot) {
                $cat = $annot->getCategory();
                if(is_null($cat) && !in_array($name, $filled)) {
                    $rules[$name] = $this->wrapInClosure($annot);
                }
            }
        }

        return $rules;
    }

    protected function wrapInClosure($annot)
    {
        $formatter = $annot->getFormatter();
        $args = $annot->getArguments();

        $faker = $this->faker;
        if($annot->getUnique()) {
            $faker = $faker->unique();
        }
        if($annot->getOptional()) {
            $faker = $faker->optional();
        }


        if($formatter === 'null') {
            $func = null;
        } elseif(is_null($args) || count($args) === 0) {
            $func = function() use ($faker, $formatter) { return $faker->$formatter; };
        } else {
            $func = function() use ($faker, $formatter, $args) { return call_user_func_array(array($faker, $formatter), $args); };
        }

        return $func;
    }
}