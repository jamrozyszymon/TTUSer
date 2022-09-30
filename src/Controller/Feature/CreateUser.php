<?php

namespace App\Controller\Feature;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Add user with address (call function) and company (call function) to DB
 */
class CreateUser
{
    public function __construct(
        private ManagerRegistry $doctrine, 
        private CreateCompany $createCompany,
        private CreateAddress $createAddress
    )
    {}
    
    /**
     * @param array $dataInput Data from request or response
     */
    public function create(array $dataInput): void
    {
        $entityManager = $this->doctrine->getManager();
        $user = new User();

        $company = $this->createCompany->create($dataInput['Cname'], $dataInput['CcatchPhrase'], $dataInput['Cbs']);
        $address = $this->createAddress->create($dataInput['Astreet'], $dataInput['Asuite'], $dataInput['Acity'], $dataInput['Azipcode'], $dataInput['AGlat'], $dataInput['AGlng']);

        $user->setName($dataInput['Uname']);
        $user->setUsername($dataInput['UuserName']);
        $user->setEmail($dataInput['Uemail']);
        $user->setPhone($dataInput['Uphone']);
        $user->setWebsite($dataInput['Uwebsite']);
        $user->setCompanies($company);
        $user->setAddress($address);

        $entityManager->persist($user);
        $entityManager->flush();
    }

}
