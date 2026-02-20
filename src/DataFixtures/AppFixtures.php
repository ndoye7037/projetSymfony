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
            $user = new User();
            $user->setEmail($faker->email);
            $hashedPassword = $this->passwordHasher->hashPassword($user, "password");
            $user->setPassword($hashedPassword);

            $manager->persist($user);

            $recipe = new Recipe();

            $recipe->setTitle($faker->sentence(3));
            $recipe->setDescription($faker->paragraph);
            $recipe->setIngredients($faker->text);
            $recipe->setSteps($faker->text);

            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
