<?php

// src/AppBundle/Controller/BEMController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BEMController
{
    public function calculateBillingAction($estimated, $duplicates, $versions)
    {
		
		/************** Inputs **************/
			// $estimated = Estimated Artifacts
			// $duplicates = Duplicates
			// $versions = Versions
		
		/*** Hardcode for now ***/
		$database = 3; // Number of tiers
		$tierMaxArtifacts = array(1000, 4000, 10000); // Max Artifacts per tier
		$tierPrice = array(1, 0.7, 0.5); // Price per Artifact per Tier
		$maxArtifacts = array_sum($tierMaxArtifacts);
		$percent = 100;
		
		// Arrays
		$artifactsInRange = array(); // Calculated Artifacts per tier
		$tierPricePerMonth = array(); // Total price per tier

		// Math
		$removedArtefacts = round($estimated * ($duplicates / $percent), 0); // calculate removed artifacts
		$folded = round(($estimated - $removedArtefacts) * ($versions / $percent), 0); // calculated folded in versions
		$totalUnits = $estimated - $removedArtefacts - $folded; // calculate new total artefacts (now refered to as units) //TODO: check within bounds
		
		if ((0 > $totalUnits) || ($totalUnits > $maxArtifacts)) {
			return new Response(
				'<html><body>Number of Artifacts out of bounds</body></html>' //TODO: handle graciously
			);
		}
		else {
			$units = $totalUnits; // Units to be designated to a tier
			$totalPricePerMonth = 0; // Sum of all tier prices
			
			$i = 0; // index
			
			// Calculate totals per tier
			while (($i < $database) && ($units != 0)) { 
				if ($units > $tierMaxArtifacts[$i]) { // if more artifacts exist than tier maximum
					$artifactsInRange [$i] = $tierMaxArtifacts[$i]; // set artifacts count to tier maximum
					$units = $units - $tierMaxArtifacts[$i]; // update remaining unit count
				}
				else { 
					$artifactsInRange[$i] = $units; // set artifact count to remainder, should not be more than tier maximum
					$units = 0; // set remain unit count to zero to exit while loop
				}
				
				$tierPricePerMonth[$i] = $artifactsInRange[$i] * $tierPrice[$i]; // calculate total cost for tier per month
				$totalPricePerMonth = $totalPricePerMonth + $tierPricePerMonth[$i]; // add tier total to overall total
				$i++;
			}
			
			if ($totalUnits == 0 ) { // account for possible divide by zero
			$avgPricePerDrawingPerMonth = 0; // calculate average price per drawing
			}
			else {
				$avgPricePerDrawingPerMonth = $totalPricePerMonth / $totalUnits; // calculate average price per drawing
			$pricePerAnnum = $totalPricePerMonth * 12; // calculater price per ye
			}
			$pricePerAnnum = $totalPricePerMonth * 12; // calculater price per year
			
			// Generate Response
			
			//$response = new Response(json_encode(array('removedArtefacts' => $removedArtefacts, 'folded' => $folded, 'totalUnits' => $totalUnits)));
				
			$myArray = array(
				'removedArtefacts' => $removedArtefacts, 
				'folded' => $folded, 
				'totalUnits' => $totalUnits,
				'artifactsInRange' => $artifactsInRange,
				'tierPricePerMonth' => $tierPricePerMonth,
				'totalPricePerMonth' => $totalPricePerMonth,
				'avgPricePerDrawingPerMonth' => $avgPricePerDrawingPerMonth,
				'pricePerAnnum' => $pricePerAnnum
			);
			
			return $myArray;
		}
    }
}
?>