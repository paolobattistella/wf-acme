<?php

namespace App\Console\Command;

use App\Dto\Transformer\RoleDtoTransformer;
use App\Service\RoleService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RoleListCommand extends AbstractCommand
{
    protected static $defaultName = 'app:role:list';

    protected $roleService;
    protected $roleDtoTransformer;
    protected $userService;

    public function __construct(RoleService $roleService, RoleDtoTransformer $roleDtoTransformer, UserService $userService)
    {
        $this->roleService = $roleService;
        $this->userService = $userService;
        $this->roleDtoTransformer = $roleDtoTransformer;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('List all roles.')
            ->setHelp('This command can be executed by CEO only.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->isAllowedCommand($input, $output, self::$defaultName, $this->userService);

        $entities = $this->roleService->getAll();

        $dtos = $this->roleDtoTransformer->transformFromObjects($entities);

        $this->showTitle($input, $output, 'List of all roles.');
        $this->showList($input, $output, $dtos);

        return Command::SUCCESS;
    }
}