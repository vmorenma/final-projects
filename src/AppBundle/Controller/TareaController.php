<?php

namespace AppBundle\Controller;

use ADesigns\CalendarBundle\Entity\EventEntity;
use ADesigns\CalendarBundle\Event\CalendarEvent;
use AppBundle\AppBundle;
use AppBundle\Entity\Image;
use AppBundle\Entity\Proyecto;
use AppBundle\Entity\Tarea;
use AppBundle\EventListener\CalendarEventListener;
use AppBundle\Form\ImageType;
use AppBundle\Form\TareaType;
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
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $m = $this->getDoctrine()->getManager();
        $repo=$m->getRepository('AppBundle:Tarea');
        $tareas = $repo->findAll();


        return $this->render(':tarea:tareas.html.twig',
            [
                'tareas'=> $tareas,
            ]
        );
    }

    /**
     * @Route ("/nueva/{id}",name="app_tarea_nueva")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function nuevaAction($id,Request $request)
    {
        $tarea =  new Tarea();
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $m = $this->getDoctrine()->getManager();
        $repo = $m->getRepository('AppBundle:Proyecto');
        $p = $repo->find($id);
        //set proyecto
        $tarea->setProyecto($p);
        $form = $this->createForm(TareaType::class,$tarea);
        $form->handleRequest($request);
        if($form->isValid()){
            $event= new CalendarEvent($tarea->getStartDate(),$tarea->getEndDate(),$request);
            $eventListener = new CalendarEventListener($m);
            $eventListener->loadEvents($event);
            $m->persist($tarea);
            $m->flush();
            return $this ->redirectToRoute('app_proyecto_mostrar',['id'=>$id]);

        }

        return $this->render('tarea/form.html.twig',
            [
                'form' =>$form->createView(),
                'action' => $this->generateUrl('app_tarea_nueva',['id'=>$id])
            ]
        );
    }
    /**
     * @Route("/borrar/{id}", name="app_tarea_borrar")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function borrarAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $m= $this->getDoctrine()->getManager();
        $repo= $m->getRepository('AppBundle:Tarea');
        $t = $repo->find($id);
        $idproyecto = $t->getProyecto()->getId();

        $m->remove($t);
        $m->flush();

        return $this->redirectToRoute('app_proyecto_mostrar',['id'=>$idproyecto]);
    }
}
