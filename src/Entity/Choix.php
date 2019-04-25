<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChoixRepository")
 */
class Choix
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
    private $id_resultat;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_question;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_reponse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdResultat(): ?int
    {
        return $this->id_resultat;
    }

    public function setIdResultat(int $id_resultat): self
    {
        $this->id_resultat = $id_resultat;

        return $this;
    }

    public function getIdQuestion(): ?int
    {
        return $this->id_question;
    }

    public function setIdQuestion(int $id_question): self
    {
        $this->id_question = $id_question;

        return $this;
    }

    public function getIdReponse(): ?int
    {
        return $this->id_reponse;
    }

    public function setIdReponse(int $id_reponse): self
    {
        $this->id_reponse = $id_reponse;

        return $this;
    }
}
