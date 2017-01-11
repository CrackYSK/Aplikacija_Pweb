<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 8.1.17.
 * Time: 16.14
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class RegistrujKorisnikaController extends BaseController
{

    /**
     * @Route("/admin/registruj", name="registruj_korisnika")
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Admin:registruj.html.twig');
    }

}