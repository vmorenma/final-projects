<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Planificacion;
use AppBundle\Form\PlanificacionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Image;
use AppBundle\Entity\Proyecto;
use AppBundle\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PlanificacionController extends Controller
{
    /**
     * @Route("/", name="app_planificacion_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repo = $m->getRepository('AppBundle:Planificacion');
        $planificaciones = $repo->findAll();

        return $this->render(':planificacion:planificaciones.html.twig',
            [
                'planificaciones' => $planificaciones,
            ]
        );
    }

    /**
     * @Route("/nueva", name="app_planificacion_nueva")
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function nuevaAction(Request $request)
    {
        $pla =  new Planificacion();
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->get('security.token_storage')->getToken()->getUser();

        //set creador
        //$pla->setCreador($user);

        $form = $this->createForm(PlanificacionType::class,$pla);
        $form->handleRequest($request);
        if($form->isValid()){
            $m = $this->getDoctrine()->getManager();
            $m->persist($pla);
            $m->flush();
            return $this ->redirectToRoute('app_planificacion_index');

        }
        return $this->render('planificacion/form.html.twig',
            [
                'form' =>$form->createView(),
                'action' => $this->generateUrl('app_planificacion_nueva')
            ]
        );
    }

}
