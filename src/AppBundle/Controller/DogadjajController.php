<?php
/**
 * Created by PhpStorm.
 * User: kolibri
 * Date: 12.1.17.
 * Time: 15.23
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Dogadjaj;
use AppBundle\Form\DogadjajType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class DogadjajController
 * @package AppBundle\Controller
 * @Route("/dogadjaj")
 */
class DogadjajController extends BaseController
{
    /**
     * @Route("/", name="dogadjaj_sve" )
     */

    public function indexAction()
    {
        $dogadjaji = $this->getRepository('AppBundle:Dogadjaj')->findAll();
        return $this->render('AppBundle:Dogadjaj:index.html.twig', array('dogadjaji' => $dogadjaji));
    }

    /**
     * @Route("/new", name="dogadjaj_novi")
     * @Method("GET")
     */
    public function newAction()
    {
        $form = $this->createForm(DogadjajType::class, new Dogadjaj(), array(
            'action' => $this->generateUrl('dogadjaj_insert'),
        ));

        return $this->render('AppBundle:Dogadjaj:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/new", name="dogadjaj_insert")
     * @Method("POST")
     */
    public function insertAction(Request $request)
    {
        $form = $this->createForm(DogadjajType::class, new Dogadjaj());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persist($form->getData());
            return $this->forward('AppBundle:Dogadjaj:index', array('success' => true));
        } else {
            return $this->render('AppBundle:Dogadjaj:new.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }


    /**
     * @Route("/{id}/edit", name="dogadjaj_dohvati")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $dogadjaj = $this->getRepository('AppBundle:Dogadjaj')->find($id);
        $form = $this->createForm(DogadjajType::class, $dogadjaj, array(
            'action' => $this->generateUrl('dogadjaj_izmeni', array('id' => $id)),
        ));

        return $this->render('AppBundle:Dogadjaj:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="dogadjaj_izmeni")
     * @Method("POST")
     */
    public function updateAction($id, Request $request)
    {
        $dogadjaj = $this->getRepository('AppBundle:Dogadjaj')->find($id);
        $form = $this->createForm(DogadjajType::class, $dogadjaj);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persist($form->getData());
            return $this->forward('AppBundle:Dogadjaj:index', array('success' => true));
        } else {
            return $this->render('AppBundle:Dogadjaj:edit.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }


    /**
     * @Route("/{id}/delete", name="dogadjaj_obrisi")
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        return $this->render('AppBundle:Dogadjaj:delete.html.twig', array(// ...
        ));
    }

    /**
     * @Route("/{id}", name="kategorija_show")
     */

    public function showAction($id)
    {
        return $this->render('AppBundle:Kategorija:show.html.twig', array(// ...
        ));
    }

}