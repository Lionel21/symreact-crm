<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Invoice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');


        for ($i = 0; $i <= 30; $i++) {
            $customer = new Customer();
            $customer->setFirstname($faker->firstName())
                ->setLastname($faker->lastName)
                ->setCompany($faker->company)
                ->setEmail($faker->email);

            $manager->persist($customer);

            for ($j = 0; $j <= mt_rand(3, 10); $j++) {
                $invoice = new Invoice();
                $invoice->setAmount($faker->randomFloat(2, 250, 5000))
                    ->setSentAt($faker->dateTimeBetween('-6 months'))
                    ->setStatus($faker->randomElement(['SENT', 'PAID', 'CANCELLED']))
                    ->setCustomer($customer);

                $manager->persist($invoice);
            }
        }
        $manager->flush();
    }
}
