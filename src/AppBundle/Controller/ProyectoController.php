<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProyectoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

            return $this->redirectToRoute('app_proyecto_index');
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
    public function showAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository= $m->getRepository('AppBundle:Proyecto');
        $p=$repository->find($id);
        return $this->render(':proyecto:proyecto.html.twig', [
            'proyecto'   => $p,
        ]);
    }

    /**
     * @Route("/asignarcontacto/{id}",name="app_proyecto_asignarContacto")
     */
    /*
    public function asignarContacto($id, Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $m= $this->getDoctrine()->getManager();
        $repo= $m->getRepository('AppBundle:Proyecto');
        $p= $repo->find($id);
        $form=$this->createForm(EquipoType::class,$p);

        //El producto es actualizado con los estos datos
        $form->handleRequest($request);

        if($form->isValid()){
            $m->flush();

            return $this->redirectToRoute('app_proyecto_index');
        }

        return $this->render(':proyecto:form.html.twig',
            [
                'form'=> $form->createView(),
                'action'=> $this->generateUrl('app_proyecto_editar',['id'=>$id]),
            ]

        );




    }*/

}
