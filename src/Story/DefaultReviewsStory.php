<?php

namespace App\Story;

use App\Factory\ReviewFactory;
use Zenstruck\Foundry\Story;

final class DefaultReviewsStory extends Story
{
    public function build(): void
    {
        // TODO build your story here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#stories)
        ReviewFactory::createMany(200);
    }
}
