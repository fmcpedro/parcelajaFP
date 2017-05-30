<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:default:index.html.twig',[]);
    }
    
    

    public function testeAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:default:teste.html.twig',[]);
    }
    
    
    
    
}
