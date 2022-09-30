<?php

namespace App\Controller\Feature;
use App\Entity\Company;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Add Company of User to DB
 */
class CreateCompany
{
    public function __construct(private ManagerRegistry $doctrine)
    {}

    public function create($nameCompany, $catchPhrase, $bs): Company
    {
        $entityManager = $this->doctrine->getManager();
        $company = new Company();

        $company->setName($nameCompany);
        $company->setCatchPhrase($catchPhrase);
        $company->setBs($bs);

        $entityManager->persist($company);
        $entityManager->flush();
        return $company;
    }
}
