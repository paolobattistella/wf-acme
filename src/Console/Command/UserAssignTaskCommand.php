<?php

namespace App\Console\Command;

use App\Dto\Transformer\UserDtoTransformer;
use App\Service\UserService;
use App\Service\TaskService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class UserAssignTaskCommand extends AbstractCommand
{
    protected static $defaultName = 'app:user:assign-task';

    protected $userService;
    protected $userDtoTransformer;
    protected $taskService;

    public function __construct(UserService $userService, UserDtoTransformer $userDtoTransformer, TaskService $taskService)
    {
        $this->userService = $userService;
        $this->userDtoTransformer = $userDtoTransformer;
        $this->taskService = $taskService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Assign a task to a user.')
            ->addArgument('id', InputArgument::REQUIRED, 'Choose the user ID which assign a task.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->isAllowedCommand($input, $output, self::$defaultName, $this->userService);

        $id = (int)$input->getArgument('id');
        $entity = $this->userService->getById($id);

        if (!$entity) {
            $this->showError($input, $output, 'The user ID '.$id.' doesn`t exist.');
            return Command::FAILURE;
        }

        //TODO: choose a project and than choose a task
        $tasks = $this->taskService->getAllNames();

        $helper = $this->getHelper('question');

        $question = new ChoiceQuestion('<comment>Please choose the task to assign:</comment> ', $tasks);
        $task = $helper->ask($input, $output, $question);

        $updatedEntity = $this->userService->assignTask($entity, $task);

        if ($updatedEntity) {
            $dto = $this->userDtoTransformer->transformFromObject($updatedEntity);

            $this->showTitle($input, $output, 'Details of just updated user.');
            //TODO: show task and involved users
            $this->showDetails($input, $output, $dto);

            return Command::SUCCESS;
        } else {
            $this->showError($input, $output, 'Error occurs on assigning task.');
            return Command::FAILURE;
        }
    }
}