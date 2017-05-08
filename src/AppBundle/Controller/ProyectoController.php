<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Image;
use AppBundle\Entity\Proyecto;
use AppBundle\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProyectoController extends Controller
{
    /**
     * @Route("/", name="app_proyecto_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repo=$m->getRepository('AppBundle:Proyecto');
        $proyectos = $repo->findAll();

        return $this->render(':proyecto:proyectos.html.twig',
            [
                'proyectos'=> $proyectos,
            ]
        );
    }

}
