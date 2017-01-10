<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 10.1.17.
 * Time: 20.32
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class RegistrujTimController extends BaseController
{
    /**
     * @Route("/registruj", name="registruj")
     */
    public function indexAction(Request $request)
    {

        return $this->render('AppBundle:Registruj:registruj.html.twig');
    }
}