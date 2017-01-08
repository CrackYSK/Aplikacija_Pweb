<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 8.1.17.
 * Time: 16.00
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class PrijavaController extends BaseController
{
    /**
     * @Route("/prijava", name="prijava")
     */
    public function indexAction(Request $request)
    {

        return $this->render('AppBundle:Prijava:prijava.html.twig');
    }

}