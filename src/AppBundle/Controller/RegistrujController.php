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

class RegistrujController extends BaseController
{

    /**
     * @Route("/registruj", name="registruj")
     */
    public function indexAction(Request $request)
    {

        return $this->render('AppBundle:Registruj:registruj.html.twig');
    }

}