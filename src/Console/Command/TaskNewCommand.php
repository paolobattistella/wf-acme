<?php

namespace App\Console\Command;

use App\Dto\Transformer\TaskDtoTransformer;
use App\Service\ProjectService;
use App\Service\RoleService;
use App\Service\TaskService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class TaskNewCommand extends AbstractCommand
{
    protected static $defaultName = 'app:task:new';

    protected $taskService;
    protected $taskDtoTransformer;
    protected $userService;
    protected $projectService;

    public function __construct(TaskService $taskService, TaskDtoTransformer $taskDtoTransformer, UserService $userService, ProjectService $projectService)
    {
        $this->taskService = $taskService;
        $this->taskDtoTransformer = $taskDtoTransformer;
        $this->userService = $userService;
        $this->projectService = $projectService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a new task.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->isAllowedCommand($input, $output, self::$defaultName, $this->userService);

        $projects = $this->projectService->getAllNames();

        $helper = $this->getHelper('question');

        $question = new ChoiceQuestion('<comment>Please choose the project of the task:</comment> ', $projects);
        $project = $helper->ask($input, $output, $question);

        $question = new Question('<comment>Please enter the title of the task:</comment> ');
        $name = $helper->ask($input, $output, $question);

        $question = new Question('<comment>Please enter the description of the task:</comment> ');
        $description = $helper->ask($input, $output, $question);

        $question = new Question('<comment>Please enter the deadline of the task:</comment> <info>[format Y-m-d]</info> ');
        $deadline = $helper->ask($input, $output, $question);

        $entity = $this->taskService->create([
            'project' => $project,
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
        ]);

        if ($entity) {
            $dto = $this->taskDtoTransformer->transformFromObject($entity);

            $this->showTitle($input, $output, 'Details of just created task.');
            $this->showDetails($input, $output, $dto);

            return Command::SUCCESS;
        } else {
            $this->showError($input, $output, 'Error occurs on creating a task.');
            return Command::FAILURE;
        }
    }
}