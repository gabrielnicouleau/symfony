<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Commentary;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        $users = [];
        $categories = [];
        $articles = [];

        // creation des utilisateurs
        for ($i=0; $i < 25; $i++) { 
            $user = new User();
            $user
                ->setFirstname($faker->firstName('male'|'female'))
                ->setLastname($faker->lastName())
                ->setEmail($user->getFirstname() . '.'. $user->getLastName() . '@' . $faker->freeEmailDomain())
                ->setPassword($this->hasher->hashPassword($user, '1234'))
                ->setAvatar($faker->imageUrl(640, 480, 'animals', true))
                ->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $users[] = $user; // Ajouter l'utilisateur au tableau
        }

        // creation des catégories
        for ($i=0; $i < 30; $i++) { 
            $categorie = new Category();
            $categorie
                ->setLabel($faker->word());
            $manager->persist($categorie);
            $categories[] = $categorie; // Ajouter la catégorie au tableau
        }

        // creation des articles
        for ($i=0; $i < 100; $i++) { 
            $article = new Article();
            $article
                ->setTitle($faker->words(3, true))
                ->setContent($faker->text(400))
                ->setCreateAt(\DateTimeImmutable::createFromMutable($faker->dateTime())) // Convertir DateTime en DateTimeImmutable
                ->setUser($faker->randomElement($users));

            // Associer trois catégories aléatoires
            $randomCategories = $faker->randomElements($categories, 3);
            foreach ($randomCategories as $category) {
                $article->addCategory($category);
            }

            $manager->persist($article);
            $articles[] = $article; // Ajouter l'article au tableau
        }

        // creation des commentaires
        foreach ($articles as $article) {
            for ($i=0; $i < 10; $i++) {
                $commentary = new Commentary();
                $commentary
                    ->setContent($faker->sentence())
                    ->setCreateAt(\DateTimeImmutable::createFromMutable($faker->dateTime())) // Convertir DateTime en DateTimeImmutable
                    ->setArticle($article)
                    ->setUser($faker->randomElement($users));
                $manager->persist($commentary);
            }
        }

        //dd($manager);
        $manager->flush();
    }
}
