<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Bundle to manage file and directories
        $finder = new Finder();
        $finder->in(realpath(__DIR__.'/../../data'));
        $finder->name('data_science.sql');

        foreach( $finder as $file ){
            $content = $file->getContents();

            $stmt = $manager->getConnection()->prepare($content);
            $stmt->execute();
        }

    }
}
