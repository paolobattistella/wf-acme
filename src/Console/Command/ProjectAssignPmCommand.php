<?php

namespace App\Console\Command;

use App\Dto\Transformer\ProjectDtoTransformer;
use App\Service\UserService;
use App\Service\ProjectService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class ProjectAssignPmCommand extends AbstractCommand
{
    protected static $defaultName = 'app:project:assign-pm';

    protected $projectService;
    protected $projectDtoTransformer;
    protected $userService;

    public function __construct(ProjectService $projectService, ProjectDtoTransformer $projectDtoTransformer, UserService $userService)
    {
        $this->projectService = $projectService;
        $this->projectDtoTransformer = $projectDtoTransformer;
        $this->userService = $userService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Assign a PM to a project.')
            ->addArgument('id', InputArgument::REQUIRED, 'Choose the project ID to update.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->isAllowedCommand($input, $output, self::$defaultName, $this->userService);

        $id = (int)$input->getArgument('id');
        $entity = $this->projectService->getById($id);

        if (!$entity) {
            $this->showError($input, $output, 'The project ID '.$id.' doesn`t exist.');
            return Command::FAILURE;
        }

        $users = $this->userService->getAllPmNames();

        $helper = $this->getHelper('question');

        $question = new ChoiceQuestion('<comment>Please choose the PM of the project:</comment> ', $users);
        $user = $helper->ask($input, $output, $question);

        $updatedEntity = $this->projectService->update(
            $entity,
            [
                'pm' => $user,
            ]
        );

        if ($updatedEntity) {
            $dto = $this->projectDtoTransformer->transformFromObject($updatedEntity);

            $this->showTitle($input, $output, 'Details of just updated project.');
            $this->showDetails($input, $output, $dto);

            return Command::SUCCESS;
        } else {
            $this->showError($input, $output, 'Error occurs on updating project.');
            return Command::FAILURE;
        }
    }
}