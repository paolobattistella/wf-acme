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

class UserDropTaskCommand extends AbstractCommand
{
    protected static $defaultName = 'app:user:drop-task';

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
            ->setDescription('Drop a task from a user.')
            ->addArgument('id', InputArgument::REQUIRED, 'Choose the user ID which drop a task.')
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

        //TODO: show only tasks related to given user
        $tasks = $this->taskService->getAllNames();

        $helper = $this->getHelper('question');

        $question = new ChoiceQuestion('<comment>Please choose the task to drop:</comment> ', $tasks);
        $task = $helper->ask($input, $output, $question);

        $updatedEntity = $this->userService->dropTask($entity, $task);

        if ($updatedEntity) {
            $dto = $this->userDtoTransformer->transformFromObject($updatedEntity);

            $this->showTitle($input, $output, 'Details of just updated user.');
            //TODO: show task and involved users
            $this->showDetails($input, $output, $dto);

            return Command::SUCCESS;
        } else {
            $this->showError($input, $output, 'Error occurs on dropping task.');
            return Command::FAILURE;
        }
    }
}