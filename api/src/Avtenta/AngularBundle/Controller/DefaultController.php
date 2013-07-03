<?php

namespace Avtenta\AngularBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AvtentaAngularBundle:Default:index.html.twig', array('name' => $name));
    }
}
