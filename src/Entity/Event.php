<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    /**
     * @var \DateTime
     * @Assert\NotBlank(message="La date de l'événement est obligatoire.")
     * @Assert\GreaterThanOrEqual(
     *     value="today",
     *     message="La date de l'événement ne peut pas être dans le passé."
     * )
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    /**
    * @Assert\NotBlank(message="La localisation ne peut pas être vide.")
    */
    #[ORM\Column(length: 255)]
    private ?string $locationX = null;

    /**
    * @Assert\NotBlank(message="La localisation ne peut pas être vide.")
    */
    #[ORM\Column(length: 255)]
    private ?string $locationY = null;


    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    /**
     * @var Collection<int, Participant>
     */
    #[ORM\OneToMany(targetEntity: Participant::class, mappedBy: 'event')]
    private Collection $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
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

    public function getLocationX(): ?string
    {
        return $this->locationX;
    }

    public function setLocationX(string $locationX): static
    {
        $this->locationX = $locationX;

        return $this;
    }

    public function getLocationY(): ?string
    {
        return $this->locationY;
    }

    public function setLocationY(string $locationY): static
    {
        $this->locationY = $locationY;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
            $participant->setEvent($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): static
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getEvent() === $this) {
                $participant->setEvent(null);
            }
        }

        return $this;
    }
}
