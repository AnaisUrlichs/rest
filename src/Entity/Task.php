<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use \App\Entity\TimeStamps;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Task
{
    //use TimeStamps;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TaskList", inversedBy="tasks")
     */
    private $list;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TaskList", mappedBy="task", cascade={"REMOVE"})
     */

    private $notes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isComplete;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIsComplete(): ?bool
    {
        return $this->isComplete;
    }

    public function setIsComplete(bool $isComplete): self
    {
        $this->isComplete = $isComplete;

        return $this;
    }

    public function getList(): ?TaskList
    {
        return $this->list;
    }

    public function setList(?TaskList $list): self
    {
        $this->list = $list;

        return $this;
    }

    /**
     * @return Collection|TaskList[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(TaskList $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setTask($this);
        }

        return $this;
    }

    public function removeNote(TaskList $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getTask() === $this) {
                $note->setTask(null);
            }
        }

        return $this;
    }
}
