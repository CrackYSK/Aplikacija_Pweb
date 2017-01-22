<?php
/**
 * Created by PhpStorm.
 * User: kolibri
 * Date: 14.1.17.
 * Time: 17.05
 */

namespace AppBundle\Controller;

use AppBundle\Entity\SmotraRadova;
use AppBundle\Entity\Dogadjaj;
use AppBundle\Form\SmotraRadovaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Class SmotraRadovaController
 * @package AppBundle\Controller
 * @Route("/admin/dogadjaj/smotra")
 */
class SmotraRadovaController extends BaseController
{
    /**
     * @Route("/{id}/new", name="smotra_dodaj")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function insertAction(Request $request, $id)
    {

        $repository = $this->getRepository('AppBundle:Dogadjaj');
        $dogadjaj = $repository->findOneBy(array(
            'id' => $id
        ));

        $smotra = $this->getRepository('AppBundle:SmotraRadova')->findOneBy(array('dogadjaj' => $id));

        if (!$smotra) {
            $smotra = new SmotraRadova();
        }

        $smotra->setDogadjaj($dogadjaj);

        $this->persist($smotra);

        return $this->redirectToRoute('dogadjaj_detaljno', array('id' => $id));

    }

    /**
     * @Route("/{id}/delete", name="smotra_obrisi")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {

        $smotra = $this->getRepository('AppBundle:SmotraRadova')->findOneBy(array('dogadjaj' =>$id));

        $em = $this->get('doctrine')->getEntityManager();
        $em->remove($smotra);
        $em->flush();

        return $this->redirectToRoute('dogadjaj_detaljno', array(
            'id' => $id,
        ));

    }


}