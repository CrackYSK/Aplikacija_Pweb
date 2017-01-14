<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 10.1.17.
 * Time: 20.32
 */

namespace AppBundle\Controller;

use AppBundle\Form\PrijavaType;
use AppBundle\Form\TimType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Tim;
use AppBundle\Entity\Prijava;

/**
 * Class RegistrujTimController
 * @package AppBundle\Controller
 * @Route("/registruj")
 */
class RegistrujTimController extends BaseController
{
    /**
     * @Route("/", name="registruj")
     * @Method("GET")
     */
    public function newAction()
    {
        $form = $this->createForm(PrijavaType::class, new Prijava(), array(
            'action' => $this->generateUrl('registruj_insert'),
            'manager' => $this->getDoctrine()->getManager()
        ));

        return $this->render('AppBundle:Registruj:registruj.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * @Route("/", name="registruj_insert")
     * @Method("POST")
     */
    public function insertAction(Request $request)
    {
        $id = $request->request->get('id');
        $takmicenje = $this->getRepository('AppBundle:Takmicenje')->find($id);
        $kategorija = $takmicenje->getKategorija();
        $form = $this->createForm(PrijavaType::class, new Prijava(), array(
            'manager' => $this->getDoctrine()->getManager(),
            'broj_clanova' => $kategorija->getBrojClanovaTima(),
            'studentska' => $kategorija->getStudentska()
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->persist($form->getData());
            return $this->forward('AppBundle:Index:index', array('success' => true));
        } else {
            return $this->render('AppBundle:Registruj:registruj.html.twig', array(
                'form' => $form->createView()
            ));
        }



    }
}