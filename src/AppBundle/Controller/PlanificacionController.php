<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Image;
use AppBundle\Entity\Proyecto;
use AppBundle\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PlanificacionController extends Controller
{
    /**
     * @Route("/", name="app_planificacion_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repo=$m->getRepository('AppBundle:Planificacion');
        $planificaciones = $repo->findAll();

        return $this->render(':planificacion:planificaciones.html.twig',
            [
                'planificaciones'=> $planificaciones,
            ]
        );
    }
}
