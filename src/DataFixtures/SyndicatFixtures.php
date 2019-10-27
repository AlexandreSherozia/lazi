<?php

namespace App\DataFixtures;

use App\Entity\Syndicat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SyndicatFixtures extends Fixture
{

    private $syndicatsNoms;

    /**
     * Syndicat constructor.
     * @param $syndicatsNoms
     */
    public function __construct()
    {
        $this->syndicatsNoms = ["Syndicat de Ain et de la Haute Savoie","Syndicat de Aisne",
            "Syndicat de l'Allier","Syndicat des Ardennes et de la Marne","Syndicat de la Haute Garonne et de Ariege",
            "Syndicat de l'Aveyron","Syndicat du Calvados et de la Manche","Syndicat du Cantal",
            "Syndicat de le Charente Maritime","Syndicat du Cher","Fédération régionale du Limousin",
            "Syndicat des Commerçants en bestiaux de Bourgogne","Syndicat des Côtes d'Armor du Finistère et Ille et Vilaine",
            "Syndicat de la Dordogne", "Association Franc Comptoise Doubs Jura Haute Saone"];
    }


    public function load(ObjectManager $manager)
    {

        foreach ($this->syndicatsNoms as $name) {

            $syndicat = new Syndicat();

            $syndicat->setNom($name);

            $manager->persist($syndicat);
        }

        $manager->flush();
    }

}
