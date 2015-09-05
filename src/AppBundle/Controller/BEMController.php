<?php

// src/AppBundle/Controller/BEMController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Tier;

class BEMController
{
    public function calculateBillingAction($form, $tiers)
    {
		
		/************** Inputs **************/
			// $estimated = Estimated Artefacts
			// $duplicates = Duplicates
			// $versions = Versions
		
		/*** Hardcode for now
		$databaseSize = 3; // Number of tiers
		$tierMaxArtefacts = array(1000, 4000, 10000); // Max Artefacts per tier
		$tierPrice = array(1, 0.7, 0.5); // Price per Artefact per Tier
		*/
		
		// Arrays
		$ArtefactsInRange = array(); // Calculated Artefacts per tier
		$tierPricePerMonth = array(); // Total price per tier
		$tierName = array();
		$tierMinArtefacts = array();
		$tierMaxArtefacts = array();
		$tierPrice = array();
		$tierArtefacts = array();
		
		$estimated = $form->get('estimated')->getData();
		$duplicates = $form->get('duplicates')->getData();
		$versions = $form->get('versions')->getData();

		// Math
		$removedArtefacts = round($estimated * $duplicates, 0); // calculate removed Artefacts
		$folded = round(($estimated - $removedArtefacts) * $versions, 0); // calculated folded in versions
		$totalUnits = $estimated - $removedArtefacts - $folded; // calculate new total artefacts (now refered to as units)
	
		$expectMaxUnits = $tiers[count($tiers)-1]->getRangeMaximum();
	
		if(($totalUnits < 0) || ($totalUnits > $expectMaxUnits) || ($duplicates < 0) || ($duplicates > 1) || ($versions < 0) || ($versions > 1))
		{
			$removedArtefacts = 0;
			$folded = 0;
			$totalUnits = 0;
		}
	
		$units = $totalUnits; // Units to be designated to a tier
		$totalPricePerMonth = 0; // Sum of all tier prices
		
		$i = 0; // index
		
		// Calculate totals per tier
		foreach ($tiers as $tier)
		{
			$tierName[$i] = $tier->getTierName(); 
			$tierMinArtefacts[$i] = $tier->getRangeMinimum();
			$tierMaxArtefacts[$i] = $tier->getRangeMaximum();
			$tierPrice[$i] = $tier->getPricePerArtefact();
			
			$tierArtefacts[$i] = $tierMaxArtefacts[$i] - ($tierMinArtefacts[$i] - 1);
			
			if ($units > $tierArtefacts[$i]) { // if more Artefacts exist than tier maximum
				$ArtefactsInRange [$i] = $tierArtefacts[$i]; // set Artefacts count to tier maximum
				$units = $units - $tierArtefacts[$i]; // update remaining unit count
			}
			else { 
				$ArtefactsInRange[$i] = $units; // set Artefact count to remainder, should not be more than tier maximum
				$units = 0; // set remain unit count to zero to exit while loop
			}
			$tierPricePerMonth[$i] = $ArtefactsInRange[$i] * $tierPrice[$i]; // calculate total cost for tier per month
			$totalPricePerMonth = $totalPricePerMonth + $tierPricePerMonth[$i]; // add tier total to overall total
			$i++;
		}	
		
		if ($totalUnits == 0 ) { // account for possible divide by zero
		$avgPricePerDrawingPerMonth = 0; // calculate average price per drawing
		}
		else {
			$avgPricePerDrawingPerMonth = $totalPricePerMonth / $totalUnits; // calculate average price per drawing
		}
		$pricePerAnnum = $totalPricePerMonth * 12; // calculater price per year
			
		// Generate info to be displayed on webpage				
		$myArray = array(
			'removedArtefacts' => $removedArtefacts, 
			'folded' => $folded, 
			'totalUnits' => $totalUnits,
			'ArtefactsInRange' => $ArtefactsInRange,
			'tierPricePerMonth' => $tierPricePerMonth,
			'totalPricePerMonth' => $totalPricePerMonth,
			'avgPricePerDrawingPerMonth' => $avgPricePerDrawingPerMonth,
			'pricePerAnnum' => $pricePerAnnum,
			'tierName' => $tierName,
			'tierMinArtefacts' => $tierMinArtefacts,
			'tierMaxArtefacts' => $tierMaxArtefacts,
			'tierArtefacts' => $tierArtefacts,
			'tierPrice' => $tierPrice,
			'tiers' => $tiers,
			'form' => $form->createView()
		);
		
		return $myArray;
    }
}
?>