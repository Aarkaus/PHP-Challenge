<?php
// src/AppBundle/Tests/BillingEstimateControllerTest.php
namespace AppBundle\Tests;

use AppBundle\SecurityController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
	private $client = null;
	
	public function setUp()
    {
        $this->client = static::createClient();
    }
	
	//access login page
	public function testLoginLink()
    {
		$crawler = $this->client->request('GET', '/');
		
		$link = $crawler->selectLink('Login')->link();

		$crawler = $this->client->click($link);
				
        $this->assertTrue(
			$this->client->getResponse()->isSuccessful()
		);

		$this->assertEquals(
            'http://localhost/login',
            $this->client->getHistory()->current()->getUri(),
			sprintf('Current Uri is: %s', $this->client->getHistory()->current()->getUri())
        );
    }
	
	//bad login
	public function testBadLogin()
    {	
		$crawler = $this->client->request('GET', '/login');
		
		$form = $crawler->selectButton('submit')->form();
		
		// set some values
		$form['_username'] = 'John Smith';
		$form['_password'] = 'wrong password';

		// submit the form
		$crawler = $this->client->submit($form);	
		
        $this->assertTrue(
			$this->client->getResponse()->isRedirect()
		);
		
		$this->assertEquals(
            'http://localhost/login',
            $this->client->getResponse()->getTargetUrl()
        );
    }
		
	//login
	public function testGoodLogin()
    {
        $crawler = $this->client->request('GET', '/login');
		
		$form = $crawler->selectButton('submit')->form();
		
		// set some values
		$form['_username'] = 'John Smith';
		$form['_password'] = 'test';

		// submit the form
		$crawler = $this->client->submit($form);	
		
        $this->assertTrue(
			$this->client->getResponse()->isRedirect()
		);

		$this->client->followRedirect();
		
		$crawler = $this->client->getCrawler();
		
		$this->assertGreaterThan(
			0,
			$crawler->filter('html:contains("John Smith")')->count(),
			sprintf('Current Uri is: %s', $this->client->getHistory()->current()->getUri())
        );
		
		$this->assertEquals(
            'http://localhost/',
            $this->client->getHistory()->current()->getUri()
        );
    }

	//try logout
	public function testLogout()
    {	
		$crawler = $this->client->request('GET', '/login');
		
		$form = $crawler->selectButton('submit')->form();
		
		// set some values
		$form['_username'] = 'John Smith';
		$form['_password'] = 'test';

		// submit the form
		$crawler = $this->client->submit($form);	

		$this->client->followRedirect();
		
		$crawler = $this->client->getCrawler();
		
        $link = $crawler->selectLink('Logout')->link();
		$crawler = $this->client->click($link);
		
		$this->client->followRedirect();
		
        $this->assertTrue(
			$this->client->getResponse()->isSuccessful()
		);
		
		$this->assertEquals(
            'http://localhost/login',
            $this->client->getHistory()->current()->getUri(),
			sprintf('Current Uri is: %s', $this->client->getHistory()->current()->getUri())
        );
    }	
}
?>