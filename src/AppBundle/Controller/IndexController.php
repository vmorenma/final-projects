<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Documento;
use AppBundle\Form\DocumentoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class IndexController extends Controller
{
    /**
     * @Route("/", name="app_index_index")
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render(':index:index.html.twig');
        }
        return $this ->redirectToRoute('app_proyecto_index');
    }

    /**
     * @Route("/upload/{id}", name="app_index_upload")
     */
    public function uploadAction($id,Request $request)
    {
        $documento = new Documento();
        $form = $this->createForm(DocumentoType::class, $documento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $m = $this->getDoctrine()->getManager();
            $repo = $m->getRepository('AppBundle:Proyecto');
            $proyecto = $repo->find($id);

            // $file stores the uploaded PDF file
            /** @var UploadedFile $file */
            $file = $documento->getBrochure();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            $documento->setBrochure($fileName);
            $documento->setProyecto($proyecto);
            $m->persist($documento);
            $m->flush();

            return $this->redirect($this->generateUrl('app_proyecto_mostrar',['id'=> $id]));
        }

        return $this->render('index/upload.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/buscarUsuario", name="app_index_buscarUsuario")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
        $busqueda = $_POST['busqueda'];
        if ($busqueda==''){
            return $this->redirectToRoute('app_index_index');
        }
        return $this->redirectToRoute('app_index_busqueda_show', ['palabra' => $busqueda]);
    }
    /**
     * @Route("/busquedaPorUsuario/{palabra}", name="app_index_busqueda_show")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function textoPalabraAction($palabra, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $usuarios =$em->getRepository('UserBundle:User')->buscarUsuario($palabra);
        return $this->render(':buscar:busquedaUsuario.html.twig',
            [
                'usuarios' => $usuarios,
            ]
        );
    }
}
