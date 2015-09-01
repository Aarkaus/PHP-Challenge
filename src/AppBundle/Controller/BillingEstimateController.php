<?php

// src/AppBundle/Controller/BillingEstimateController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class BillingEstimateController extends Controller
{
	
	/**
     * @Route("/Billing/Estimate")
     */
    public function initAction()
    {
		$paramerters = $this->get('app.BEMController')->calculateBillingAction(0, 0, 0);
		return $this->render('BEM.html.twig', $paramerters);
		//return 
	}
		
    /**
     * @Route("/Billing/Estimate/{estimated}/{duplicates}/{versions}")
     */
    public function calculateBillingAction($estimated, $duplicates, $versions)
    {
		
		/************** Inputs **************/
			// $estimated = Estimated Artifacts
			// $duplicates = Duplicates
			// $versions = Versions
		
		$paramerters = $this->get('app.BEMController')->calculateBillingAction($estimated, $duplicates, $versions);
		return $this->render('BEM.html.twig', $paramerters);
    }
}
?>