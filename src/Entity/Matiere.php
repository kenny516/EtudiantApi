<?php
namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
class Matiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $codeMatiere = null;

    #[ORM\ManyToOne(targetEntity: Semestre::class, inversedBy: 'matieres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Semestre $semestre = null;

    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    #[ORM\Column]
    private ?int $credits = null;

    #[ORM\Column]
    private ?int $coefficient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeMatiere(): ?string
    {
        return $this->codeMatiere;
    }

    public function setCodeMatiere(string $codeMatiere): static
    {
        $this->codeMatiere = $codeMatiere;

        return $this;
    }

    public function getSemestre(): ?Semestre
    {
        return $this->semestre;
    }

    public function setSemestre(?Semestre $semestre): static
    {
        $this->semestre = $semestre;

        return $this;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): static
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getCredits(): ?int
    {
        return $this->credits;
    }

    public function setCredits(int $credits): static
    {
        $this->credits = $credits;

        return $this;
    }

    public function getCoefficient(): ?int
    {
        return $this->coefficient;
    }

    public function setCoefficient(int $coefficient): static
    {
        $this->coefficient = $coefficient;

        return $this;
    }
}
