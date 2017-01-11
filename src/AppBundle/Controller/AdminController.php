<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 11.1.17.
 * Time: 15.11
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends BaseController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Admin:index.html.twig');
    }

}