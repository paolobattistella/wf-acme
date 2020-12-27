<?php

namespace App\Console\Command;

use App\Dto\Transformer\ProjectDtoTransformer;
use App\Service\ProjectService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProjectViewCommand extends AbstractCommand
{
    protected static $defaultName = 'app:project:view';

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
            ->setDescription('View project details.')
            ->addArgument('id', InputArgument::REQUIRED, 'Choose the project ID to show.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = (int)$input->getArgument('id');
        $entity = $this->projectService->getById($id);

        if ($entity) {
            $dto = $this->projectDtoTransformer->transformFromObject($entity);

            $this->showTitle($input, $output, 'Details of project ID ' . $id . '.');
            $this->showDetails($input, $output, $dto);

            return Command::SUCCESS;
        } else {
            $this->showError($input, $output, 'Project ID ' . $id . ' not founded.');
            return Command::FAILURE;
        }
    }
}