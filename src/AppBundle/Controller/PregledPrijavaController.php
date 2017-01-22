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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PregledPrijavaController
 * @package AppBundle\Controller
 * @Route("/admin/dogadjaj/takmicenje/detalji/{id}")
 */
class PregledPrijavaController extends BaseController
{
    static $obavesteni=false;
    /**
     * @Route("/prijave", name="pregled_prijava")
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
            'prijave' => $prijave,
            'obavesteni'=>self::$obavesteni
        ));
    }

    /**
     * @Route("/prijave/{pid}", name="prijava_detaljno")
     */
    public function showAction($id, $pid)
    {

        $takmicenje = $this->getRepository('AppBundle:Takmicenje')->find($id);
        $prijava = $this->getRepository('AppBundle:Prijava')->find($pid);
        $komentari = $this->getRepository('AppBundle:Komentar')->findByPrijava($prijava);
        $za=0;
        $protiv=0;

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
        $postoji = false;
        $komentar_id = null;
        foreach ($komentari as $komentar) {
            if ($komentar->getKomentator() == $user) {
                $postoji = true;
                $komentar_id = $komentar->getId();
            }
            if($komentar->getZa())
                $za++;
            else
                $protiv++;
        }

        return $this->render('AppBundle:PregledPrijava:show.html.twig', array(
            'prijava' => $prijava,
            'komentari' => $komentari,
            'komisija' => $komisija,
            'predsednik' => $predsednik,
            'postoji_komentar' => $postoji,
            'komentar_id' => $komentar_id,
            'za' => $za,
            'protiv' => $protiv
        ));
    }

    /**
     * @Route("/prijave/{pid}/dodaj_komentar", name="komentar_new")
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
     * @Route("/prijave/{pid}/dodaj_komentar", name="komentar_insert")
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
            return $this->redirectToRoute('prijava_detaljno', array(
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
     * @Route("/{pid}/{kid}/promeni_komentar", name="komentar_edit")
     * @Method("GET")
     */
    public function editAction($id, $pid, $kid) {
        $komentar = $this->getRepository('AppBundle:Komentar')->find($kid);
        $form = $this->createForm(KomentarType::class, $komentar, array(
            'action' => $this->generateUrl('komentar_update', array(
                'id' => $id,
                'pid' => $pid,
                'kid' => $kid
            ))
        ));

        return $this->render('AppBundle:PregledPrijava:komentar.html.twig', array(
            'form' => $form->createView()));
    }

    /**
     * @Route("/prijave/{pid}/{kid}/promeni_komentar", name="komentar_update")
     * @Method("POST")
     */
    public function updateAction($id, $pid, $kid, Request $request)
    {
        $prijava = $this->getRepository('AppBundle:Prijava')->find($pid);
        $komentar = $this->getRepository('AppBundle:Komentar')->find($kid);
        $user = $this->getUser();
        $komentar->setPrijava($prijava);
        $komentar->setKomentator($user);
        $form = $this->createForm(KomentarType::class, $komentar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->persist($komentar);
            return $this->redirectToRoute('prijava_detaljno', array(
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
     * @Route("/prijave/{pid}/{kid}/obrisi", name="komentar_delete")
     * @Method("POST")
     */
    public function deleteAction($id, $pid, $kid, Request $request)
    {
        $em = $this->getManager();
        $komentar = $em->getRepository('AppBundle:Komentar')->find($kid);
        $em->remove($komentar);
        $em->flush();
        return $this->redirectToRoute('prijava_detaljno', array(
            'id' => $id,
            'pid' => $pid
        ));
    }

    /**
     * @Route("/prijave/{pid}/odobri", name="odobri_prijavu")
     * @Method("POST")
     */
    public function approveAction(Request $request)
    {
        $pid = $request->request->get('pid');
        $id = $request->request->get('id');
        $prijava = $this->getRepository('AppBundle:Prijava')->find($pid);
        $prijava->setStatus(!$prijava->getStatus());
        if ($prijava->getStatus()) {
            $brMesta = $prijava->getTakmicenje()->getBrojSlobodnihMesta();
            if ($brMesta > 0) {
                $prijava->getTakmicenje()->setBrojSlobodnihMesta($brMesta-1);
                $this->persist($prijava);
            } else {
                echo false;
            }

        } else {
            $brMesta = $prijava->getTakmicenje()->getBrojSlobodnihMesta();
            $prijava->getTakmicenje()->setBrojSlobodnihMesta($brMesta+1);
            $this->persist($prijava);
        }

        return $this->redirectToRoute('prijava_detaljno', array(
            'success' => true,
            'id' => $id,
            'pid' => $pid
        ));

    }

    /**
     * @Route("prijava/obavestenje", name="prijava_obavesti")
     */
    public function notifyAction($id) {

        $takmicenje = $this->getRepository('AppBundle:Takmicenje')->find($id);

        $prijave = $this->getRepository('AppBundle:Prijava')->findByTakmicenje($takmicenje);
        $ucesnici=null;
        foreach ($prijave as $prijava) {
            if ($takmicenje->getKategorija()->getStudentska()) {
                $ucesnici = $this->getRepository('AppBundle:Student')->findByTim($prijava->getTim());
            } else {
                $ucesnici = $this->getRepository('AppBundle:Srednjoskolac')->findByTim($prijava->getTim());
            }

            if($ucesnici!=null) {

                if($prijava->getStatus()==1) {
                    foreach ($ucesnici as $ucesnik) {
                        $message = \Swift_Message::newInstance()
                            ->setSubject('Obavestenje')
                            ->setFrom($this->container->getParameter('mailer_user'))
                            ->setTo($ucesnik->getEmail())
                            ->setBody(
                                $this->renderView(
                                // app/Resources/views/Emails/registration.html.twig
                                    'Email/notifying.html.twig',
                                    array('ime' => $ucesnik->getIme(),
                                            'prezime'=>$ucesnik->getPrezime(),
                                            'status'=>true,
                                            'kategorija'=>$takmicenje->getKategorija()->getNaziv())
                                ),
                                'text/html'
                            );

                        $this->get('mailer')->send($message);
                    }
                }
                else {
                    foreach ($ucesnici as $ucesnik) {
                        $message = \Swift_Message::newInstance()
                            ->setSubject('Obavestenje')
                            ->setFrom($this->container->getParameter('mailer_user'))
                            ->setTo($ucesnik->getEmail())
                            ->setBody(
                                $this->renderView(
                                // app/Resources/views/Emails/registration.html.twig
                                    'Email/notifying.html.twig',
                                    array('ime' => $ucesnik->getIme(),
                                        'prezime'=>$ucesnik->getPrezime(),
                                        'status'=>false,
                                        'kategorija'=>$takmicenje->getKategorija()->getNaziv())
                                ),
                                'text/html'
                            );
                        $this->get('mailer')->send($message);
                    }
                }

            }
        }

        self::$obavesteni=true;

            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'Emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */


        return $this->redirectToRoute('pregled_prijava', array(
            'success' => true,
            'id' => $id,
        ));
    }


}