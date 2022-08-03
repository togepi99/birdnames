<?php

namespace App\Entity;

use App\Repository\BirdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BirdRepository::class)]
class Bird
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $oldName = null;

    #[ORM\OneToMany(mappedBy: 'bird', targetEntity: BirdName::class, orphanRemoval: true)]
    private Collection $birdNames;

    public function __construct()
    {
        $this->birdNames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOldName(): ?string
    {
        return $this->oldName;
    }

    public function setOldName(string $oldName): self
    {
        $this->oldName = $oldName;

        return $this;
    }

    /**
     * @return Collection<int, BirdName>
     */
    public function getBirdNames(): Collection
    {
        return $this->birdNames;
    }

    public function addBirdName(BirdName $birdName): self
    {
        if (!$this->birdNames->contains($birdName)) {
            $this->birdNames[] = $birdName;
            $birdName->setBird($this);
        }

        return $this;
    }

    public function removeBirdName(BirdName $birdName): self
    {
        if ($this->birdNames->removeElement($birdName)) {
            // set the owning side to null (unless already changed)
            if ($birdName->getBird() === $this) {
                $birdName->setBird(null);
            }
        }

        return $this;
    }
}