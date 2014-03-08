<?php

namespace Malwarebytes\GeneratorBundle\Parser;

class AnnotationParser
{
    protected $parser;

    public function __construct()
    {
        $this->parser = new DocParser();
        $this->parser->addNamespace('Malwarebytes\GeneratorBundle\Annotation');
    }

    public function parse($text)
    {
        return $this->parser->parse($text);
    }
}