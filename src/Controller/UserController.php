<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\UserType;
use App\Form\CompanyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\User;

use App\Controller\Feature\CreateUser;
use App\Form\AddressType;

class UserController extends AbstractController
{
    /**
     * Table with list of users.
     */
    #[Route('/user/list', name: 'user_list')]
    public function displayUser(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository(User::class)->findAll();

        return $this->render('user-list.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * Create form for add User.
     * @param CreateUser $createUser Add users with address and company to DB.
     */
    #[Route('/user/add', name: 'user_add')]
    public function addUser(Request $request, CreateUser $createUser): Response
    {
        $form = $this->createFormBuilder()
        ->add('user', UserType::class, ['label'=>'Użytkownik'])
        ->add('address', AddressType::class, ['label'=>'Adres'])
        ->add('company', CompanyType::class, ['label'=>'Firma'])
        ->add('Dodaj', SubmitType::class)
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $arrayRequest = [
                'Uname' => $request->get('form')['user']['name'],
                'UuserName' => $request->get('form')['user']['username'],
                'Uemail' => $request->get('form')['user']['email'],
                'Uphone' => $request->get('form')['user']['phone'],
                'Uwebsite' => $request->get('form')['user']['website'],
    
                'Astreet' => $request->get('form')['address']['street'],
                'Asuite' => $request->get('form')['address']['suite'],
                'Acity' => $request->get('form')['address']['city'],
                'Azipcode' => $request->get('form')['address']['zipcode'],
    
                'AGlat' => $request->get('form')['address']['geos']['lat'],
                'AGlng' => $request->get('form')['address']['geos']['lng'],
    
                'Cname' => $request->get('form')['company']['name'],
                'CcatchPhrase' => $request->get('form')['company']['catchPhrase'],
                'Cbs' => $request->get('form')['company']['bs'],
                ];

            $createUser->create($arrayRequest);

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('user-add.html.twig', [
            'form' => $form
        ]);
    }
}
