<?php

namespace App\Console\Command;

use App\Dto\Transformer\ProjectDtoTransformer;
use App\Service\RoleService;
use App\Service\ProjectService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class ProjectNewCommand extends AbstractCommand
{
    protected static $defaultName = 'app:project:new';

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
            ->setDescription('Create a new project.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->isAllowedCommand($input, $output, self::$defaultName, $this->userService);

        $pms = $this->userService->getAllPmNames();

        $helper = $this->getHelper('question');

        $question = new Question('<comment>Please enter the title of the project:</comment> ');
        $name = $helper->ask($input, $output, $question);

        $question = new Question('<comment>Please enter the description of the project:</comment> ');
        $description = $helper->ask($input, $output, $question);

        $question = new ChoiceQuestion('<comment>Please choose the PM of the project:</comment> ', $pms);
        $pm = $helper->ask($input, $output, $question);

        $entity = $this->projectService->create([
            'name' => $name,
            'description' => $description,
            'pm' => $pm,
        ]);

        if ($entity) {
            $dto = $this->projectDtoTransformer->transformFromObject($entity);

            $this->showTitle($input, $output, 'Details of just created project.');
            $this->showDetails($input, $output, $dto);

            return Command::SUCCESS;
        } else {
            $this->showError($input, $output, 'Error occurs on creating a project.');
            return Command::FAILURE;
        }
    }
}