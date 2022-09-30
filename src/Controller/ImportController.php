<?php

namespace App\Controller;

use App\Controller\Feature\CreateUser;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImportController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param CreateUser $createUser Add users with address and company to DB.
     */
    #[Route('/import', name: 'user_import')]
    public function importUser(CreateUser $createUser): Response
    {
        $url= 'https://jsonplaceholder.typicode.com/users';
        
        $response = $this->client->request(
            'GET',
            $url
        );

        $content = $response->getContent();
        $content = $response->toArray();

        foreach($content as $row) {
            $arrayResponse = [
                'Uname' => $row['name'],
                'UuserName' => $row['username'],
                'Uemail' => $row['email'],
                'Uphone' => $row['phone'],
                'Uwebsite' => $row['website'],

                'Astreet' => $row['address']['street'],
                'Asuite' => $row['address']['suite'],
                'Acity' => $row['address']['city'],
                'Azipcode' => $row['address']['zipcode'],

                'AGlat' => $row['address']['geo']['lat'],
                'AGlng' => $row['address']['geo']['lng'],

                'Cname' => $row['company']['name'],
                'CcatchPhrase' => $row['company']['catchPhrase'],
                'Cbs' => $row['company']['bs'], 
            ];
            $createUser->create($arrayResponse);
        }

        return $this->redirectToRoute('home');
    }
}
