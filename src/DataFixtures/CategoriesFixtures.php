<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
;

// class CategoriesFixtures extends Fixture
// {
//      public function __construct(private SluggerInterface $slugger){
//  }
 
//     public function load(ObjectManager $manager): void
//     {
       
//         { $parent = new Categories();
//         $parent->setName('Informatique');
//         $parent->setSlug($this->slugger->slug($parent->getName())->lower());
//         $manager->persist($parent);

//         $category = new Categories();
//         $category->setName('Ordinateurs portables');
//         $category->setSlug($this->slugger->slug($category->getName())->lower());
//         $category->setParent($parent);

//         $manager->persist($category);
//         $manager->flush();}
       
//     }
 
// }

class CategoriesFixtures extends Fixture
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $parent1 = $this->createCategory($manager, 'Informatique');
        $parent2 = $this->createCategory($manager, 'Électroménager');

        $this->createCategoryWithParent($manager, 'Ordinateurs portables', $parent1);
        $this->createCategoryWithParent($manager, 'Composants', $parent1);
        $this->createCategoryWithParent($manager, 'Stockage', $parent1);

        $this->createCategoryWithParent($manager, 'Lave-linge', $parent2);
        $this->createCategoryWithParent($manager, 'Réfrigérateurs', $parent2);
        $this->createCategoryWithParent($manager, 'Aspirateurs', $parent2);

        $manager->flush();
    }

    private function createCategory(ObjectManager $manager, string $name): Categories
    {
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($name)->lower());
        $manager->persist($category);

        return $category;
    }

    private function createCategoryWithParent(ObjectManager $manager, string $name, Categories $parent): void
    {
        $category = $this->createCategory($manager, $name);
        $category->setParent($parent);
    }
}