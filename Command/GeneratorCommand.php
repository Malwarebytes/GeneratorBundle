<?php

namespace Malwarebytes\GeneratorBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GeneratorCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('malwarebytes:generate:entities')
            ->setDescription('Run an entity generation scenario.')
            ->addArgument('scenario', InputArgument::REQUIRED, 'The scenario to run.')
            ->addArgument('id', InputArgument::OPTIONAL, 'The unique identifier to provide to the generated objects.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generator = $this->getContainer()->get('malwarebytes_generator.scenario.generator');
        $items = $generator->runScenario($input->getArgument('scenario'));
        var_dump($items);
    }
}