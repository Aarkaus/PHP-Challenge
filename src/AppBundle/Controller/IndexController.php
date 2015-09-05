<?php

// src/AppBundle/Controller/IndexController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{	
    /**
     * @Route("/")
	 *
     */
    public function Index()
	{
		return $this->render('index.html.twig');
    }
}
?>