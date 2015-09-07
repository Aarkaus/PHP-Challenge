<?php

// src/AppBundle/Controller/BillingEstimateController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\BillingInputs;
use AppBundle\Form\Task\BillingInputsType;

class BillingEstimateController extends Controller
{
			
    /**
     * @Route("/Billing/Estimate")
	 * @METHOD("GET")
     */
    public function BillingAction()
	{
		$em = $this->getDoctrine()->getManager();
		$tiers = $em->getRepository('AppBundle:Tier')
			->findAll();
			
		$task = new BillingInputs();
		$task->setEstimated(0);
		$task->setDuplicates(0);
		$task->setVersions(0);
		
		$form = $this->createForm(new BillingInputsType(), $task);
		
		$estimated = $form->get('estimated')->getData();
		$duplicates = $form->get('duplicates')->getData();
		$versions = $form->get('versions')->getData();
		
		$paramerters = $this->get('app.BEMController')->calculateBillingAction($estimated, $duplicates, $versions, $tiers);
		
		$paramerters['form'] = $form->createView();
		
		return $this->render('BEM.html.twig', $paramerters);
    }
	
	/**
     * @Route("/Billing/Estimate")
	 * @Method({"GET", "POST"})
     */
    public function newBillingFormSubmit(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$tiers = $em->getRepository('AppBundle:Tier')
			->findAll();
		
		$task = new BillingInputs();
		$form = $this->createForm(new BillingInputsType(), $task);
		
		$form->handleRequest($request);
		
		$estimated = $form->get('estimated')->getData();
		$duplicates = $form->get('duplicates')->getData();
		$versions = $form->get('versions')->getData();
		
		$paramerters = $this->get('app.BEMController')->calculateBillingAction($estimated, $duplicates, $versions, $tiers);

		$paramerters['form'] = $form->createView();
		
		if ($form->isSubmitted() && $form->isValid()) {

			return $this->render('BEM.html.twig', $paramerters);
		}
		
		return $this->render('BEM.html.twig', $paramerters);
    }
}
?>