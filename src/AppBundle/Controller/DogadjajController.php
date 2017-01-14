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
 * @Route("/admin/dogadjaj")
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
     * @Route("/nova", name="dogadjaj_novi")
     * @Method("GET")
     */
    public function newAction()
    {

        $form = $this->createForm(DogadjajType::class, new Dogadjaj(), array(
            'action' => $this->generateUrl('dogadjaj_insert'),
            'manager' => $this->getDoctrine()->getManager()
        ));

        return $this->render('AppBundle:Dogadjaj:new.html.twig', array(
            'form' => $form->createView(),

        ));
    }

    /**
     * @Route("/nova", name="dogadjaj_insert")
     * @Method("POST")
     */
    public function insertAction(Request $request)
    {
        $form = $this->createForm(DogadjajType::class, new Dogadjaj(), array(
            'manager' => $this->getDoctrine()->getManager()
        ));
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
     * @Route("/{id}/izmeni", name="dogadjaj_dohvati")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $dogadjaj = $this->getRepository('AppBundle:Dogadjaj')->find($id);
        $form = $this->createForm(DogadjajType::class, $dogadjaj, array(
            'action' => $this->generateUrl('dogadjaj_izmeni', array('id' => $id)),
            'manager' => $this->getDoctrine()->getManager()
        ));

        return $this->render('AppBundle:Dogadjaj:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/izmeni", name="dogadjaj_izmeni")
     * @Method("POST")
     */
    public function updateAction($id, Request $request)
    {
        $dogadjaj = $this->getRepository('AppBundle:Dogadjaj')->find($id);
        $form = $this->createForm(DogadjajType::class, $dogadjaj, array(
            'manager' => $this->getDoctrine()->getManager()
        ));
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
     * @Route("/{id}/obrisi", name="dogadjaj_obrisi")
     * @Method("POST")
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $dogadjaj = $em->getRepository('AppBundle:Dogadjaj')->findOneById($id);
        $em->remove($dogadjaj);
        $em->flush();

        return $this->redirect($this->generateUrl('dogadjaj_sve'));
    }

    /**
     * @Route("/{id}/details", name="dogadjaj_detaljno")
     * @Method("GET")
     */
    public function showAction($id)
    {

        $repository = $this->getRepository('AppBundle:Takmicenje');
        $takmicenja = $repository->findBy(
            array('dogadjaj' => $id));

        $repository = $this->getRepository('AppBundle:SmotraRadova');
        $smotra = $repository->findOneBy(
            array('dogadjaj' => $id));

        $repository = $this->getRepository('AppBundle:Dogadjaj');
        $dogadjaj=$repository->findOneById(
            array('id'=>$id));

        $repository = $this->getRepository('AppBundle:Rad');
        if ($smotra) {
            $radovi = $repository->findBy(
                array('smotraRadova' => $smotra));
            return $this->render('AppBundle:Dogadjaj:show.html.twig',
                array('dogadjaj' => $dogadjaj, 'takmicenja' => $takmicenja, 'smotra'=>$smotra, 'radovi'=>$radovi));

        }
        return $this->render('AppBundle:Dogadjaj:show.html.twig',
            array('dogadjaj' => $dogadjaj, 'takmicenja' => $takmicenja, 'smotra'=>$smotra));
    }

}