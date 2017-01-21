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

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("/admin")
 */
class AdminController extends BaseController
{
    /**
     * @Route("/", name="admin")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Admin:index.html.twig');
    }

    /**
     * @Route("/registruj", name="registruj_korisnika")
     */
    public function Registruj(Request $request)
    {
        return $this->render('AppBundle:Admin:registruj.html.twig');
    }


}