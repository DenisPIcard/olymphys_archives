<?php

namespace App\Entity;

use App\Entity\User\User;
use App\Repository\TblFichiersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TblFichiersRepository::class)]

class TblFichiers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;


    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'tblFichiers')]
    private ?TblPaths $path = null;

    #[ORM\Column(length: 6, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?int $size = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $creator = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $modificator = null;

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

    public function getPath(): ?TblPaths
    {
                return $this->path;
    }

    public function setPath(?TblPaths $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getCreator(): ?string
    {
        return $this->creator;
    }

    public function setCreator(?string $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    public function getModificator(): ?string
    {
        return $this->modificator;
    }

    public function setModificator(?string $modificator): static
    {
        $this->modificator = $modificator;

        return $this;
    }
}
