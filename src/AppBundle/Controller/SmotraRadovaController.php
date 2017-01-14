<?php
/**
 * Created by PhpStorm.
 * User: kolibri
 * Date: 14.1.17.
 * Time: 17.05
 */

namespace AppBundle\Controller;

use AppBundle\Entity\SmotraRadova;
use AppBundle\Form\SmotraRadovaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



/**
 * Class SmotraRadovaController
 * @package AppBundle\Controller
 * @Route("/admin/dogadjaj/smotra")
 */

class SmotraRadovaController extends BaseController
{
    /**
     * @Route("/{id}/new", name="smotra_insert")
     * @Method("POST")
     */
    public function insertAction(Request $request, $id)
    {

        $repository=$this->getRepository('AppBundle:Dogadjaj');
        $dogadjaj=$repository->findOneBy(array(
            'id'=> $id
        ));

        $smotra=new SmotraRadova();
        $smotra->setDogadjaj($dogadjaj);

        $this->persist($smotra);

        return $this->forward('AppBundle:Dogadjaj:show',array('success'=> true,'id'=>$id));

    }

}