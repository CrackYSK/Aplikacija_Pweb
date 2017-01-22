<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 22.1.17.
 * Time: 14.27
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Rad;
use AppBundle\Form\RadType;
use AppBundle\Entity\Student;
use AppBundle\Entity\Autor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class RegistrujRadController
 * @package AppBundle\Controller\
 * @Route("/registruj_rad")
 */
class RegistrujRadController extends BaseController
{
    /**
     * @Route("/", name="registruj_rad")
     * @Method("GET")
     */
    public function newAction()
    {
        $broj_clanova = 0;
        $em=$this->getRepository('AppBundle:SmotraRadova');

        $query = $em->createQueryBuilder('s')
            ->select('d')
            ->from('AppBundle:Dogadjaj', 'd')
            ->where('d.datum > CURRENT_DATE()')
            ->orderBy('DATE_DIFF(CURRENT_TIME(), d.datum)', 'ASC')
            ->setMaxResults(1)

            ->getQuery();
        $dogadjaj=$query->getResult();
        if ($dogadjaj !==null) {
            $query = $em->createQueryBuilder('s')
                ->select('sr')
                ->from('AppBundle:SmotraRadova', 'sr')
                ->where('sr.dogadjaj = :dogadjaj')
                ->setParameter('dogadjaj', $dogadjaj[0])
                ->setMaxResults(1)
                ->getQuery();
            $smotra = $query->getResult();

            if (empty($smotra)) {
                return $this->render('AppBundle:Registruj:rad.html.twig', array(
                        'form' => null,
                        'nema' => true,
                    )
                );
            } else {
                $rad = new Rad();
                for ($i = 0; $i < $broj_clanova; $i++) {
                    $autor = new Autor();
                    $rad->getAutor()->add($autor);
                }
                $form = $this->createForm(RadType::class, $rad, array(
                    'action' => $this->generateUrl('rad_insert'),
                    'manager' => $this->getDoctrine()->getManager(),
                ));

                return $this->render('AppBundle:Registruj:rad.html.twig', array(
                        'form' => $form->createView(),
                        'nema' => false,
                    )
                );
            }
        }
        else{
            return $this->render('AppBundle:Registruj:rad.html.twig', array(
                    'form' => null,
                    'nema' => true,
                )
            );
        }

    }

    /**
     * @Route("/", name="rad_insert")
     * @Method("POST")
     */
    public function insertAction(Request $request)
    {
        $broj_clanova = 0;
        if ($request->request->get('broj_clanova') != 0)
            $broj_clanova = $request->request->get('broj_clanova');
        else {
            $broj_clanova = $request->request->get('appbundle_rad')['broj'];
        }
        $rad = new Rad();
        for ($i=0; $i < $broj_clanova; $i++) {
            $autor = new Autor();
            $rad->getAutor()->add($autor);
        }
        $form = $this->createForm(RadType::class, $rad, array(
            'manager' => $this->getDoctrine()->getManager(),
        ))->add('save', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $rad = $form->getData();
            $em=$this->getRepository('AppBundle:SmotraRadova');

            $query = $em->createQueryBuilder('s')
                ->select('d')
                ->from('AppBundle:Dogadjaj', 'd')
                ->where('d.datum > CURRENT_DATE()')
                ->orderBy('DATE_DIFF(CURRENT_TIME(), d.datum)', 'ASC')
                ->setMaxResults(1)

                ->getQuery();
            $dogadjaj=$query->getResult();

            $query = $em->createQueryBuilder('s')
                ->select('sr')
                ->from('AppBundle:SmotraRadova', 'sr')
                ->where('sr.dogadjaj = :dogadjaj')
                ->setParameter('dogadjaj', $dogadjaj[0])
                ->setMaxResults(1)
                ->getQuery();
            $smotra = $query->getResult();


            $rad->setSmotraRadova($smotra[0]);

            /** @var UploadedFile $apstrakt */
            $apstrakt = $rad->getApstrakt();
            $apstraktName = md5(uniqid()).'.'.$apstrakt->guessExtension();
            $apstrakt->move($this->getParameter('rad_dir'), $apstraktName);
            $rad->setApstrakt($apstraktName);

            $autori = $rad->getAutor();
            foreach ($autori as $key => $autor) {
                $student = $autor->getStudent();
                $student->getAutor()->add($autor);
                $autor->setRedosled($key + 1);
                $autor->setRad($rad);

                $cv = $student->getCv();
                $cvName = md5(uniqid()).'.'.$cv->guessExtension();

                $cv->move($this->getParameter('cv_dir'), $cvName);
                $student->setCv($cvName);
            }

            $this->persist($rad);
            return $this->redirectToRoute('homepage');
        } else {
            return $this->render('AppBundle:Registruj:rad.html.twig', array(
                'form' => $form->createView(),
                'nema' => false
            ));
        }
    }

}