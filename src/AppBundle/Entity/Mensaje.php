<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mensaje
 *
 * @ORM\Table(name="mensaje")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MensajeRepository")
 */
class Mensaje
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
     * @ORM\Column(name="contenido", type="string", length=255)
     */
    private $contenido;

    /**
     * @var int
     * @Assert\NotBlank()
     * @ORM\Column(name="likes", type="integer")
     */
    private $likes;

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
     * @ORM\ManyToOne(targetEntity="Trascastro\UserBundle\Entity\User", inversedBy="mensajesCreados")
     */
    private $autorMensaje;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Proyecto", inversedBy="mensajes")
     */
    private $proyecto;

    public function __construct()
    {
        $this->setLikes(0);
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
     * Set contenido
     *
     * @param string $contenido
     *
     * @return Mensaje
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     *
     * @return Mensaje
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return int
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Mensaje
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
     * @return Mensaje
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
    public function getAutorMensaje()
    {
        return $this->autorMensaje;
    }

    /**
     * @param mixed $autorMensaje
     */
    public function setAutorMensaje($autorMensaje)
    {
        $this->autorMensaje = $autorMensaje;
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


}

