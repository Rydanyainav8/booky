<?php

namespace App\DataFixtures;

use App\Story\DefaultBooksStory;
use App\Story\DefaultReviewsStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        DefaultBooksStory::load();
        DefaultReviewsStory::load();
        $manager->flush();
    }
}
