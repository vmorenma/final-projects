<?php

namespace AppBundle\Controller;

use ADesigns\CalendarBundle\Entity\EventEntity;
use ADesigns\CalendarBundle\Event\CalendarEvent;
use AppBundle\AppBundle;
use AppBundle\Entity\Image;
use AppBundle\Entity\Notificacion;
use AppBundle\Entity\Proyecto;
use AppBundle\Entity\Tarea;
use AppBundle\EventListener\CalendarEventListener;
use AppBundle\Form\ImageType;
use AppBundle\Form\TareaType;
use Doctrine\Common\Collections\ArrayCollection;
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
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $tareas = $user->getTareasassignadas();


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
    /**
     * @Route ("/completar/{id}", name="app_tarea_completar")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function completarAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $m=$this->getDoctrine()->getManager();
        $repo = $m->getRepository('AppBundle:Tarea');
        $tarea = $repo->find($id);

        $tarea->setCompletada(!($tarea->getCompletada()));
        $m->persist($tarea);
        $m->flush();
        return $this->redirectToRoute('app_tarea_index');

    }
    /**
     * @Route ("/asignar/{id}/{tareaid}", name="app_tarea_asignar")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function asignarAction($id, $tareaid)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $sender = $this->get('security.token_storage')->getToken()->getUser();



        $m= $this->getDoctrine()->getManager();
        $repo =$m->getRepository('UserBundle:User');
        $repo_tareas= $m->getRepository('AppBundle:Tarea');
        $tarea =$repo_tareas->find($tareaid);
        $user=$repo->find($id);
        $proyecto=$tarea->getProyecto();

        $array_asignado = $tarea->getAssignado();
        $array_tareas = $user->getTareasassignadas();

        //añadir a asignado y tareasasignadas
        $array_asignado->add($user);
        $array_tareas->add($tarea);

        //asignar a tarea
        $tarea->setAssignado($array_asignado);
        $user->setTareasassignadas($array_tareas);

        //crear notificacion

        $add_noti= new Notificacion();
        $add_noti->setMotivo(4);
        $add_noti->setSender($sender);
        $add_noti->setTarget($user);
        $add_noti->setProyecto($proyecto);

        $m->persist($add_noti);
        $m->persist($tarea);
        $m->persist($user);
        $m->flush();
        return $this->redirectToRoute('app_proyecto_mostrar',['id'=>$proyecto->getId()]);
    }
    /**
     * @Route ("/borrarasignado/{id}/{tareaid}", name="app_tarea_borrarasignado")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function borrarAsignadoAction($id, $tareaid)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $sender = $this->get('security.token_storage')->getToken()->getUser();



        $m= $this->getDoctrine()->getManager();
        $repo =$m->getRepository('UserBundle:User');
        $repo_tareas= $m->getRepository('AppBundle:Tarea');
        $tarea =$repo_tareas->find($tareaid);
        $user=$repo->find($id);
        $proyecto=$tarea->getProyecto();

        $array_asignado = $tarea->getAssignado();
        $array_tareas = $user->getTareasassignadas();

        //añadir a asignado y tareasasignadas
        $array_asignado->removeElement($user);
        $array_tareas->removeElement($tarea);

        //asignar a tarea
        $tarea->setAssignado($array_asignado);
        $user->setTareasassignadas($array_tareas);

        $m->persist($tarea);
        $m->persist($user);
        $m->flush();
        return $this->redirectToRoute('app_proyecto_mostrar',['id'=>$proyecto->getId()]);
    }
}
