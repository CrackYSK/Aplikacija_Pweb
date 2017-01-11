<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Kategorija;
use AppBundle\Form\KategorijaType;
use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class KategorijaController
 * @package AppBundle\Controller
 * @Route("/kategorija1")
 */
class KategorijaController extends BaseController
{
    /**
     * @Route("/", name="kategorija_sve" )
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Kategorija:index.html.twig', array(// ...
        ));
    }

    /**
     * @Route("/new", name="kategorija_nova")
     * @Method("GET")
     */
    public function newAction()
    {
        $form = $this->createForm(KategorijaType::class, new Kategorija(), array(
            'action' => $this->generateUrl('kategorija_insert'),
        ));

        return $this->render('AppBundle:Kategorija:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/new", name="kategorija_insert")
     * @Method("POST")
     */
    public function insertAction(Request $request)
    {
        $form = $this->createForm(KategorijaType::class, new Kategorija());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persist($form->getData());
            return $this->forward('AppBundle:Kategorija:index', array('success' => true));
        } else {
            return $this->render('AppBundle:Kategorija:new.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @Route("/{id}/edit", name="kategorija_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        return $this->render('AppBundle:Kategorija:edit.html.twig', array(// ...
        ));
    }

    /**
     * @Route("/{id}/edit", name="kategorija_update")
     * @Method("POST")
     */
    public function updateAction($id)
    {
        return $this->render('AppBundle:Kategorija:update.html.twig', array(// ...
        ));
    }

}
