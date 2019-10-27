<?php

namespace App\DataFixtures;

use App\Entity\SecteurActivite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SectorActivityFixtures extends Fixture
{

    private $activities;
    private $bovins;

    public function __construct()
    {
        $this->activities = ['bovins','veaux', 'maigres', 'elev. & reprod.', 'boucherie', 'ovins', 'porcins', 'equins', 'caprins','volailles'];
        $this->bovins = ['veaux', 'maigres', 'elev. & reprod.', 'boucherie'];
    }

    public function load(ObjectManager $manager)
    {

        foreach ($this->activities as $value) {

            $sectorActivity = new SecteurActivite();
            $sectorActivity->setNom($value);
            if (\in_array($value, $this->bovins, true)) {
                $sectorActivity->setActiviteParente(0);
            }

            $manager->persist($sectorActivity);
        }

        $manager->flush();
    }
}
