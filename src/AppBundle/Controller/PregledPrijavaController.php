<?php
/**
 * Created by PhpStorm.
 * User: cracky
 * Date: 1/18/17
 * Time: 6:38 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Komentar;
use AppBundle\Form\KomentarType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Takmicenje;
use AppBundle\Entity\Tim;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class PregledPrijavaController
 * @package AppBundle\Controller
 * @Route("/admin/dogadjaj/takmicenje/{id}")
 */
class PregledPrijavaController extends BaseController
{
    /**
     * @Route("/", name="pregled_prijava")
     */
    public function indexAction($id)
    {
        $takmicenje = $this->getRepository('AppBundle:Takmicenje')->find($id);

        $prijave = $this->getRepository('AppBundle:Prijava')->findByTakmicenje($takmicenje);

        foreach ($prijave as $prijava) {
            if ($takmicenje->getKategorija()->getStudentska()) {
                $ucesnici = $this->getRepository('AppBundle:Student')->findByTim($prijava->getTim());
            } else {
                $ucesnici = $this->getRepository('AppBundle:Srednjoskolac')->findByTim($prijava->getTim());
            }

            $tim = $prijava->getTim();
            $tim->setUcesnik($ucesnici);
            $prijava->setTim($tim);
        }

        return $this->render('AppBundle:PregledPrijava:pregled.html.twig', array(
            'takmicenje' => $takmicenje,
            'prijave' => $prijave
        ));
    }

    /**
     * @Route("/{pid}", name="prijava_detaljno")
     */
    public function showAction($id, $pid)
    {
        $takmicenje = $this->getRepository('AppBundle:Takmicenje')->find($id);
        $prijava = $this->getRepository('AppBundle:Prijava')->find($pid);
        $komentari = $this->getRepository('AppBundle:Komentar')->findByPrijava($prijava);

        $tim = $prijava->getTim();
        if ($takmicenje->getKategorija()->getStudentska()) {
            $ucesnici = $this->getRepository('AppBundle:Student')->findByTim($tim);
        } else {
            $ucesnici = $this->getRepository('AppBundle:Srednjoskolac')->findByTim($tim);
        }
        $tim->setUcesnik($ucesnici);
        $prijava->setTim($tim);
        $user = $this->getUser();
        $komisija = false;
        if (in_array('ROLE_KOMISIJA', $user->getRoles())) {
            $komisija = true;
        }
        $predsednik = false;
        if ($takmicenje->getDogadjaj()->getPredsednik() === $user) {
            $predsednik = true;
        }

        return $this->render('AppBundle:PregledPrijava:show.html.twig', array(
            'prijava' => $prijava,
            'komentari' => $komentari,
            'komisija' => $komisija,
            'predsednik' => $predsednik
        ));
    }

    /**
     * @Route("/{pid}/dodaj_komentar", name="komentar_new")
     * @Method("GET")
     */
    public function newAction($id, $pid)
    {
        $form = $this->createForm(KomentarType::class, new Komentar(), array(
            'action' => $this->generateUrl('komentar_insert', array(
                'id' => $id,
                'pid' => $pid
            ))
        ));

        return $this->render('AppBundle:PregledPrijava:komentar.html.twig', array(
            'form' => $form->createView()));

    }

    /**
     * @Route("/{pid}/dodaj_komentar", name="komentar_insert")
     * @Method("POST")
     */
    public function insertAction($id, $pid, Request $request)
    {
        $prijava = $this->getRepository('AppBundle:Prijava')->find($pid);
        $user = $this->getUser();
        $komentar = new Komentar();
        $komentar->setPrijava($prijava);
        $komentar->setKomentator($user);
        $form = $this->createForm(KomentarType::class, $komentar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->persist($komentar);
            return $this->forward('AppBundle:PregledPrijava:show', array(
                'success' => true,
                'id' => $id,
                'pid' => $pid
            ));
        } else {
            return $this->render('AppBundle:PregledPrijava:komentar.html.twig', array(
                'form' => $form->createView()
            ));
        }

    }

    /**
     * @Route("/{pid}/odobri", name="odobri_prijavu")
     * @Method("POST")
     */
    public function approveAction(Request $request)
    {
        $pid = $request->request->get('pid');
        $id = $request->request->get('id');
        $prijava = $this->getRepository('AppBundle:Prijava')->find($pid);
        $prijava->setStatus(!$prijava->getStatus());
        $this->persist($prijava);

        return $this->forward('AppBundle:PregledPrijava:show', array(
            'success' => true,
            'id' => $id,
            'pid' => $pid
        ));
    }

}