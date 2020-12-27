<?php

namespace App\Console\Command;

use App\Dto\Transformer\TaskDtoTransformer;
use App\Entity\Task;
use App\Service\TaskUserService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserListTasksCommand extends AbstractCommand
{
    protected static $defaultName = 'app:user:list-tasks';

    protected $taskUserService;
    protected $taskDtoTransformer;
    protected $userService;

    public function __construct(TaskUserService $taskUserService, TaskDtoTransformer $taskDtoTransformer, UserService $userService)
    {
        $this->taskUserService = $taskUserService;
        $this->taskDtoTransformer = $taskDtoTransformer;
        $this->userService = $userService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('List all started task of given user.')
            ->addArgument('id', InputArgument::REQUIRED, 'Input the user ID.')
            ->addArgument('status', InputArgument::OPTIONAL, 'Input the status of tasks assigned to given user or leave empty. <comment>[started|progress|ended]</comment>')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->isAllowedCommand($input, $output, self::$defaultName, $this->userService);

        $id = (int)$input->getArgument('id');
        $status = (string)$input->getArgument('status');

        if (!empty($status) && in_array($status, Task::getValidStatus())) {
            $tasks = $this->taskUserService->getAllActiveTasksByUserAndStatus($id, $status);
        } elseif (!empty($status)) {
            $this->showError('Wrong status given.');
            return Command::FAILURE;
        } else {
            $tasks = $this->taskUserService->getAllActiveTasksByUser($id);
        }

        $dtos = $this->taskDtoTransformer->transformFromObjects($tasks);

        $this->showTitle($input, $output, 'List of all active tasks '.(!empty($status) ? 'into status `'.$status.'` ' : '').'of user ID '.$id.'.');
        $this->showList($input, $output, $dtos);

        return Command::SUCCESS;
    }
}