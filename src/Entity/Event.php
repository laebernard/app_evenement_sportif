<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
    * @Assert\NotBlank(message="Le nom ne peut pas être vide.")
    * @Assert\Length(
    * min=3,
    * max=100,
    * minMessage="Le nom doit comporter au moins {{ limit }} caractères.",
    * maxMessage="Le nom ne peut pas dépasser {{ limit }} caractères."
    * )
    */
    #[ORM\Column(length: 100)]
    private ?string $name = null;

    /**
    * @Assert\NotBlank(message="La date ne peut pas être vide.")
    */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    /**
    * @Assert\NotBlank(message="La localisation ne peut pas être vide.")
    */
    #[ORM\Column(length: 255)]
    private ?string $location = null;

    /**
     * @var Collection<int, Particpant>
     */
    #[ORM\OneToMany(targetEntity: Particpant::class, mappedBy: 'event')]
    private Collection $particpants;

    public function __construct()
    {
        $this->particpants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, Particpant>
     */
    public function getParticpants(): Collection
    {
        return $this->particpants;
    }

    public function addParticpant(Particpant $particpant): static
    {
        if (!$this->particpants->contains($particpant)) {
            $this->particpants->add($particpant);
            $particpant->setEvent($this);
        }

        return $this;
    }

    public function removeParticpant(Particpant $particpant): static
    {
        if ($this->particpants->removeElement($particpant)) {
            // set the owning side to null (unless already changed)
            if ($particpant->getEvent() === $this) {
                $particpant->setEvent(null);
            }
        }

        return $this;
    }
}
