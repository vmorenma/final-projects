<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Entity\Proyecto;
use AppBundle\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TareaController extends Controller
{
    /**
     * @Route("/", name="app_tarea_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repo=$m->getRepository('AppBundle:Tarea');
        $tareas = $repo->findAll();

        return $this->render(':tarea:tareas.html.twig',
            [
                'tareas'=> $tareas,
            ]
        );
    }
}
