<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Project;
use App\Entity\Task;
use App\Entity\TaskUser;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DemoProjectsFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    protected $manager;
    protected $pms;
    protected $devs;
    protected $teams;
    protected $tasks;
    protected $projects;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->init();
        $this->createProjects();
        $this->createTasks();
        $this->assignTasksToUsers();

        $this->manager->flush();
    }

    protected function init()
    {
        $this->loadPms();
        $this->loadDevs();
    }

    protected function loadPms()
    {
        $users = $this->manager->getRepository(User::class)->findAll();
        $this->pms = array_filter(
            $users,
            function($user) {
                return $user->getRole()->getName() === 'PM';
            }
        );
    }

    protected function loadDevs()
    {
        $users = $this->manager->getRepository(User::class)->findAll();
        $this->devs = array_filter(
            $users,
            function($user) {
                return !empty($user->getTeam()) && $user->getRole()->getName() === 'DEV';
            }
        );
    }

    protected function createProjects()
    {
        $project = new Project();
        $project->setName('Oro');
        $project->setDescription('Ecommerce per azienda che vende gioielli');
        $rand = array_rand($this->pms, 1);
        $project->setPm($this->pms[$rand]);
        $this->manager->persist($project);
        $this->projects[$project->getName()] = $project;

        $project = new Project();
        $project->setName('eSport');
        $project->setDescription('Ecommerce per azienda che vende abbigliamento sportivo');
        $rand = array_rand($this->pms, 1);
        $project->setPm($this->pms[$rand]);
        $this->manager->persist($project);
        $this->projects[$project->getName()] = $project;
    }

    protected function createTasks()
    {
        // about project `Oro`
        $task = new Task();
        $task->setName('Analisi Oro');
        $task->setDescription('Analisi dei requisiti del cliente');
        $task->setProject($this->projects['Oro']);
        $task->setStatus('ended');
        $task->setDeadline(new DateTime(date('Y-m-d',strtotime('-1 month'))));
        $this->manager->persist($task);
        $this->tasks[$task->getName()] = $task;

        $task = new Task();
        $task->setName('Sviluppo Oro');
        $task->setDescription('Sviluppo del progetto');
        $task->setProject($this->projects['Oro']);
        $task->setStatus('progress');
        $task->setDeadline(new DateTime(date('Y-m-d',strtotime('-1 week'))));
        $this->manager->persist($task);
        $this->tasks[$task->getName()] = $task;

        $task = new Task();
        $task->setName('Test Oro');
        $task->setDescription('Test del sito ecommerce');
        $task->setProject($this->projects['Oro']);
        $task->setStatus('started');
        $task->setDeadline(new DateTime(date('Y-m-d',strtotime('+1 month'))));
        $this->manager->persist($task);
        $this->tasks[$task->getName()] = $task;

        $task = new Task();
        $task->setName('Rilascio Oro');
        $task->setDescription('Rilascio del sito ecommerce');
        $task->setProject($this->projects['Oro']);
        $task->setStatus('created');
        $task->setDeadline(new DateTime(date('Y-m-d',strtotime('+1 month'))));
        $this->manager->persist($task);
        $this->tasks[$task->getName()] = $task;

        // about project `eSport`
        $task = new Task();
        $task->setName('Analisi eSport');
        $task->setDescription('Analisi dei requisiti del cliente');
        $task->setProject($this->projects['eSport']);
        $task->setStatus('created');
        $task->setDeadline(new DateTime(date('Y-m-d',strtotime('+1 month'))));
        $this->manager->persist($task);
        $this->tasks[$task->getName()] = $task;

        $task = new Task();
        $task->setName('Sviluppo eSport');
        $task->setDescription('Sviluppo del progetto');
        $task->setProject($this->projects['eSport']);
        $task->setStatus('created');
        $task->setDeadline(new DateTime(date('Y-m-d',strtotime('+1 month'))));
        $this->manager->persist($task);
        $this->tasks[$task->getName()] = $task;

        $task = new Task();
        $task->setName('Rilascio eSport');
        $task->setDescription('Rilascio del sito ecommerce');
        $task->setProject($this->projects['eSport']);
        $task->setStatus('created');
        $task->setDeadline(new DateTime(date('Y-m-d',strtotime('+1 month'))));
        $this->manager->persist($task);
        $this->tasks[$task->getName()] = $task;
    }

    protected function assignTasksToUsers()
    {
        $task = $this->tasks['Analisi Oro'];
        $taskUser = new TaskUser();
        $rand = array_rand($this->devs, 1);
        $taskUser->setUser($this->devs[$rand]);
        $taskUser->setTask($task);
        $taskUser->setStatus('ended');
        $taskUser->setActive(true);
        $this->manager->persist($taskUser);

        $task = $this->tasks['Sviluppo Oro'];
        $rands = array_rand($this->devs, 2);
        foreach ($rands as $rand) {
            $taskUser = new TaskUser();
            $taskUser->setUser($this->devs[$rand]);
            $taskUser->setTask($task);
            $taskUser->setStatus('progress');
            $taskUser->setActive(true);
            $this->manager->persist($taskUser);
        }

        $task = $this->tasks['Test Oro'];
        $taskUser = new TaskUser();
        $rand = array_rand($this->devs, 1);
        $taskUser->setUser($this->devs[$rand]);
        $taskUser->setTask($task);
        $taskUser->setStatus('created');
        $taskUser->setActive(true);
        $this->manager->persist($taskUser);
    }

    public static function getGroups(): array
    {
        return ['demo'];
    }

    public function getDependencies(): array
    {
        return [
            DemoUsersFixtures::class,
            DemoTeamsFixtures::class
        ];
    }
}
