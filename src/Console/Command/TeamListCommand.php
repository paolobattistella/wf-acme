<?php

namespace App\Console\Command;

use App\Dto\Transformer\TeamDtoTransformer;
use App\Service\TeamService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TeamListCommand extends AbstractCommand
{
    protected static $defaultName = 'app:team:list';

    protected $teamService;
    protected $teamDtoTransformer;
    protected $userService;

    public function __construct(TeamService $teamService, TeamDtoTransformer $teamDtoTransformer, UserService $userService)
    {
        $this->teamService = $teamService;
        $this->userService = $userService;
        $this->teamDtoTransformer = $teamDtoTransformer;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('List all teams.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->isAllowedCommand($input, $output, self::$defaultName, $this->userService);

        $entities = $this->teamService->getAll();

        $dtos = $this->teamDtoTransformer->transformFromObjects($entities);

        $this->showTitle($input, $output, 'List of all teams.');
        $this->showList($input, $output, $dtos);

        return Command::SUCCESS;
    }
}