<?php

namespace App\Console\Command;

use App\Service\UserService;
use App\Traits\HandleConsoleOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends Command
{
    use HandleConsoleOutput;

    public function isAllowedCommand(InputInterface $input, OutputInterface $output, string $command, UserService $userService)
    {
        $userId = $input->getOption('user_id');

        if (!$userId) {
            throw new LogicException('It`s necessary to specify the user ID that executes the command.');
        } elseif (!$userService->isAllowedTo((int) $userId, $command)) {
            throw new LogicException('Current user doesn`t allow to execute this command.');
        }
    }
}