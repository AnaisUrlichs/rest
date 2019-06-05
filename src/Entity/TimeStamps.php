<?php

namespace App\Entity;

class TimeStamps {

    /**
     * @ORM\Column{type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column{type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\PrePersist()
     */
    public function createdAt()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PrePersist()
     */
    public function updateAt() {
        $this->updatedAt = new \DateTime();
    }
}