<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        $this->client = static::createClient();
        $kernel= self::bootKernel();
    }

    public function testIsDisplayHeader(): void
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body > header > div > a > h1', 'Strona główna', 'Header is not contain "Strona główna"');
    }


    public function testISAddUserButtonRedirect()
    {
        $crawler = $this->client->request('GET', '/');
        $this->client->clickLink('Dodaj');
        $uri= $this->client->getRequest()->getRequestUri();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals("/user/add", $uri, 'Incorrect path "/user/add"');
        $this->assertSelectorTextContains('body > main > div > div > article > h1', 'Dodaj użytkownika', 'Button "Dodaj" is not redirect to "user/add"');
    
    }

    // public function testISImportButtonRedirect()
    // {
    //     $crawler = $this->client->request('GET', '/');
    //     $this->client->clickLink('Import');

    //     $uriRedirect= $this->client->getRequest()->getRequestUri();

    //     $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    //     $this->assertEquals("/import", $uriRedirect, 'Incorrect Redirect to "/import"');

    //     $crawler = $this->client->followRedirect();
    //     $uriFinal= $this->client->getRequest()->getRequestUri();

    //     $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    //     $this->assertEquals("/", $uriFinal, 'Incorrect final path "/"');
    
    // }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
