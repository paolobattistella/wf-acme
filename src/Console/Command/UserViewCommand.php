<?php

namespace App\Console\Command;

use App\Dto\Transformer\UserDtoTransformer;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserViewCommand extends AbstractCommand
{
    protected static $defaultName = 'app:user:view';

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
            ->setDescription('View user details.')
            ->addArgument('id', InputArgument::REQUIRED, 'Choose the user ID to show.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = (int)$input->getArgument('id');
        $entity = $this->userService->getById($id);

        if ($entity) {
            $dto = $this->userDtoTransformer->transformFromObject($entity);

            $this->showTitle($input, $output, 'Details of user ID ' . $id . '.');
            $this->showDetails($input, $output, $dto);

            return Command::SUCCESS;
        } else {
            $this->showError($input, $output, 'User ID ' . $id . ' not founded.');
            return Command::FAILURE;
        }
    }
}