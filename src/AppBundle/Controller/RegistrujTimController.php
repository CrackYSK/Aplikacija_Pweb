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
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
        $em=$this->getRepository('AppBundle:Takmicenje');

        $query = $em->createQueryBuilder('s')
            ->select('d')
            ->from('AppBundle:Dogadjaj', 'd')
            ->where('d.datum > CURRENT_DATE()')
            ->orderBy('DATE_DIFF(CURRENT_TIME(), d.datum)', 'ASC')
            ->setMaxResults(1)

            ->getQuery();
        $dogadjaj=$query->getResult();
        if($dogadjaj==null){
            return $this->render('AppBundle:Registruj:registruj.html.twig', array(
                    'form' => null,
                    'nema' => true
                )
            );
        }
        else{
            $form = $this->createForm(PrijavaType::class, new Prijava(), array(
                'action' => $this->generateUrl('registruj_insert'),
                'manager' => $this->getDoctrine()->getManager(),
                'dogadjaj' => $dogadjaj
            ));

            return $this->render('AppBundle:Registruj:registruj.html.twig', array(
                    'form' => $form->createView(),
                    'nema' => false
                )
            );
        }
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
        $prijava->setTim($tim);
        $form = $this->createForm(PrijavaType::class, $prijava, array(
            'manager' => $this->getDoctrine()->getManager(),
            'broj_clanova' => $kategorija->getBrojClanovaTima(),
            'studentska' => $kategorija->getStudentska(),
            'dogadjaj' => $takmicenje->getDogadjaj()
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
                /** @var UploadedFile $cv */
                $cv = $ucesnik->getCv();
                $cvName = md5(uniqid()).'.'.$cv->guessExtension();

                $cv->move($this->getParameter('cv_dir'), $cvName);
                $ucesnik->setCv($cvName);
            }
            if ($kategorija->getBrojClanovaTima() == 1) {
                $ucesnik = $tim->getUcesnik()[0];

                $tim->setNaziv($ucesnik->getIme().'_'.$ucesnik->getPrezime().rand(0, 100000));
            }
            $this->persist($form->getData());
            return $this->redirectToRoute('homepage');
        } else {
            return $this->render('AppBundle:Registruj:registruj.html.twig', array(
                'form' => $form->createView(),
                'nema' => false
            ));
        }



    }
}