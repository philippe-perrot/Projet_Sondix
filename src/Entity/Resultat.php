<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultatRepository")
 */
class Resultat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_personne;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_qcm;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $score;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPersonne(): ?int
    {
        return $this->id_personne;
    }

    public function setIdPersonne(int $id_personne): self
    {
        $this->id_personne = $id_personne;

        return $this;
    }

    public function getIdQcm(): ?int
    {
        return $this->id_qcm;
    }

    public function setIdQcm(int $id_qcm): self
    {
        $this->id_qcm = $id_qcm;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }
}
