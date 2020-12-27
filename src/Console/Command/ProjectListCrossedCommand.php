<?php

namespace App\Console\Command;

use App\Dto\Transformer\ProjectDtoTransformer;
use App\Service\ProjectService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProjectListCrossedCommand extends AbstractCommand
{
    protected static $defaultName = 'app:project:list-crossed';

    protected $projectService;
    protected $userService;
    protected $projectDtoTransformer;

    public function __construct(ProjectService $projectService, ProjectDtoTransformer $projectDtoTransformer, UserService $userService)
    {
        $this->projectService = $projectService;
        $this->userService = $userService;
        $this->projectDtoTransformer = $projectDtoTransformer;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('List all projects that involve more than one team.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->isAllowedCommand($input, $output, self::$defaultName, $this->userService);

        $entities = $this->projectService->getAllCrossed();

        $dtos = $this->projectDtoTransformer->transformFromObjects($entities);

        $this->showTitle($input, $output, 'List of all crossed projects.');
        $this->showList($input, $output, $dtos);

        return Command::SUCCESS;
    }
}