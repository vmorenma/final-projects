<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notificacion;
use AppBundle\Form\NotificacionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PerfilController extends Controller
{
    /**
     * @Route("/", name="app_perfil_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $usuario =  $this->get('security.token_storage')->getToken()->getUser();
        $añadido = false;


        return $this->render('perfil/perfil.html.twig',
            [
                'usuario'=> $usuario,
                'added'=> $añadido
            ]
        );
    }
    /**
     * @Route("/mostrar/{id}", name="app_perfil_mostrar")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mostrarAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repositorio =$m->getRepository('UserBundle:User');
        $usuario = $repositorio->find($id);
        $current_user=$this->get('security.token_storage')->getToken()->getUser();
        $contactos =$current_user->getMisContactos();
        $añadido = false;
        if($contactos->contains($usuario)){
            $añadido= true;
        }

        return $this->render('perfil/perfil.html.twig',
            [
                'usuario'=> $usuario,
                'added'=> $añadido
            ]
        );
    }
    /**
     * @Route("/notificacion/{id}", name="app_perfil_notificacion")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addfriendnotificationAction($id,Request $request)
    {
        $notificacion_enviada = false;
        $friend_noti =  new Notificacion();
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->get('security.token_storage')->getToken()->getUser();

        //set creador
        $friend_noti->setSender($user);


        //set target
        $m = $this->getDoctrine()->getManager();
        $repositorio =$m->getRepository('UserBundle:User');
        $target_user= $repositorio->find($id);
        $friend_noti->setTarget($target_user);

        //set motivo
        $friend_noti->setMotivo(1);

        //check notifications of friendship
        $notificaciones = $target_user->getNotificacionesRecibidas();
        foreach ( $notificaciones as $n){
            if ($n->getMotivo()==1 && $n->getTarget()==$target_user){
                $notificacion_enviada=true;

            }
        }

        if ($notificacion_enviada){
            return $this ->redirectToRoute('app_perfil_mostrar',['id'=>$id]);
        }
        $form = $this->createForm(NotificacionType::class,$friend_noti);
        $form->handleRequest($request);
        if($form->isValid()){
            $m = $this->getDoctrine()->getManager();
            $m->persist($friend_noti);
            $m->flush();
            return $this ->redirectToRoute('app_perfil_mostrar',['id'=>$id]);

        }
        return $this->render('notificacion/form.html.twig',
            [
                'form' =>$form->createView(),
                'action' => $this->generateUrl('app_perfil_notificacion',['id'=>$id])
            ]
        );
    }
    /**
     * @Route("/mensaje/{id}", name="app_perfil_mensaje")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mesageNotificationAction($id,Request $request)
    {
        $m_noti =  new Notificacion();
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->get('security.token_storage')->getToken()->getUser();

        //set creador
        $m_noti->setSender($user);


        //set target
        $m = $this->getDoctrine()->getManager();
        $repositorio =$m->getRepository('UserBundle:User');
        $target_user= $repositorio->find($id);
        $m_noti->setTarget($target_user);

        //set motivo
        $m_noti->setMotivo(2);

        $form = $this->createForm(NotificacionType::class,$m_noti);
        $form->handleRequest($request);
        if($form->isValid()){
            $m = $this->getDoctrine()->getManager();
            $m->persist($m_noti);
            $m->flush();
            return $this ->redirectToRoute('app_perfil_mostrar',['id'=>$id]);

        }
        return $this->render('notificacion/form.html.twig',
            [
                'form' =>$form->createView(),
                'action' => $this->generateUrl('app_perfil_mensaje',['id'=>$id])
            ]
        );
    }


}
