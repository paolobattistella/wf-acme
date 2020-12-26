<?php

namespace App\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;

final class AcmeApplication extends Application
{
    protected function getDefaultInputDefinition()
    {
        $inputDefinition = parent::getDefaultInputDefinition();

        // add "user_id" argument
        $inputDefinition->addArgument(new InputArgument('user_id', InputArgument::OPTIONAL, 'Path to changelog file to work with'));

        return $inputDefinition;
    }
}