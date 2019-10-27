<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 27/02/2019
 * Time: 23:38
 */

namespace App\Form\Handler;


use App\Entity\Region;
use App\Service\RegionManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class RegionHanlder
{
    private $regionManager;


    /**
     * RegionHanlder constructor.
     * @param RegionManager $regionManager
     */
    public function __construct(RegionManager $regionManager)
    {
        $this->regionManager = $regionManager;
    }

    public function handle(Form $form,  Request $request)
    {

        /** @var Region $region */
        $region = $form->getData();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->regionManager->create($region);

            return true;
        }
        return false;
    }
}