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
        $user = $this->getUser();
        $admin = in_array('ROLE_ADMIN', $user->getRoles()) ? true: false;
        // replace this example code with whatever you need
        return $this->render('AppBundle:Admin:index.html.twig', array('admin'=> $admin));
    }

    /**
     * @Route("/registruj", name="registruj_korisnika")
     */
    public function Registruj(Request $request)
    {
        return $this->render('AppBundle:Admin:registruj.html.twig');
    }


}