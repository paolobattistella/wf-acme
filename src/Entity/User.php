<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="teams")
     * @ORM\JoinColumn(nullable=true)
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="pm")
     */
    private $projects;

    /**
     * @ORM\OneToMany(targetEntity=Commit::class, mappedBy="user")
     */
    private $commits;

    /**
     * @ORM\OneToMany(targetEntity=TaskUser::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity=WorkLog::class, mappedBy="user", orphanRemoval=true)
     */
    private $workLogs;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->commits = new ArrayCollection();
        $this->workLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFullname(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setPm($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getPm() === $this) {
                $project->setPm(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commit[]
     */
    public function getCommits(): Collection
    {
        return $this->commits;
    }

    public function addCommit(Commit $commit): self
    {
        if (!$this->commits->contains($commit)) {
            $this->commits[] = $commit;
            $commit->setUser($this);
        }

        return $this;
    }

    public function removeCommit(Commit $commit): self
    {
        if ($this->commits->removeElement($commit)) {
            // set the owning side to null (unless already changed)
            if ($commit->getUser() === $this) {
                $commit->setUser(null);
            }
        }

        return $this;
    }

    public function getTasks(): ?TaskUser
    {
        return $this->tasks;
    }

    public function setTasks(TaskUser $tasks): self
    {
        // set the owning side of the relation if necessary
        if ($tasks->getUser() !== $this) {
            $tasks->setUser($this);
        }

        $this->tasks = $tasks;

        return $this;
    }

    /**
     * @return Collection|WorkLog[]
     */
    public function getWorkLogs(): Collection
    {
        return $this->workLogs;
    }

    public function addWorkLog(WorkLog $workLog): self
    {
        if (!$this->workLogs->contains($workLog)) {
            $this->workLogs[] = $workLog;
            $workLog->setUser($this);
        }

        return $this;
    }

    public function removeWorkLog(WorkLog $workLog): self
    {
        if ($this->workLogs->removeElement($workLog)) {
            // set the owning side to null (unless already changed)
            if ($workLog->getUser() === $this) {
                $workLog->setUser(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt(): self
    {
        $this->createdAt = new DateTime();

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new DateTime();

        return $this;
    }
}
