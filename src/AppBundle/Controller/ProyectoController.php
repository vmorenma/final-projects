<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mensaje;
use AppBundle\Form\MensajeType;
use AppBundle\Form\ProyectoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Notificacion;
use AppBundle\Entity\Proyecto;
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
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $m = $this->getDoctrine()->getManager();
        $repo = $m->getRepository('AppBundle:Proyecto');
        $proyectos = $repo->findAll();

        return $this->render(':proyecto:proyectos.html.twig',
            [
                'proyectos' => $proyectos,
            ]
        );
    }

    /**
     * @Route("/nuevo", name="app_proyecto_nuevo")
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function nuevoAction(Request $request)
    {
        $p =  new Proyecto();
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->get('security.token_storage')->getToken()->getUser();

        //set creador
        $p->setAutor($user);
        $p->asignarAEquipo($user);
        $user->addToProyectos($p);

        $form = $this->createForm(ProyectoType::class,$p);
        $form->handleRequest($request);
        if($form->isValid()){
            $m = $this->getDoctrine()->getManager();
            $m->persist($p);
            $m->flush();
            return $this ->redirectToRoute('app_proyecto_index');

        }
        return $this->render('proyecto/form.html.twig',
            [
                'form' =>$form->createView(),
                'action' => $this->generateUrl('app_proyecto_nuevo')
            ]
        );
    }
    /**
     * @Route("/editar/{id}", name="app_proyecto_editar")
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function editarAction($id, Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $m= $this->getDoctrine()->getManager();
        $repo= $m->getRepository('AppBundle:Proyecto');
        $p= $repo->find($id);
        $form=$this->createForm(ProyectoType::class,$p);

        //El producto es actualizado con los estos datos
        $form->handleRequest($request);
        $p->setUpdatedAt();

        if($form->isValid()){
            $m->flush();

            return $this->redirectToRoute('app_proyecto_mostrar',['id'=>$id]);
        }

        return $this->render(':proyecto:form.html.twig',
            [
                'form'=> $form->createView(),
                'action'=> $this->generateUrl('app_proyecto_editar',['id'=>$id]),
            ]

        );

    }
    /**
     * @Route("/borrar/{id}", name="app_proyecto_borrar")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function borrarAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $m= $this->getDoctrine()->getManager();
        $repo= $m->getRepository('AppBundle:Proyecto');
        $p = $repo->find($id);

        //$creator= $planificacion->getCreador().$id;
        //$current = $this->getUser().$id;
        //if (($current!=$creator)&&(!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN'))) {
        //    throw $this->createAccessDeniedException();
        //}
        $m->remove($p);
        $m->flush();

        return $this->redirectToRoute('app_proyecto_index');
    }
    /**
     * @Route("/mostrar/{id}", name="app_proyecto_mostrar")
     */
    public function showAction($id, Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $m = $this->getDoctrine()->getManager();
        $repository= $m->getRepository('AppBundle:Proyecto');
        $p=$repository->find($id);
        $mensaje= new Mensaje();

        $user=$this->get('security.token_storage')->getToken()->getUser();
        $mensaje->setAutorMensaje($user);

        $mensaje->setProyecto($p);
        $form = $this->createForm(MensajeType::class,$mensaje);
        $form->handleRequest($request);
        if($form->isValid()){
            $m = $this->getDoctrine()->getManager();

            $m->persist($mensaje);
            $m->flush();
            return $this ->redirectToRoute('app_proyecto_mostrar',['id' => $id]);

        }


        return $this->render(':proyecto:proyecto.html.twig', [
            'proyecto'   => $p,
            'contactosdelUsuario' => $user->getMisContactos(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/notificacion-equipo/{id}/{projectid}", name="app_proyecto_notificacion_equipo")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addtoTeamNotificationAction($id,$projectid,Request $request)
    {
        $team_noti =  new Notificacion();
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->get('security.token_storage')->getToken()->getUser();

        //set creador
        $team_noti->setSender($user);

        //set target
        $m = $this->getDoctrine()->getManager();
        $repositorio =$m->getRepository('UserBundle:User');
        $repositorio_proyecto =$m->getRepository('AppBundle:Proyecto');
        $target_user= $repositorio->find($id);
        $proyecto= $repositorio_proyecto->find($projectid);
        $team_noti->setTarget($target_user);

        //set motivo
        $team_noti->setMotivo(3);

        //set proyecto
        $team_noti->setProyecto($proyecto);
        $m = $this->getDoctrine()->getManager();
        $m->persist($team_noti);
        $m->flush();
        return $this ->redirectToRoute('app_proyecto_mostrar',['id'=>$projectid]);
    }

    /**
     * @Route("/borrarMensaje/{id}/{projectid}", name="app_proyecto_borrarMensaje")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function borrarMensajeAction($id ,$projectid)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $m= $this->getDoctrine()->getManager();
        $repo= $m->getRepository('AppBundle:Mensaje');
        $mensaje = $repo->find($id);

        $creator= $mensaje->getAutorMensaje().$id;
        $current = $this->getUser().$id;
        if (($current!=$creator)&&(!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN'))) {
            throw $this->createAccessDeniedException();
        }
        $m->remove($mensaje);
        $m->flush();

        return $this->redirectToRoute('app_proyecto_mostrar',['id'=>$projectid]);
    }
    /**
     * @Route("/borrar-contacto/{id}", name="app_proyecto_borrarContacto")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function borrarContactoAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $m= $this->getDoctrine()->getManager();
        $repo= $m->getRepository('UserBundle:User');
        $contactoaEliminar = $repo->find($id);

        $user->getMisContactos()->removeElement($contactoaEliminar);
        $user->getContactosConmigo()->removeElement($contactoaEliminar);

        //$creator= $planificacion->getCreador().$id;
        //$current = $this->getUser().$id;
        //if (($current!=$creator)&&(!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN'))) {
        //    throw $this->createAccessDeniedException();
        //}
        $m->persist($contactoaEliminar);
        $m->persist($user);
        $m->flush();

        return $this->redirectToRoute('app_perfil_index');
    }




}
