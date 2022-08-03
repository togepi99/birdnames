<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BirdName $birdName = null;

    #[ORM\ManyToOne]
    private ?User $voter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBirdName(): ?BirdName
    {
        return $this->birdName;
    }

    public function setBirdName(?BirdName $birdName): self
    {
        $this->birdName = $birdName;

        return $this;
    }

    public function getVoter(): ?User
    {
        return $this->voter;
    }

    public function setVoter(?User $voter): self
    {
        $this->voter = $voter;

        return $this;
    }
}
