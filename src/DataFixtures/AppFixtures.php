<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Invoice;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * Password encoding
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');


        for ($k = 0; $k < 10; $k++) {
            $user = new User();

            $invoiceNumber = 1; // For each user, the invoice number get back to the first number
            $hash = $this->encoder->hashPassword($user, 'password');

            $user->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword($hash);

            $manager->persist($user);

            for ($i = 0; $i <= mt_rand(5, 20); $i++) {
                $customer = new Customer();
                $customer->setFirstname($faker->firstName())
                    ->setLastname($faker->lastName)
                    ->setCompany($faker->company)
                    ->setEmail($faker->email)
                    ->setUser($user);

                $manager->persist($customer);

                for ($j = 0; $j <= mt_rand(3, 10); $j++) {
                    $invoice = new Invoice();
                    $invoice->setAmount($faker->randomFloat(2, 250, 5000))
                        ->setSentAt($faker->dateTimeBetween('-6 months'))
                        ->setStatus($faker->randomElement(['SENT', 'PAID', 'CANCELLED']))
                        ->setCustomer($customer)
                        ->setInvoiceNumber($invoiceNumber);

                    $invoiceNumber++; // For each invoice, increase invoice number

                    $manager->persist($invoice);
                }
            }

        }



        $manager->flush();
    }
}
