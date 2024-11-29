<?php

namespace App\Entity;

use App\Repository\ParticpantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticpantRepository::class)]
class Particpant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    /**
    * @Assert\NotBlank(message="Le nom ne peut pas être vide.")
    * @Assert\Length(
    * min=2,
    * max=50,
    * minMessage="Le nom doit comporter au moins {{ limit }} caractères.",
    * maxMessage="Le nom ne peut pas dépasser {{ limit }} caractères."
    * )
    */
    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
    * @Assert\NotBlank(message="L'email est requis.")
    * @Assert\Email(message="Veuillez fournir un email valide.")
    */
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
    * @Assert\NotBlank(message="La localisation ne peut pas être vide.")
    */
    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\ManyToOne(inversedBy: 'particpants')]
    private ?Event $event = null;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }
}
