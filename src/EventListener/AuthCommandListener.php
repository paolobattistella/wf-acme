<?php

namespace App\EventListener;

use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Input\InputOption;

class AuthCommandListener
{

    public function onConsoleCommand(ConsoleCommandEvent $event): void
    {
        $command = $event->getCommand();
        $inputDefinition = $command->getApplication()->getDefinition();

        $option = new InputOption('user_id', 'u', InputOption::VALUE_OPTIONAL, 'Specify user that execute the command.');
        $inputDefinition->addOption($option);
    }
}
