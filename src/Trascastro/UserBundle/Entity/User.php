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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Planificacion",mappedBy="creador")
     */

    private $planificacionesCreadas;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Proyecto",mappedBy="autor")
     */

    private $proyectosCreados;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Tarea", mappedBy="assignado")
     */
    private $tareasassignadas;

    /**
     * @ORM\ManyToMany (targetEntity="AppBundle\Entity\Proyecto", inversedBy="equipo")
     */
    private $proyectos;

    /**
     * User constructor.
     */



    public function __construct()
    {
        parent::__construct();

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
     * @return mixed
     */
    public function getPlanificacionesCreadas()
    {
        return $this->planificacionesCreadas;
    }

    /**
     * @param mixed $planificacionesCreadas
     */
    public function setPlanificacionesCreadas($planificacionesCreadas)
    {
        $this->planificacionesCreadas = $planificacionesCreadas;
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



}