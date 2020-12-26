<?php

namespace App\Console\Command;

use App\Dto\Transformer\PermissionDtoTransformer;
use App\Service\PermissionService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PermissionListCommand extends AbstractCommand
{
    protected static $defaultName = 'app:permission:list';

    protected $permissionService;
    protected $userService;
    protected $permissionDtoTransformer;

    public function __construct(PermissionService $permissionService, PermissionDtoTransformer $permissionDtoTransformer, UserService $userService)
    {
        $this->permissionService = $permissionService;
        $this->userService = $userService;
        $this->permissionDtoTransformer = $permissionDtoTransformer;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('List all permissions.')
            ->setHelp('This command can be executed by CEO only.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->isAllowedCommand($input, $output, self::$defaultName, $this->userService);

        $entities = $this->permissionService->getAll();

        $dtos = $this->permissionDtoTransformer->transformFromObjects($entities);

        $this->showTitle($input, $output, 'List of all permissions.');
        $this->showList($input, $output, $dtos);

        return Command::SUCCESS;
    }
}