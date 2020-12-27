<?php

namespace App\Console\Command;

use App\Dto\Transformer\UserDtoTransformer;
use App\Service\TeamService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class UserAssignTeamCommand extends AbstractCommand
{
    protected static $defaultName = 'app:user:assign-team';

    protected $userService;
    protected $userDtoTransformer;
    protected $teamService;

    public function __construct(UserService $userService, UserDtoTransformer $userDtoTransformer, TeamService $teamService)
    {
        $this->userService = $userService;
        $this->userDtoTransformer = $userDtoTransformer;
        $this->teamService = $teamService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Assign a user to a team.')
            ->setHelp('This command can be executed by CEO only.')
            ->addArgument('id', InputArgument::REQUIRED, 'Choose the user ID to update.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->isAllowedCommand($input, $output, self::$defaultName, $this->userService);

        $id = (int)$input->getArgument('id');
        $entity = $this->userService->getById($id);

        if (!$entity) {
            $this->showError($input, $output, 'The user ID '.$id.' doesn`t exist.');
            return Command::FAILURE;
        }

        $teams = $this->teamService->getAllNames();

        $helper = $this->getHelper('question');

        $question = new ChoiceQuestion('<comment>Please choose the team of the user:</comment> ', $teams);
        $team = $helper->ask($input, $output, $question);

        $updatedEntity = $this->userService->update(
            $entity,
            [
                'team' => $team,
            ]
        );

        if ($updatedEntity) {
            $dto = $this->userDtoTransformer->transformFromObject($updatedEntity);

            $this->showTitle($input, $output, 'Details of just updated user.');
            $this->showDetails($input, $output, $dto);

            return Command::SUCCESS;
        } else {
            $this->showError($input, $output, 'Error occurs on updating user.');
            return Command::FAILURE;
        }
    }
}