<?php

namespace Malwarebytes\GeneratorBundle\Annotation;

/**
 * @Annotation
 */
class Rule
{
    protected $category = null;
    protected $formatter;
    protected $optional = false;
    protected $unique = false;

    public function __construct($options)
    {
        foreach ($options as $key => $value) {
            $method = 'set'.str_replace('_', '', $key);
            if (!method_exists($this, $method)) {
                throw new \BadMethodCallException(sprintf("Unknown property '%s' on annotation '%s'.", $key, get_class($this)));
            }
            $this->$method($value);
        }
    }

    /**
     * @param mixed $formatter
     */
    public function setFormatter($formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @return mixed
     */
    public function getFormatter()
    {
        return $this->formatter;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param boolean $optional
     */
    public function setOptional($optional)
    {
        $this->optional = $optional;
    }

    /**
     * @return boolean
     */
    public function getOptional()
    {
        return $this->optional;
    }

    /**
     * @param boolean $unique
     */
    public function setUnique($unique)
    {
        $this->unique = $unique;
    }

    /**
     * @return boolean
     */
    public function getUnique()
    {
        return $this->unique;
    }
}