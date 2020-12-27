<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\Team;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DemoUsersFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    protected $manager;
    protected $roles;
    protected $teams;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->init();
        $this->createPmUsers();
        $this->createDevUsers();

        $this->manager->flush();
    }

    protected function init(): void
    {
        $this->loadRoles();
        $this->loadTeams();
    }

    protected function loadRoles(): void
    {
        $roles = $this->manager
            ->getRepository(Role::class)
            ->findAll();

        foreach($roles as $role) {
            $this->roles[$role->getName()] = $role;
        }
    }

    protected function loadTeams(): void
    {
        $teams = $this->manager
            ->getRepository(Team::class)
            ->findAll();

        foreach($teams as $team) {
            $this->teams[$team->getName()] = $team;
        }
    }

    protected function createPmUsers(): void
    {
        $user = new User();
        $user->setFirstname('Diego');
        $user->setLastname('Peressini');
        $user->setRole($this->roles['PM']);
        $user->setTeam($this->teams['Green']);
        $this->manager->persist($user);

        $user = new User();
        $user->setFirstname('Mauro');
        $user->setLastname('Rovere');
        $user->setRole($this->roles['PM']);
        $user->setTeam($this->teams['Blue']);
        $this->manager->persist($user);
    }

    protected function createDevUsers(): void
    {
        $user = new User();
        $user->setFirstname('Paolo');
        $user->setLastname('Battistella');
        $user->setRole($this->roles['DEV']);
        $user->setTeam($this->teams['Green']);
        $this->manager->persist($user);

        $user = new User();
        $user->setFirstname('Luca');
        $user->setLastname('Dei Rossi');
        $user->setRole($this->roles['DEV']);
        $user->setTeam($this->teams['Green']);
        $this->manager->persist($user);

        $user = new User();
        $user->setFirstname('Roberto');
        $user->setLastname('Veronesi');
        $user->setRole($this->roles['DEV']);
        $user->setTeam($this->teams['Blue']);
        $this->manager->persist($user);

        $user = new User();
        $user->setFirstname('Silvia');
        $user->setLastname('Longo');
        $user->setRole($this->roles['DEV']);
        $user->setTeam($this->teams['Blue']);
        $this->manager->persist($user);

        // Create a user without a associated team
        $user = new User();
        $user->setFirstname('Elena');
        $user->setLastname('Ricciardi');
        $user->setRole($this->roles['DEV']);
        $this->manager->persist($user);
    }

    public static function getGroups(): array
    {
        return ['demo'];
    }

    public function getDependencies(): array
    {
        return [
            DemoTeamsFixtures::class,
        ];
    }
}
