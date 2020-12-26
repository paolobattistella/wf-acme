<?php

namespace App\Console\Command;

use App\Dto\Transformer\UserDtoTransformer;
use App\Service\RoleService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class UserNewCommand extends AbstractCommand
{
    protected static $defaultName = 'app:user:new';

    protected $userService;
    protected $userDtoTransformer;
    protected $roleService;

    public function __construct(UserService $userService, UserDtoTransformer $userDtoTransformer, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->userDtoTransformer = $userDtoTransformer;
        $this->roleService = $roleService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Create new a user.')
            ->setHelp('This command can be executed by CEO only.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->isAllowedCommand($input, $output, self::$defaultName, $this->userService);

        $roles = $this->roleService->getAllNames();

        $helper = $this->getHelper('question');

        $question = new Question('<comment>Please enter the firstname of the user:</comment> ');
        $firstname = $helper->ask($input, $output, $question);

        $question = new Question('<comment>Please enter the lastname of the user:</comment> ');
        $lastname = $helper->ask($input, $output, $question);

        $question = new ChoiceQuestion('<comment>Please choose the role of the user:</comment> ', $roles);
        $role = $helper->ask($input, $output, $question);

        $entity = $this->userService->create([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'role' => $role,
        ]);

        if ($entity) {
            $dto = $this->userDtoTransformer->transformFromObject($entity);

            $this->showTitle($input, $output, 'Details of just created user.');
            $this->showDetails($input, $output, $dto);

            return Command::SUCCESS;
        } else {
            $this->showError($input, $output, 'Error occurs on creating a user.');
            return Command::FAILURE;
        }
    }
}