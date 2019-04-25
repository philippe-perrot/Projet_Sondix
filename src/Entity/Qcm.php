<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;


/**
 * @ORM\Entity(repositoryClass="App\Repository\QcmRepository")
 */
class Qcm
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id_qcm;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_qcm;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $etat_qcm = false;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;
    
    public function __construct() {
        $this->date_creation = new \DateTime();
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

    public function getNomQcm(): ?string
    {
        return $this->nom_qcm;
    }

    public function setNomQcm(string $nom_qcm): self
    {
        $this->nom_qcm = $nom_qcm;

        return $this;
    }
    
    public function getSlug(): string 
    {
        return (new Slugify())->slugify($this->nom_qcm);
    }

    public function getEtatQcm(): ?bool
    {
        return $this->etat_qcm;
    }

    public function setEtatQcm(bool $etat_qcm): self
    {
        $this->etat_qcm = $etat_qcm;

        return $this;
    }
    
    public function getDate_Creation()
    {
        return $this->date_creation;
    }
    
    public function setDate_Creation(\DateTime $date_creation)
    {
        $this->date_creation = $date_creation;
        
        return $this;
    }

}
