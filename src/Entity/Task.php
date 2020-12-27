<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Task
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
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\Column(type="string", length=8)
     * @Assert\Count(min="1")
     * @Assert\All({
     *     @Assert\Choice(callback={"AppBundle\Entity\Task", "getValidStatus"})
     * })
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Commit::class, mappedBy="task")
     */
    private $commits;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="date")
     */
    private $deadline;

    /**
     * @ORM\OneToMany(targetEntity=TaskUser::class, mappedBy="task", cascade={"persist", "remove"})
     */
    private $users;

    public function __construct()
    {
        $this->commits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            $commit->setTask($this);
        }

        return $this;
    }

    public function removeCommit(Commit $commit): self
    {
        if ($this->commits->removeElement($commit)) {
            // set the owning side to null (unless already changed)
            if ($commit->getTask() === $this) {
                $commit->setTask(null);
            }
        }

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDeadline(): ?DateTime
    {
        return $this->deadline;
    }

    public function setDeadline(DateTime $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getUsers(): ?TaskUser
    {
        return $this->users;
    }

    public function setUsers(TaskUser $users): self
    {
        // set the owning side of the relation if necessary
        if ($users->getTask() !== $this) {
            $users->setTask($this);
        }

        $this->users = $users;

        return $this;
    }

    public static function getValidStatus(): array
    {
        return ['created', 'started', 'progress', 'ended'];
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
