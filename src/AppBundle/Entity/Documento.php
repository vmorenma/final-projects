<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Documento
 *
 * @ORM\Table(name="documento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentoRepository")
 */
class Documento
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var File
     *
     */
    private $documentoFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $documento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="time")
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="time")
     */
    private $createdAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set documentoFile
     *
     * @param string $documentoFile
     *
     * @return Documento
     */
    public function setDocumentoFile(File $documentoFile = null)
    {
        $this->setDocumentoFile($documentoFile);
        if ($documentoFile) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * Get documentoFile
     *
     * @return string
     */
    public function getDocumentoFile()
    {
        return $this->documentoFile;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Documento
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Documento
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * @param mixed $documento
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }

    public function getDocument()
    {
        return $this->documento;
    }


}

