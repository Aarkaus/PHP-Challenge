<?php
// src/AppBundle/Tests/BillingEstimateControllerTest.php
namespace AppBundle\Tests;

use AppBundle\BillingEstimateController;

class BillingEstimateControllerTest extends \PHPUnit_Framework_TestCase
{
	$client = static::createClient();
	
	//fail access secure page (redirect to login)
    public function testAnonVisit()
    {
        $crawler = $client->request('GET', '/Billing/Estimate');
		
		// assert redirect to login page!
        $this->assertTrue(
			$client->getResponse()->isRedirect('/login'));
    }
	
	//access login page
	public function testLoginPageExists()
    {
		$crawler = $client->request('GET', '/login');
		
        $this->assertEquals(
			200,
			$client->getResponse()->getStatusCode()
		);
    }
	
	//bad login
	public function testBadLogin()
    {	
		$crawler = $client->request('GET', '/login');
		
		$form = $crawler->selectButton('submit')->form();
		
		// set some values
		$form['username'] = 'John Smith';
		$form['password'] = 'wrong password';

		// submit the form
		$crawler = $client->submit($form);	
		
        $this->assertTrue(
			$client->getResponse()->isRedirect('/login'));
    }
		
	//login
	public function testGoodLogin()
    {		
        $crawler = $client->request('GET', '/login');
		
		$form = $crawler->selectButton('submit')->form();
		
		// set some values
		$form['username'] = 'John Smith';
		$form['password'] = 'test';

		// submit the form
		$crawler = $client->submit($form);	
		
        $this->assertTrue(
			$client->getResponse()->isRedirect('/Billing/Estimate'));
    }
	
	//access secure page (success)
	public function testAccessSecureBillingPage()
    {		
		$crawler = $client->request('GET', '/Billing/Estimate');
		
		$this->assertEquals(
			200,
			$client->getResponse()->getStatusCode()
		);
    }
	
	//estimate too small
	public function testEstimateTooSmall()
    {		
		$crawler = $client->request('GET', '/Billing/Estimate');
		
		$form = $crawler->selectButton('submit')->form();
		
		// set some values
		$form['estimate'] = '-1';
		$form['duplicates'] = '0';
		$form['versions'] = '0';

		// submit the form
		$crawler = $client->submit($form);	
		$this->assertTrue(
			0,
			$crawler->'pricePerAnnum'
		);
    }
	
	//estimate too large
	public function testEstimateTooLarge()
    {		
        $this->assert
    }
	
	//duplicates too small
	public function testDuplicatesTooSmall()
    {		
        $this->assert
    }
	
	//duplicates too large
	public function testDuplicatesTooLarge()
    {		
        $this->assert
    }
	
	//versions too small
	public function testVersionsTooSmall()
    {		
        $this->assert
    }
	
	//versions too large
	public function testVersionsTooLarge()
    {		
        $this->assert
    }
	
	//calculate
	public function testCorrectValues()
    {		
        $this->assert
    }
	
	//try logout
	public function testLogout()
    {		
        $link = $crawler->selectLink('Logout')->link();
		$crawler = $client->click($link);
		
		$this->assertTrue(
			$client->getResponse()->isRedirect('/login'));
    }
}
?>