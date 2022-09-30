<?php

namespace App\Controller\Feature;

use App\Entity\Geo;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Add Geographic coordinates to DB
 */
class CreateGeo
{
    public function __construct(private  ManagerRegistry $doctrine)
    {}

    public function create($lat, $lng): Geo
    {
        $entityManager = $this->doctrine->getManager();
        $geo = new Geo();

        $geo->setLat($lat);
        $geo->setLng($lng);

        $entityManager->persist($geo);
        $entityManager->flush();

        return $geo;
    }
}
