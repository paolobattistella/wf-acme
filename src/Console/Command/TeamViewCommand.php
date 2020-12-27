<?php

namespace App\Console\Command;

use App\Dto\Transformer\TeamDtoTransformer;
use App\Service\TeamService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TeamViewCommand extends AbstractCommand
{
    protected static $defaultName = 'app:team:view';

    protected $teamService;
    protected $teamDtoTransformer;
    protected $userService;

    public function __construct(TeamService $teamService, TeamDtoTransformer $teamDtoTransformer, UserService $userService)
    {
        $this->teamService = $teamService;
        $this->teamDtoTransformer = $teamDtoTransformer;
        $this->userService = $userService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('View team details.')
            ->addArgument('id', InputArgument::REQUIRED, 'Choose the team ID to show.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = (int)$input->getArgument('id');
        $entity = $this->teamService->getById($id);

        if ($entity) {
            $dto = $this->teamDtoTransformer->transformFromObject($entity);

            $this->showTitle($input, $output, 'Details of team ID ' . $id . '.');
            $this->showDetails($input, $output, $dto);

            return Command::SUCCESS;
        } else {
            $this->showError($input, $output, 'Team ID ' . $id . ' not founded.');
            return Command::FAILURE;
        }
    }
}