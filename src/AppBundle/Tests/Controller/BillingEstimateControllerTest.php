<?php
// src/AppBundle/Tests/BillingEstimateControllerTest.php
namespace AppBundle\Tests;

use AppBundle\BillingEstimateController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BillingEstimateControllerTest extends WebTestCase
{
	private $client = null;
	
	public function setUp()
    {
        $this->client = static::createClient();
		$crawler = $this->client->request('GET', '/login');
		
		$form = $crawler->selectButton('submit')->form();
		
		// set some values
		$form['_username'] = 'John Smith';
		$form['_password'] = 'test';

		// submit the form
		$crawler = $this->client->submit($form);	

		$this->client->followRedirect();
	}
	
	//all fields
	public function testCanSubmit()
    {		
		$crawler = $this->client->request('GET', '/Billing/Estimate');
		
		$form = $crawler->selectButton('app_Billing_Inputs_CalculateCost')->form();
		
		// set some values
		$form['app_Billing_Inputs[estimated]'] = '1100';
		$form['app_Billing_Inputs[duplicates]'] = '10';
		$form['app_Billing_Inputs[versions]'] = '15';

		// submit the form
		$crawler = $this->client->submit($form);
		
		$this->assertTrue(
			$this->client->getResponse()->isSuccessful()
		);
		
		$this->assertEquals(
            'http://localhost/Billing/Estimate',
            $this->client->getHistory()->current()->getUri(),
			sprintf('Current Uri is: %s', $this->client->getHistory()->current()->getUri())
        );
    }	
}
?>