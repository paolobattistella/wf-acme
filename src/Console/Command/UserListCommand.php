<?php

namespace App\Console\Command;

use App\Dto\Transformer\UserDtoTransformer;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserListCommand extends AbstractCommand
{
    protected static $defaultName = 'app:user:list';

    protected $userService;
    protected $userDtoTransformer;

    public function __construct(UserService $userService, UserDtoTransformer $userDtoTransformer)
    {
        $this->userService = $userService;
        $this->userDtoTransformer = $userDtoTransformer;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('List all users.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entities = $this->userService->getAll();

        $dtos = $this->userDtoTransformer->transformFromObjects($entities);

        $this->showTitle($input, $output, 'List of all users.');
        $this->showList($input, $output, $dtos);

        return Command::SUCCESS;
    }
}