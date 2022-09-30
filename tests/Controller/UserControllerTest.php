<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;

class UserControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        $this->client = static::createClient();
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testDisplayListOfUser(): void
    {
        $crawler = $this->client->request('GET', '/user/list');

        //count number of rows in table
        $amountDisplayUsers = $crawler->filter('  body > table > tbody')
        ->children()
        ->count();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body > h1', 'Lista użytkowników','Not found "Lista użytkowników"');
        
        //test header of tabel
        $this->assertSelectorTextContains('body > table > thead > tr > th', 'ID', 'Header of tabele is not display correctly');

        //test content of table
        $this->assertSelectorTextContains('body > table > tbody > tr:nth-child(1) > td:nth-child(1)', '1', 'Content of table is not display correctly');

        //test number of rows
        $this->assertEquals(20, $amountDisplayUsers, 'Number of rows in table is incorrect');

    }

    public function testAddUsersFormAndAddUserToDB()
    {
        $crawler = $this->client->request('GET', '/user/add');

        $buttonCrawlerNode = $crawler->selectButton('Dodaj');
        $form = $buttonCrawlerNode->form();

        $form['form[user][name]']='test';
        $form['form[user][username]']='testtest';
        $form['form[user][email]']='test@t.com';
        $form['form[user][phone]']='123123123';
        $form['form[user][website]']='test.com';
        $form['form[address][street]']='test';
        $form['form[address][suite]']='123';
        $form['form[address][city]']='test';
        $form['form[address][zipcode]']='12-123';
        $form['form[address][geos][lat]']='13.000';
        $form['form[address][geos][lng]']='-13.000';
        $form['form[company][name]']='test';
        $form['form[company][catchPhrase]']='test test test';
        $form['form[company][bs]']='test test';

        $this->client->submit($form);

        $crawler = $this->client->followRedirect();
        $uri= $this->client->getRequest()->getRequestUri();

        $userRepository = $this->entityManager->getRepository(User::class);
        $userRecord = $userRepository->findOneBy(['name' => 'test']);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals("/", $uri, 'Incorrect path "/" after add user');

        $this->assertEquals('test', $userRecord->getName(), 'User not insert into DB');
        // assert for another value
    }
}
