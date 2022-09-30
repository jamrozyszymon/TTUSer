<?php

namespace App\Controller\Feature;

use App\Entity\Address;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Add Adress of User with geographic coordinates (call function) to DB
 */
class CreateAddress
{
    public function __construct(
        private ManagerRegistry $doctrine,
        private CreateGeo $createGeo
        )
    {}

    public function create($street, $suite, $city, $zipCode, $lat, $lng,): Address
    {
        $entityManager = $this->doctrine->getManager();
        $address = new Address();

        $geo= $this->createGeo->create($lat, $lng);

        $address->setStreet($street);
        $address->setSuite($suite);
        $address->setCity($city);
        $address->setZipcode($zipCode);

        $address->setGeos($geo);

        $entityManager->persist($address);
        $entityManager->flush();

        return $address;

    }
}
