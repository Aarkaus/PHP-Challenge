<?php
// src/AppBundle/Tests/BEMControllerTest.php
namespace AppBundle\Tests;

use AppBundle\Controller\BEMController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BEMControllerTest extends \PHPUnit_Framework_TestCase
{
	private $tiers = null;
		
	public function setUp()
    {
		// First, mock the object to be used in the test
        $tier1 = $this->getMock('\AppBundle\Entity\Tier');
        $tier1->expects($this->once())
            ->method('getTierName')
            ->will($this->returnValue('Tier 1'));
        $tier1->expects($this->once())
            ->method('getPricePerArtefact')
            ->will($this->returnValue(1));
		$tier1->expects($this->once())
            ->method('getRangeMinimum')
            ->will($this->returnValue(1));
		$tier1->expects($this->once())
            ->method('getRangeMaximum')
            ->will($this->returnValue(1000));
			
		$tier2 = $this->getMock('\AppBundle\Entity\Tier');
        $tier2->expects($this->once())
            ->method('getTierName')
            ->will($this->returnValue('Tier 2'));
        $tier2->expects($this->once())
            ->method('getPricePerArtefact')
            ->will($this->returnValue(0.7));
		$tier2->expects($this->once())
            ->method('getRangeMinimum')
            ->will($this->returnValue(1001));
		$tier2->expects($this->once())
            ->method('getRangeMaximum')
            ->will($this->returnValue(5000));
			
		$tier3 = $this->getMock('\AppBundle\Entity\Tier');
        $tier3->expects($this->once())
            ->method('getTierName')
            ->will($this->returnValue('Tier 3'));
        $tier3->expects($this->once())
            ->method('getPricePerArtefact')
            ->will($this->returnValue(0.5));
		$tier3->expects($this->once())
            ->method('getRangeMinimum')
            ->will($this->returnValue(5001));
		$tier3->expects($this->exactly(2))
            ->method('getRangeMaximum')
            ->will($this->returnValue(15000));
			
		$this->tiers = array($tier1, $tier2, $tier3);
	}
	
	//all fields
	public function testCorrectValuesOne()
    {	
		$bem = new BEMController();
		$parameters = $bem->calculateBillingAction(11100, 0.10, 0.15, $this->tiers);
		
		$this->assertEquals(
			1110,
			$parameters['removedArtefacts']
		);
		
		$this->assertEquals(
			1499,
			$parameters['folded']
		);
		
		$this->assertEquals(
			8491,
			$parameters['totalUnits']
		);
		
		$this->assertEquals(
			5545.5,
			$parameters['totalPricePerMonth']
		);
		
		$this->assertEquals(
			0.65,
			$parameters['avgPricePerDrawingPerMonth']
		);
		
		$this->assertEquals(
			66546,
			$parameters['pricePerAnnum']
		);
    }	
	
		//all fields
	public function testCorrectValuesTwo()
    {	
		$bem = new BEMController();
		$parameters = $bem->calculateBillingAction(14999, 0.20, 0.18, $this->tiers);
		
		$this->assertEquals(
			3000,
			$parameters['removedArtefacts']
		);
		
		$this->assertEquals(
			2160,
			$parameters['folded']
		);
		
		$this->assertEquals(
			9839,
			$parameters['totalUnits']
		);
		
		$this->assertEquals(
			6219.5,
			$parameters['totalPricePerMonth']
		);
		
		$this->assertEquals(
			0.63,
			$parameters['avgPricePerDrawingPerMonth']
		);
		
		$this->assertEquals(
			74634,
			$parameters['pricePerAnnum']
		);
    }	
	
	public function testNegativeEstimated()
    {	
		$bem = new BEMController();
		$parameters = $bem->calculateBillingAction(-14999, 0.20, 0.15, $this->tiers);
		
		$this->assertEquals(
			0,
			$parameters['removedArtefacts']
		);
		
		$this->assertEquals(
			0,
			$parameters['folded']
		);
		
		$this->assertEquals(
			0,
			$parameters['totalUnits']
		);
		
		$this->assertEquals(
			0,
			$parameters['totalPricePerMonth']
		);
		
		$this->assertEquals(
			0,
			$parameters['avgPricePerDrawingPerMonth']
		);
		
		$this->assertEquals(
			0,
			$parameters['pricePerAnnum']
		);
    }

	public function testNegativeDuplicates()
    {	
		$bem = new BEMController();
		$parameters = $bem->calculateBillingAction(14999, -0.20, 0.15, $this->tiers);
		
		$this->assertEquals(
			0,
			$parameters['removedArtefacts']
		);
		
		$this->assertEquals(
			0,
			$parameters['folded']
		);
		
		$this->assertEquals(
			0,
			$parameters['totalUnits']
		);
		
		$this->assertEquals(
			0,
			$parameters['totalPricePerMonth']
		);
		
		$this->assertEquals(
			0,
			$parameters['avgPricePerDrawingPerMonth']
		);
		
		$this->assertEquals(
			0,
			$parameters['pricePerAnnum']
		);
    }
	
	public function testNegativeVersions()
    {	
		$bem = new BEMController();
		$parameters = $bem->calculateBillingAction(14999, 0.20, -0.15, $this->tiers);
		
		$this->assertEquals(
			0,
			$parameters['removedArtefacts']
		);
		
		$this->assertEquals(
			0,
			$parameters['folded']
		);
		
		$this->assertEquals(
			0,
			$parameters['totalUnits']
		);
		
		$this->assertEquals(
			0,
			$parameters['totalPricePerMonth']
		);
		
		$this->assertEquals(
			0,
			$parameters['avgPricePerDrawingPerMonth']
		);
		
		$this->assertEquals(
			0,
			$parameters['pricePerAnnum']
		);
    }
	
	public function testOverRangeEstimated()
    {	
		$bem = new BEMController();
		$parameters = $bem->calculateBillingAction(15001, 0.0, 0.0, $this->tiers);
		
		$this->assertEquals(
			0,
			$parameters['removedArtefacts']
		);
		
		$this->assertEquals(
			0,
			$parameters['folded']
		);
		
		$this->assertEquals(
			0,
			$parameters['totalUnits']
		);
		
		$this->assertEquals(
			0,
			$parameters['totalPricePerMonth']
		);
		
		$this->assertEquals(
			0,
			$parameters['avgPricePerDrawingPerMonth']
		);
		
		$this->assertEquals(
			0,
			$parameters['pricePerAnnum']
		);
    }

	public function testOver1Duplicates()
    {	
		$bem = new BEMController();
		$parameters = $bem->calculateBillingAction(14999, 1.20, 0.15, $this->tiers);
		
		$this->assertEquals(
			0,
			$parameters['removedArtefacts']
		);
		
		$this->assertEquals(
			0,
			$parameters['folded']
		);
		
		$this->assertEquals(
			0,
			$parameters['totalUnits']
		);
		
		$this->assertEquals(
			0,
			$parameters['totalPricePerMonth']
		);
		
		$this->assertEquals(
			0,
			$parameters['avgPricePerDrawingPerMonth']
		);
		
		$this->assertEquals(
			0,
			$parameters['pricePerAnnum']
		);
    }
	
	public function testOver1Versions()
    {	
		$bem = new BEMController();
		$parameters = $bem->calculateBillingAction(14999, 0.20, 1.01, $this->tiers);
		
		$this->assertEquals(
			0,
			$parameters['removedArtefacts']
		);
		
		$this->assertEquals(
			0,
			$parameters['folded']
		);
		
		$this->assertEquals(
			0,
			$parameters['totalUnits']
		);
		
		$this->assertEquals(
			0,
			$parameters['totalPricePerMonth']
		);
		
		$this->assertEquals(
			0,
			$parameters['avgPricePerDrawingPerMonth']
		);
		
		$this->assertEquals(
			0,
			$parameters['pricePerAnnum']
		);
    }
}
?>