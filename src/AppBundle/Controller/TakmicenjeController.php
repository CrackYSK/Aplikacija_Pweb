<?php
/**
 * Created by PhpStorm.
 * User: kolibri
 * Date: 12.1.17.
 * Time: 19.09
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Takmicenje;
use AppBundle\Form\TakmicenjeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class TakmicenjeController
 * @package AppBundle\Controller
 * @Route("/admin/dogadjaj/takmicenje/detalji")
 */
class TakmicenjeController extends BaseController
{
    /**
     * @Route("/", name="takmicenje_sve" )
     */
    public function indexAction()
    {

        $takmicenja = $this->getRepository('AppBundle:Takmicenje')->findAll();
        return $this->render('AppBundle:Takmicenje:index.html.twig', array('takmicenja' => $takmicenja));
    }

    /**
     * @Route("/{id}/new", name="takmicenje_novo")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction($id)
    {

        $form = $this->createForm(TakmicenjeType::class, new Takmicenje(), array(
            'action' => $this->generateUrl('takmicenje_insert', array( 'id' => $id)),
            'manager' => $this->getDoctrine()->getManager(),
            'dogadjaj' => $id
        ));

        return $this->render('AppBundle:Takmicenje:new.html.twig', array(
            'form' => $form->createView(),
            'id' => $id
        ));
    }

    /**
     * @Route("/{id}/new", name="takmicenje_insert")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function insertAction(Request $request, $id)
    {
        $form = $this->createForm(TakmicenjeType::class, new Takmicenje(), array(
            'manager' => $this->getDoctrine()->getManager(),
            'dogadjaj' => $id
        ));
        $form->handleRequest($request);
//        popunjava objekat
        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData()->setBrojSlobodnihMesta($form->getData()->getKategorija()->getBrojTimova());
//            forma sadrzi objekat takmicenje
            $this->persist($form->getData());
            //upisuje u bazu
            return $this->redirectToRoute('dogadjaj_detaljno', array('id' => $id));
        } else {
            return $this->render('AppBundle:Takmicenje:new.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @Route("/{takmicenje_id}-{dogadjaj_id}/delete", name="takmicenje_obrisi")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     */

    public function deleteAction($takmicenje_id, $dogadjaj_id, Request $request)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $takmicenje = $em->getRepository('AppBundle:Takmicenje')->findOneById($takmicenje_id);
        $em->remove($takmicenje);
        $em->flush();

        return $this->redirectToRoute('dogadjaj_detaljno', array('id' => $dogadjaj_id));
    }

}