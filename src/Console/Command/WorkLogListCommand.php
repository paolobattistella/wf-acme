<?php

namespace App\Console\Command;

use App\Dto\Transformer\WorkLogDtoTransformer;
use App\Service\WorkLogService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WorkLogListCommand extends AbstractCommand
{
    protected static $defaultName = 'app:work-log:list';

    protected $workLogService;
    protected $workLogDtoTransformer;
    protected $userService;

    public function __construct(WorkLogService $workLogService, WorkLogDtoTransformer $workLogDtoTransformer, UserService $userService)
    {
        $this->workLogService = $workLogService;
        $this->workLogDtoTransformer = $workLogDtoTransformer;
        $this->userService = $userService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('List all workLogs.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->isAllowedCommand($input, $output, self::$defaultName, $this->userService);

        $entities = $this->workLogService->getAll();

        $dtos = $this->workLogDtoTransformer->transformFromObjects($entities);

        $this->showTitle($input, $output, 'List of all workLogs.');
        $this->showList($input, $output, $dtos);

        return Command::SUCCESS;
    }
}