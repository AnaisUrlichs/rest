<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use \App\Entity\TimeStamps;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Note
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
    private $Note;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Task", inversedBy="notes")
     */
    private $task;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->Note;
    }

    public function setNote(string $Note): self
    {
        $this->Note = $Note;

        return $this;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }
}
