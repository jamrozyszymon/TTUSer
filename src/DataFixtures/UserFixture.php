<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Address;
use App\Entity\Geo;
use App\Entity\Company;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<=10; $i++ ) {
            $user = new User();
            $address = new Address();
            $geo = new Geo();
            $company = new Company();

            $user->setName('User'.$i);
            $user->setUsername('username'.$i);
            $user->setEmail('user'.$i.'@user.com');
            $user->setPhone($i.'123123123');
            $user->setWebsite('web'.$i.'@com');

            $user->setCompanies($company);
            $user->setAddress($address);

            $address->setStreet('Street'.$i);
            $address->setSuite($i);
            $address->setCity('City'.$i);
            $address->setZipcode($i.'-'.$i.'00');
    
            $address->setGeos($geo);

            $geo->setLat($i.$i.'000');
            $geo->setLng('-'.$i.$i.'000');
    
            $company->setName('Company'.$i);
            $company->setCatchPhrase('Lorem Ipsum is simply dummy text of the printing and typesetting industry');
            $company->setBs('Lorem Ipsum is simply dummy');

            $manager->persist($user);
            $manager->persist($address);
            $manager->persist($geo);
            $manager->persist($company);

            $manager->flush();
        }
    }
}
