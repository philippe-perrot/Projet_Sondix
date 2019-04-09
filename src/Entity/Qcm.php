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
    private $validation_qcm = false;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;
    
    public function __construct() {
        $this->created_at = new \DateTime();
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

    public function getValidationQcm(): ?bool
    {
        return $this->validation_qcm;
    }

    public function setValidationQcm(bool $validation_qcm): self
    {
        $this->validation_qcm = $validation_qcm;

        return $this;
    }
    
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    
    public function setCreatedAt(\DateTime $created_at)
    {
        $this->created_at = $created_at;
        
        return $this;
    }

}
