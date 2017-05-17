<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Proyecto
 *
 * @ORM\Table(name="proyecto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProyectoRepository")
 */
class Proyecto
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
     *
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="Descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="Categoria", type="string", length=255)
     */
    private $categoria;

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
     * @ORM\ManyToOne(targetEntity="Trascastro\UserBundle\Entity\User", inversedBy="proyectosCreados")
     */
    private $autor;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Tarea" , mappedBy="proyecto", cascade={"remove"})
     */
    private $tareas;

    /**
     * @ORM\ManyToMany(targetEntity="Trascastro\UserBundle\Entity\User", mappedBy="proyectos")
     */
    private $equipo;
    /**
     * Proyecto constructor.
     */

    public function __construct()
    {
        $this->equipo = new ArrayCollection();
        $this->tareas = new ArrayCollection();
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
     * @return Proyecto
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
     * @return Proyecto
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
     * Set categoria
     *
     * @param string $categoria
     *
     * @return Proyecto
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return string
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Proyecto
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
     * @return Proyecto
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();

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
     * @return mixed
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param mixed $autor
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;
    }

    /**
     * @return mixed
     */
    public function getTareas()
    {
        return $this->tareas;
    }

    /**
     * @param mixed $tareas
     */
    public function setTareas($tareas)
    {
        $this->tareas = $tareas;
    }

    /**
     * @return mixed
     */
    public function getEquipo()
    {
        return $this->equipo;
    }

    /**
     * @param mixed $equipo
     */
    public function setEquipo($equipo)
    {
        $this->equipo = $equipo;
    }

    /**
     * @param mixed $persona
     */
    public function asignarAEquipo($persona)
    {
        $this->equipo->add($persona);
    }


}

