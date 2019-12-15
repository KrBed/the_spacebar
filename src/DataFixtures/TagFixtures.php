<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TagFixtures extends BaseFixture
{

    protected function loadData(ObjectManager $manager)
    {
        /** @var $tag Tag */
        $this->createMany(TAg::class,10,function(Tag $tag){
            $tag->setName($this->faker->realText(20));
        });
    }
}
