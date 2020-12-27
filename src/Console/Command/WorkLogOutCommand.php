<?php

namespace App\Console\Command;

use App\Dto\Transformer\WorkLogDtoTransformer;
use App\Entity\WorkLog;
use App\Service\WorkLogService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WorkLogOutCommand extends AbstractCommand
{
    protected static $defaultName = 'app:work:out';

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
            ->setDescription('Log end of the work day.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->isAllowedCommand($input, $output, self::$defaultName, $this->userService);

        $userId = $input->getOption('user_id');
        $workLog = $this->workLogService->logOut($userId);

        if ($workLog instanceof WorkLog) {
            $this->showSuccess($input, $output, 'Logged successfully');
            return Command::SUCCESS;
        } else {
            $this->showError($input, $output, 'An error occurs');
            return Command::FAILURE;
        }
    }
}