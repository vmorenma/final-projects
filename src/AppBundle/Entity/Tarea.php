<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tarea
 *
 * @ORM\Table(name="tarea")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TareaRepository")
 */
class Tarea
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
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="Descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @ORM\Column(name="startDate", type="date")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="date")
     */
    private $endDate;

    /**
     * @var int
     *@Assert\NotBlank()
     *@ORM\Column(name="coste", type="integer")
     */
    private $coste;

    /**
     * @var bool
     * @ORM\Column(name="completada", type="boolean")
     */
    private $completada;

    /**
     * @ORM\ManyToMany(targetEntity="Trascastro\UserBundle\Entity\User", inversedBy="tareasasignadas")
     */
    private $asignado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="time")
     */


    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="time")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Proyecto", inversedBy="tareas")
     */
    private $proyecto;



    /**
     * Tarea constructor.
     */

    public function __construct()
    {
        $this->completada = false;
        $this->asignado = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = $this->createdAt;

    }


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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Tarea
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Tarea
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Tarea
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Tarea
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Tarea
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Tarea
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
     * @return int
     */
    public function getCoste()
    {
        return $this->coste;
    }

    /**
     * @param int $coste
     */
    public function setCoste($coste)
    {
        $this->coste = $coste;
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
     * @return mixed
     */
    public function getCompletada()
    {
        return $this->completada;
    }

    /**
     * @param mixed $completada
     */
    public function setCompletada($completada)
    {
        $this->completada = $completada;
    }

    /**
     * @return mixed
     */
    public function getAsignado()
    {
        return $this->asignado;
    }

    /**
     * @param mixed $asignado
     */
    public function setAsignado($asignado)
    {
        $this->asignado = $asignado;
    }



}
