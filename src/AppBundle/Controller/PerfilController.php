<?php

namespace AppBundle\Controller;

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
}
