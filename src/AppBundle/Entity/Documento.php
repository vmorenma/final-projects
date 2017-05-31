<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 30/05/17
 * Time: 18:31
 */

// src/AppBundle/Entity/Documento.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Documento
 *
 * @ORM\Table(name="documento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentoRepository")
 *
 */
class Documento
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the document brochure as a PDF file.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $brochure;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Proyecto", inversedBy="documentos")
     */
    private $proyecto;

    public function getBrochure()
    {
        return $this->brochure;
    }

    public function setBrochure($brochure)
    {
        $this->brochure = $brochure;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getProyecto()
    {
        return $this->proyecto;
    }

    /**
     * @param mixed $proyecto
     */
    public function setProyecto($proyecto)
    {
        $this->proyecto = $proyecto;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }



}