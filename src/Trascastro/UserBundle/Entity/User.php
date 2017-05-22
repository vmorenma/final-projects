<?php
/**
 * (c) Ismael Trascastro <i.trascastro@gmail.com>
 *
 * @link        http://www.ismaeltrascastro.com
 * @copyright   Copyright (c) Ismael Trascastro. (http://www.ismaeltrascastro.com)
 * @license     MIT License - http://en.wikipedia.org/wiki/MIT_License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trascastro\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="app_user")
 * @ORM\Entity(repositoryClass="Trascastro\UserBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="upated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Proyecto",mappedBy="autor")
     */

    private $proyectosCreados;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Mensaje",mappedBy="autorMensaje")
     */

    private $mensajesCreados;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Tarea", mappedBy="assignado")
     */
    private $tareasassignadas;

    /**
     * @ORM\ManyToMany (targetEntity="AppBundle\Entity\Proyecto", inversedBy="equipo")
     */
    private $proyectos;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="misContactos")
     **/
    private $contactosConmigo;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="contactosConmigo")
     * @ORM\JoinTable(name="contactos",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="contacto_user_id", referencedColumnName="id")}
     *      )
     **/
    private $misContactos;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notificacion", mappedBy="sender")
     */
    private $notificacionesCreadas;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notificacion", mappedBy="target")
     */
    private $notificacionesRecibidas;

    /**
     * User constructor.
     */



    public function __construct()
    {
        parent::__construct();
        $this->contactosConmigo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->misContactos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt    = new \DateTime();
        $this->updatedAt    = $this->createdAt;
    }

    public function setCreatedAt()
    {
        // never used
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
     * @ORM\PreUpdate()
     *
     * @return User
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

    public function __toString()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getProyectosCreados()
    {
        return $this->proyectosCreados;
    }

    /**
     * @param mixed $proyectosCreados
     */
    public function setProyectosCreados($proyectosCreados)
    {
        $this->proyectosCreados = $proyectosCreados;
    }

    /**
     * @return mixed
     */
    public function getTareasassignadas()
    {
        return $this->tareasassignadas;
    }

    /**
     * @param mixed $tareasassignadas
     */
    public function setTareasassignadas($tareasassignadas)
    {
        $this->tareasassignadas = $tareasassignadas;
    }

    /**
     * @return mixed
     */
    public function getProyectos()
    {
        return $this->proyectos;
    }

    /**
     * @param mixed $proyectos
     */
    public function setProyectos($proyectos)
    {
        $this->proyectos = $proyectos;
    }

    public function addToProyectos($proyecto){
        $this->proyectos->add($proyecto);
    }

    /**
     * @return mixed
     */
    public function getContactosConmigo()
    {
        return $this->contactosConmigo;
    }

    /**
     * @param mixed $contactosConmigo
     */
    public function setContactosConmigo($contactosConmigo)
    {
        $this->contactosConmigo = $contactosConmigo;
    }

    /**
     * @return mixed
     */
    public function getMisContactos()
    {
        return $this->misContactos;
    }

    /**
     * @param mixed $misContactos
     */
    public function setMisContactos($misContactos)
    {
        $this->misContactos = $misContactos;
    }

    /**
     * @return mixed
     */
    public function getNotificacionesCreadas()
    {
        return $this->notificacionesCreadas;
    }

    /**
     * @param mixed $notificacionesCreadas
     */
    public function setNotificacionesCreadas($notificacionesCreadas)
    {
        $this->notificacionesCreadas = $notificacionesCreadas;
    }

    /**
     * @return mixed
     */
    public function getNotificacionesRecibidas()
    {
        return $this->notificacionesRecibidas;
    }

    /**
     * @param mixed $notificacionesRecibidas
     */
    public function setNotificacionesRecibidas($notificacionesRecibidas)
    {
        $this->notificacionesRecibidas = $notificacionesRecibidas;
    }

    /**
     * @return mixed
     */
    public function getMensajesCreados()
    {
        return $this->mensajesCreados;
    }

    /**
     * @param mixed $mensajesCreados
     */
    public function setMensajesCreados($mensajesCreados)
    {
        $this->mensajesCreados = $mensajesCreados;
    }



}