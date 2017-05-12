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
        $usuario =  $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('perfil/perfil.html.twig',
            [
                'usuario'=> $usuario,
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

        return $this->render('perfil/perfil.html.twig',
            [
                'usuario'=> $usuario,
            ]
        );
    }
}
