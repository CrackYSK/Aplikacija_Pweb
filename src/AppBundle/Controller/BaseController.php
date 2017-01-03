<?php
/**
 * Created by PhpStorm.
 * User: cracky
 * Date: 1/3/17
 * Time: 7:07 PM
 */



namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
    protected function getManager($name = null)
    {
        return $this->getDoctrine()->getManager($name);
    }

    protected function persist($object, $managerName = null)
    {
        $em = $this->getDoctrine()->getManager($managerName);
        $em->persist($object);
        $em->flush();
    }

    protected function getRepository($persistentObjectName, $persistentManagerName = null)
    {
        return $this->getDoctrine()->getRepository($persistentObjectName, $persistentManagerName);
    }
}