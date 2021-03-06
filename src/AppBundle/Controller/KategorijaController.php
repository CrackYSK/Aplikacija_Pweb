<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Kategorija;
use AppBundle\Form\KategorijaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\User;



/**
 * Class KategorijaController
 * @package AppBundle\Controller
 * @Route("/admin/kategorija")
 */
class KategorijaController extends BaseController
{
    /**
     * @Route("/", name="kategorija_sve" )
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $admin = in_array('ROLE_ADMIN', $user->getRoles()) ? true: false;
        $kategorije = $this->getRepository('AppBundle:Kategorija')->findAll();
        return $this->render('AppBundle:Kategorija:index.html.twig', array(
            'kategorije' => $kategorije,
            'admin' => $admin));
    }

    /**
     * @Route("/nova", name="kategorija_nova")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
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
     * @Route("/nova", name="kategorija_insert")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function insertAction(Request $request)
    {
        $form = $this->createForm(KategorijaType::class, new Kategorija());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persist($form->getData());
            return $this->redirectToRoute('kategorija_sve');
        } else {
            return $this->render('AppBundle:Kategorija:new.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @Route("/{id}/izmeni", name="kategorija_edit")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction($id)
    {
        $kategorija = $this->getRepository('AppBundle:Kategorija')->find($id);
        $form = $this->createForm(KategorijaType::class, $kategorija, array(
            'action' => $this->generateUrl('kategorija_update', array('id' => $id)),
        ));

        return $this->render('AppBundle:Kategorija:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/izmeni", name="kategorija_update")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function updateAction($id, Request $request)
    {
        $kategorija = $this->getRepository('AppBundle:Kategorija')->find($id);
        $form = $this->createForm(KategorijaType::class, $kategorija);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persist($form->getData());
            return $this->redirectToRoute('kategorija_sve');
        } else {
            return $this->render('AppBundle:Kategorija:edit.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @Route("/{id}/obrisi", name="kategorija_delete")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $katerorija = $em->getRepository('AppBundle:Kategorija')->findOneById($id);
        $em->remove($katerorija);
        $em->flush();

        return $this->redirect($this->generateUrl('kategorija_sve'));
    }
}
