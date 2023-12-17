<?php

namespace App\Entity;

use App\Entity\User\User;
use App\Repository\TblPathsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TblPathsRepository::class)]
class TblPaths
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;



    #[ORM\Column(nullable: true)]
    private ?int $rang = null;

    #[ORM\OneToMany(mappedBy: 'path', targetEntity: TblFichiers::class)]
    private Collection $tblFichiers;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $creator = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $uploadedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $modificator = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'subFolders')]
    private ?self $directory = null;

    #[ORM\OneToMany(mappedBy: 'directory', targetEntity: self::class)]
    private Collection $subFolders;


    public function __construct()
    {
        $this->tblFichiers = new ArrayCollection();
        $this->subFolders = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }


    public function getRang(): ?int
    {
        return $this->rang;
    }

    public function setRang(?int $rang): static
    {
        $this->rang = $rang;

        return $this;
    }

    /**
     * @return Collection<int, TblFichiers>
     */
    public function getTblFichiers(): Collection
    {
        return $this->tblFichiers;
    }

    public function addTblFichier(TblFichiers $tblFichier): static
    {
        if (!$this->tblFichiers->contains($tblFichier)) {
            $this->tblFichiers->add($tblFichier);
            $tblFichier->setPath($this);
        }

        return $this;
    }

    public function removeTblFichier(TblFichiers $tblFichier): static
    {
        if ($this->tblFichiers->removeElement($tblFichier)) {
            // set the owning side to null (unless already changed)
            if ($tblFichier->getPath() === $this) {
                $tblFichier->setPath(null);
            }
        }

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUploadedAt(): ?\DateTimeImmutable
    {
        return $this->uploadedAt;
    }

    public function setUploadedAt(?\DateTimeImmutable $uploadedAt): static
    {
        $this->uploadedAt = $uploadedAt;

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

    public function getDirectory(): ?self
    {
        return $this->directory;
    }

    public function setDirectory(?self $directory): static
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubFolders(): Collection
    {
        return $this->subFolders;
    }

    public function addSubFolder(self $subFolder): static
    {
        if (!$this->subFolders->contains($subFolder)) {
            $this->subFolders->add($subFolder);
            $subFolder->setDirectory($this);
        }

        return $this;
    }

    public function removeSubFolder(self $subFolder): static
    {
        if ($this->subFolders->removeElement($subFolder)) {
            // set the owning side to null (unless already changed)
            if ($subFolder->getDirectory() === $this) {
                $subFolder->setDirectory(null);
            }
        }

        return $this;
    }


}
