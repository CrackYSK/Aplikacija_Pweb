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

/**
 * Class TakmicenjeController
 * @package AppBundle\Controller
 * @Route("/admin/dogadjaj/takmicenje")
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
     * @Route("{id}/new", name="takmicenje_insert")
     * @Method("POST")
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
            return $this->forward('AppBundle:Takmicenje:index', array('success' => true));
        } else {
            return $this->render('AppBundle:Takmicenje:new.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

}