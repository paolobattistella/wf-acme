<?php

namespace App\DataFixtures;

use App\Entity\Permission;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    protected $manager;
    protected $permissions;

    protected $commands = [
        'app:user:new',
        'app:user:list',
        'app:user:view',
        'app:user:assign-team',
        'app:user:list-tasks',
        'app:user:assign-task',
        'app:user:drop-task',
        'app:role:list',
        'app:permission:list',
        'app:team:list',
        'app:team:view',
        'app:project:new',
        'app:project:list',
        'app:project:list-crossed',
        'app:project:view',
        'app:project:assign-pm',
        'app:task:new',
        'app:task:list',
        'app:task:view',
        'app:task:list-expired',
        'app:commit:new',
        'app:commit:list',
        'app:commit:view',
        'app:work-log:list',
        'app:work:in',
        'app:work:out',
    ];

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->createPermissions();
        $this->createRoles();

        $this->manager->flush();
    }

    protected function createPermissions()
    {
        foreach($this->commands as $command) {
            $permission = new Permission();
            $permission->setName($command);
            $this->manager->persist($permission);
            $this->permissions[$permission->getName()] = $permission;
        }
    }

    protected function createRoles()
    {
        // Create role `CEO`
        $role = new Role();
        $role->setName('CEO');
        $this->manager->persist($role);
        // and assign permissions to it
        $permissions = $this->commands;
        foreach($permissions as $permission) {
            $role->addPermission($this->permissions[$permission]);
        }
        // Create first user as `CEO`
        $user = new User();
        $user->setFirstname('Luca');
        $user->setLastname('Semenza');
        $user->setRole($role);
        $this->manager->persist($user);

        // Create role `PM`
        $role = new Role();
        $role->setName('PM');
        $this->manager->persist($role);
        // and assign permissions to it
        $permissions = array_diff($this->commands, ['app:user:new', 'app:work-log:list', 'app:user:assign-team']);
        foreach($permissions as $permission) {
            $role->addPermission($this->permissions[$permission]);
        }

        // Create role `DEV`
        $role = new Role();
        $role->setName('DEV');
        $this->manager->persist($role);
        // and assign permissions to it
        $permissions = array_diff($this->commands,
            [
                'app:user:new', 'app:user:assign-team',
                'app:project:new', 'app:project:assign',
                'app:task:new', 'app:task:assign', 'app:task:list-expired',
                'app:work-log:list'
            ]);
        foreach($permissions as $permission) {
            $role->addPermission($this->permissions[$permission]);
        }
    }

    public static function getGroups(): array
    {
        return ['init', 'demo'];
    }
}
