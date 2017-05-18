<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class NotificacionController extends Controller
{
    /**
     * @Route("/", name="app_notificacion_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
//        $m = $this->getDoctrine()->getManager();
//        $repo=$m->getRepository('AppBundle:Notificacion');
//        $repo = $m->getRepository('AppBundle:User');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $notificaciones = $user->getNotificacionesRecibidas();


        return $this->render(':notificacion:notificaciones.html.twig',
            [
                'notificaciones'=> $notificaciones,
            ]
        );
    }
    /**
     * @Route("/borrar/{id}", name="app_notificacion_borrar")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function borrarAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $m= $this->getDoctrine()->getManager();
        $repo= $m->getRepository('AppBundle:Notificacion');
        $notificacion = $repo->find($id);
        //$creator= $planificacion->getCreador().$id;
        //$current = $this->getUser().$id;
        //if (($current!=$creator)&&(!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN'))) {
        //    throw $this->createAccessDeniedException();
        //}
        $m->remove($notificacion);
        $m->flush();

        return $this->redirectToRoute('app_notificacion_index');
    }
    /**
     * @Route("/acceptar/{id}", name="app_notificacion_aceptar")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function aceptarAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $m= $this->getDoctrine()->getManager();
        $repo= $m->getRepository('AppBundle:Notificacion');
        $notificacion = $repo->find($id);
        $sender=$notificacion->getSender();
        $target=$notificacion->getTarget();
        //añadimos a amigos al objetivo
        $CC = $target->getContactosConmigo();
        $MC = $target->getMisContactos();
        $CC->add($sender);
        $MC->add($sender);
        $target->setContactosConmigo($CC);
        $target->setMisContactos($MC);

        //añadimos a amigos al remitente
        $CC = $sender->getContactosConmigo();
        $MC = $sender->getMisContactos();
        $CC->add($target);
        $MC->add($target);
        $sender->setContactosConmigo($CC);
        $sender->setMisContactos($MC);

        //$creator= $planificacion->getCreador().$id;
        //$current = $this->getUser().$id;
        //if (($current!=$creator)&&(!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN'))) {
        //    throw $this->createAccessDeniedException();
        //}
        $m->remove($notificacion);
        $m->flush();

        return $this->redirectToRoute('app_notificacion_index');
    }
}
