<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 10.1.17.
 * Time: 20.32
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Srednjoskolac;
use AppBundle\Entity\Student;
use AppBundle\Entity\Ucesnik;
use AppBundle\Form\PrijavaType;
use AppBundle\Form\TimType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Tim;
use AppBundle\Entity\Prijava;
use Symfony\Component\Validator\Constraints\DateTime;

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
        $prijava = $request->request->get('appbundle_prijava');
        $id_submit = $prijava['takmicenje'];
        $takmicenje = null;
        if ($id !== null) {
            $takmicenje = $this->getRepository('AppBundle:Takmicenje')->find($id);
        } else {
            $takmicenje = $this->getRepository('AppBundle:Takmicenje')->find($id_submit);
        }

        $kategorija = $takmicenje->getKategorija();
        $prijava = new Prijava();
        $tim = new Tim();
        $prijava->setTim($tim);
        if ($kategorija->getStudentska()) {
            for ($i = 0; $i < $kategorija->getBrojClanovaTima(); $i++) {
                $ucesnik = new Student();
                $tim->getUcesnik()->add($ucesnik);
            }
        } else {
            for ($i = 0; $i < $kategorija->getBrojClanovaTima(); $i++) {
                $ucesnik = new Srednjoskolac();
                $tim->getUcesnik()->add($ucesnik);
            }
        }
        $form = $this->createForm(PrijavaType::class, $prijava, array(
            'manager' => $this->getDoctrine()->getManager(),
            'broj_clanova' => $kategorija->getBrojClanovaTima(),
            'studentska' => $kategorija->getStudentska()
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $form->getData()->setDatum(new \DateTime());
            $form->getData()->setStatus(false);
            $tim = $form->getData()->getTim();
            $tim->setPrijava($form->getData());
            $ucesnici = $tim->getUcesnik();
            foreach ($ucesnici as $ucesnik) {
                $ucesnik->setTim($tim);
            }
            $this->persist($form->getData());
            return $this->redirectToRoute('homepage');
            return $this->forward('AppBundle:Index:index', array('success' => true));
        } else {
            return $this->render('AppBundle:Registruj:registruj.html.twig', array(
                'form' => $form->createView()
            ));
        }



    }
}