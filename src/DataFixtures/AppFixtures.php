<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 5; $i++) {
            $user = new User($this->passwordHasher);
            $user->setEmail($faker->email())->setPassword("password");
            $manager->persist($user);

            $recipe = new Recipe();
            $recipe->setTitle($faker->name())->setContent($faker->text())->setPublishedAt($faker->dateTime());
            $manager->persist($recipe);
        }
        $manager->flush();
    }
}
