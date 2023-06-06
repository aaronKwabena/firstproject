<?php

namespace App\DataFixtures;

use App\Entity\Igredient;
use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;


    public function __construct()
    {
       $this->faker = Factory::create('fr_FR'); 
    }

    public function load(ObjectManager $manager): void
    {
        //Ingédients
        $igredients = [];
        for ($i=0; $i<50; $i++){
            $igredient = new Igredient();
            $igredient ->setName($this->faker->word())
                        ->setPrice(mt_rand(0,100));

            $igredients[] = $igredient;
            $manager->persist($igredient);  
        }

        //Recipes
        for ($j = 0; $j < 25; $j++){
            $recipe = new Recipe();
            $recipe->setName($this->faker->word())
                    ->setTime(mt_rand(0, 1) == 1 ? mt_rand(1, 1440) : null)
                    ->setNbPeople(mt_rand(0, 1) == 1 ? mt_rand(1, 50) : null)
                    ->setDifficulty(mt_rand(0, 1) == 1 ? mt_rand(1, 5) : null)
                    ->setDescription($this->faker->text(300))
                    ->setPrice(mt_rand(0, 1) == 1 ? mt_rand(1, 1000) : null)
                    ->setIsFavorite(mt_rand(0, 1) == 1 ? true : false);
            
            for ($k=0; $k < mt_rand(5, 15); $k++){
                    $recipe->addIgredient($igredients[mt_rand(0, count($igredients)-1)]);
            }
            $manager->persist($recipe);
        }
        //Users
        for ($i=0; $i <10; $i++){
            $user = new User();
            $user -> setName($this->faker->name())
                ->setPseudo(mt_rand(0, 1)===1 ? $this->faker->firstName():null)
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');
            
               
               
            $manager->persist($user);   

        } 
            
        $manager->flush();
    }
}
