<?php

namespace App\Console\Command;

use App\Dto\Transformer\TaskDtoTransformer;
use App\Service\TaskService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TaskListCommand extends AbstractCommand
{
    protected static $defaultName = 'app:task:list';

    protected $taskService;
    protected $userService;
    protected $taskDtoTransformer;

    public function __construct(TaskService $taskService, TaskDtoTransformer $taskDtoTransformer, UserService $userService)
    {
        $this->taskService = $taskService;
        $this->userService = $userService;
        $this->taskDtoTransformer = $taskDtoTransformer;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('List all tasks.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->isAllowedCommand($input, $output, self::$defaultName, $this->userService);

        $entities = $this->taskService->getAll();

        $dtos = $this->taskDtoTransformer->transformFromObjects($entities);

        $this->showTitle($input, $output, 'List of all tasks.');
        $this->showList($input, $output, $dtos);

        return Command::SUCCESS;
    }
}