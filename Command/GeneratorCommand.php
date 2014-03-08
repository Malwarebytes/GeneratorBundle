<?php

namespace Malwarebytes\GeneratorBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class GeneratorCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('malwarebytes:generate:entities');
    }
}